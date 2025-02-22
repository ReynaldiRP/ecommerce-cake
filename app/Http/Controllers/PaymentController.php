<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShoppingChart\StoreShoppingChartRequest;
use App\Mail\PaymentEmail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Payment;
use App\Models\PaymentStatusHistory;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;
use Midtrans\Config;
use Midtrans\Notification;

class PaymentController extends Controller
{
    /**
     * Midtrans Webhook.
     *
     * This controller is responsible for handling Midtrans's webhook notification.
     * When a payment status is changed, Midtrans will send a notification to
     * this endpoint.
     *
     * @return HttpResponse
     */
    public function midtransWebhook(): HttpResponse
    {
        try {
            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$isProduction = config('services.midtrans.isProduction');

            $notification = new Notification();
            $transaction_status = $notification->transaction_status;

            // Log the parsed notification data
            Log::channel('midtrans')->info('Parsed Midtrans Notification', [
                'order_id' => $notification->order_id,
                'transaction_id' => $notification->transaction_id,
                'transaction_status' => $transaction_status,
                'gross_amount' => $notification->gross_amount,
                'payment_type' => $notification->payment_type,
            ]);

            // Find the order based on the order_id
            $order = Order::query()->where('order_code', $notification->order_id)->firstOrFail();

            // Check if the payment already exists for this order
            $payment = Payment::query()->where('order_id', $order->id)->first();

            // If no existing payment is found, create a new Payment
            if (empty($payment)) {
                $payment = new Payment();
                $payment->order_id = $order->id;
                $payment->transaction_id = $notification->transaction_id;
                $payment->payment_method = $notification->payment_type;
            }

            $paymentStatus = [
                'Menunggu pembayaran' => 'Sistem sedang menunggu pembayaran dari pembeli',
                'Pesanan terbayar' => 'Pembayaran telah diterima oleh sistem',
                'Pembayaran kedaluwarsa' => 'Pembayaran tidak diterima oleh sistem dalam waktu yang ditentukan',
                'Pembayaran dibatalkan' => 'Pembayaran dibatalkan oleh pembeli',
            ];

            // Update the payment status based on the transaction status
            if ($transaction_status == 'pending') {
                $payment->payment_status = 'Menunggu pembayaran';
            } elseif ($transaction_status == 'settlement') {
                $payment->payment_status = 'Pesanan terbayar';
            } elseif ($transaction_status == 'expire') {
                $payment->payment_status = 'Pembayaran kedaluwarsa';
                // set status order to expired
                $order->status = 'Pesanan kadaluwarsa';
                $order->save();
            } elseif ($transaction_status == 'cancel') {
                $payment->payment_status = 'Pembayaran dibatalkan';
                // set status order to canceled
                $order->status = 'Pesanan dibatalkan';
                $order->save();
            }

            // Save the payment (whether new or updated)
            $payment->save();

            // Save the payment status history
            $paymentStatusHistory = PaymentStatusHistory::create([
                'payment_id' => $payment->id,
                'status' => $payment->payment_status,
                'description' => $paymentStatus[$payment->payment_status]
            ]);

            // Send email notification
            Mail::to($order->user->email)->send(new PaymentEmail($order, $payment));

            return response('OK', 200);
        } catch (Exception $e) {
            Log::channel('midtrans')->error('Midtrans Notification Error: ' . $e->getMessage());
            return response('Error', 500);
        }
    }



    /**
     * Cancel an order by its ID.
     *
     * This method sends a POST request to the Midtrans API to cancel an order.
     * It uses the Guzzle HTTP client to make the request.
     *
     * @param string $orderId The ID of the order to be canceled.
     * @return JsonResponse A JSON response indicating the result of the cancellation.
     * @throws GuzzleException
     */
    public function cancelOrder(string $orderId): JsonResponse
    {
        try {
            $client = new Client();
            $response = $client->request('POST', "https://api.sandbox.midtrans.com/v2/$orderId/cancel", [
                'headers' => [
                    'accept' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode(config('services.midtrans.serverKey') . ':'),
                ],
            ]);

            $responseBody = json_decode($response->getBody()->getContents());

            // Check if user canceled the order before choose payment method
            if ($responseBody->status_code == '404') {
                // Manually set order status to cancel
                $order = Order::query()->where('order_code', $orderId)->firstOrFail();

                if (!$order) {
                    return response()->json([
                        'message' => 'Order not found.',
                    ], 404);
                }

                $order->status = 'Pesanan dibatalkan';
                $order->save();

                // Save the order status history
                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'status' => $order->status,
                    'description' => 'Pesanan dibatalkan oleh pembeli'
                ]);

                return response()->json([
                    'message' => 'Order has been canceled successfully.',
                    'data' => $order,
                ]);
            } else {
                // save the order status to canceled
                $order = Order::query()->where('order_code', $orderId)->firstOrFail();
                $order->status = 'Pesanan dibatalkan';
                $order->save();

                // Save the order status history
                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'status' => $order->status,
                    'description' => 'Pesanan dibatalkan oleh pembeli'
                ]);

                return response()->json([
                    'message' => 'Order has been canceled successfully.',
                    'data' => $responseBody,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while canceling the order.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the transaction history of the authenticated user.
     *
     * @return Response
     */
    public function transactionHistory(): Response
    {
        // Get all orders with payment details from the authenticated user
        $orderItems = OrderItem::with([
            'order.payment',  // Include payment relationship through order
            'cake',
            'cakeSize',
            'cakeFlavour',
            'cakeTopping'
        ])
            ->whereHas('order', function ($query) {
                $query->where('user_id', auth()->id());
            });

        // Paginate the results
        $orderItems = $orderItems->orderBy('created_at', 'desc')->paginate(5);


        // Transform the order items
        $orderItems->getCollection()->transform(function ($item) {
            return [
                'transaction_id' => $item->order?->payment?->transaction_id,
                'order_code' => $item->order?->order_code,
                'order_item_id' => $item->id,
                'order_status' => $item->order?->status,
                'transaction_status' => $item->order?->payment?->payment_status,
                'cake_name' => $item->cake?->name,
                'cake_price' => $item->cake?->base_price,
                'cake_size' => $item->cakeSize?->size,
                'cake_size_price' => $item->cakeSize?->price,
                'cake_flavour' => $item->cakeFlavour?->name,
                'cake_flavour_price' => $item->cakeFlavour?->price,
                'cake_toppings' => $item->cakeTopping?->pluck('name'),
                'cake_toppings_price' => $item->cakeTopping?->sum('price'),
                'quantity' => $item->quantity,
                'cake_image' => $item->cake?->image_url,
                'cake_note' => $item->note,
                'price' => $item->price,
                'payment_url' => $item->order?->payment_url,
                'order_created_at' => $item->created_at->isoFormat('dddd, D MMMM Y'),
                'order_updated_at' => $item->updated_at->isoFormat('dddd, D MMMM Y')
            ];
        });



        return Inertia::render('OrderHistorySection', [
            'orderItems' => $orderItems,
        ]);
    }

    /**
     * Fetch filtered data for transaction history.
     *
     * This method retrieves order items based on the provided query parameters for filtering.
     * It supports filtering by status and date (month in Indonesian).
     *
     * @param Request $request The HTTP request instance.
     *
     * @return JsonResponse A JSON response containing the filtered order items.
     */
    public function fetchFilteredDataTransactionHistory(Request $request): JsonResponse
    {
        // Get query parameters for filtering
        $status = $request->query('status', 'All');
        $date = $request->query('date', '');

        // Map Indonesian months to their respective month numbers
        $indonesianMonths = [
            'Januari' => 1,
            'Februari' => 2,
            'Maret' => 3,
            'April' => 4,
            'Mei' => 5,
            'Juni' => 6,
            'Juli' => 7,
            'Agustus' => 8,
            'September' => 9,
            'Oktober' => 10,
            'November' => 11,
            'Desember' => 12,
        ];

        // Get the month number from the date parameter if it exists
        $month = $date && isset($indonesianMonths[$date]) ? $indonesianMonths[$date] : null;

        // Build the query for order items
        $query = OrderItem::with([
            'order.payment',
            'cake',
            'cakeSize',
            'cakeFlavour',
            'cakeTopping'
        ])->whereHas('order', function ($q) use ($status, $month) {
            $q->where('user_id', auth()->id())->orderBy('created_at', 'desc');

            if ($status !== 'All') {
                if ($status === 'Berjalan') {
                    $q->whereHas('payment', function ($q) {
                        $q->where('payment_status', 'menunggu pembayaran');
                    });
                } elseif ($status === 'Sukses') {
                    $q->whereHas('payment', function ($q) {
                        $q->where('payment_status', 'Pesanan terbayar');
                    });
                } elseif ($status === 'Gagal') {
                    $q->whereHas('payment', function ($q) {
                        $q->where('payment_status', 'pembayaran dibatalkan')
                            ->orWhere('payment_status', 'pembayaran kedaluwarsa');
                    });
                }
            }

            if ($month) {
                $q->whereMonth('created_at', '=', $month);
            }

        });

        // Paginate the results
        $orderItems = $query->orderBy('created_at', 'desc')->paginate(5);


        // Transform the order items
        $orderItems->getCollection()->transform(function ($item) {
            return [
                'transaction_id' => $item->order?->payment?->transaction_id,
                'order_code' => $item->order?->order_code,
                'order_item_id' => $item->id,
                'order_status' => $item->order?->status,
                'transaction_status' => $item->order?->payment?->payment_status,
                'cake_name' => $item->cake?->name,
                'cake_price' => $item->cake?->base_price,
                'cake_size' => $item->cakeSize?->size,
                'cake_size_price' => $item->cakeSize?->price,
                'cake_flavour' => $item->cakeFlavour?->name,
                'cake_flavour_price' => $item->cakeFlavour?->price,
                'cake_toppings' => $item->cakeTopping?->pluck('name'),
                'cake_toppings_price' => $item->cakeTopping?->sum('price'),
                'cake_image' => $item->cake?->image_url,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'payment_url' => $item->order?->payment_url,
                'order_created_at' => $item->order?->created_at?->isoFormat('dddd, D MMMM Y'),
                'order_updated_at' => $item->order?->updated_at?->isoFormat('dddd, D MMMM Y')
            ];
        });


        return response()->json([
            'orderItems' => $orderItems,
        ]);
    }

    /**
     * Display the details of a transaction based on the provided order code.
     *
     * @param string $orderCode The unique code of the order to retrieve details for.
     * @return Response The response containing the order details.
     */
    public function detailTransaction(string $orderCode): Response
    {
        // Get the order details based on the order code
        $orders = Order::with([
            'orderItems',
            'orderItems.cake',
            'orderItems.cakeSize',
            'orderItems.cakeFlavour',
            'orderItems.cakeTopping',
            'payment'
        ])
            ->where('order_code', $orderCode)->get();


        // Transform the order items
        $orderItems = $orders->map(function ($order) {
            // Calculate the total price for each item
            $totalPriceEachItem = $order->orderItems->map(function ($item) {
                return $item->cake?->base_price + $item->cakeSize?->price + $item->cakeFlavour?->price + $item->cakeTopping?->sum('price');
            });

            return [
                'order_id' => $order->id,
                'payment_id' => $order->payment?->id,
                'order_code' => $order->order_code,
                'order_status' => $order->status,
                'transaction_status' => $order->payment?->payment_status,
                'payment_method' => $order->payment?->payment_method,
                'payment_url' => $order->payment?->payment_url,
                'total_price' => $order->total_price,
                'order_created_at' => $order->created_at?->isoFormat('dddd, D MMMM Y'),
                'order_updated_at' => $order->updated_at?->isoFormat('dddd, D MMMM Y'),
                'estimated_delivery' => \Carbon\Carbon::parse($order->estimated_delivery_date)->isoFormat('dddd, D MMMM Y'),
                'method_delivery' => $order->method_delivery,
                'order_items' => $order->orderItems->map(function ($item) use ($totalPriceEachItem) {
                    return [
                        'cake_name' => $item->cake?->name,
                        'cake_image' => $item->cake?->image_url,
                        'cake_size' => $item->cakeSize?->size,
                        'cake_flavour' => $item->cakeFlavour?->name,
                        'cake_toppings' => $item->cakeTopping?->pluck('name'),
                        'quantity' => $item->quantity,
                        'price' => $totalPriceEachItem,
                    ];
                })
            ];
        });

        // get id order
        $orderId = $orderItems->first()['order_id'];

        // Get the payment and order status history
        $statusHistory = Order::with(['payment', 'payment.paymentStatusHistories', 'orderStatusHistories'])
            ->where('id', $orderId)
            ->get();


        // Mapping the payment and order status history
        $statusHistory = $statusHistory->map(function ($status) {
            return [
                'order_statuses' => $status->orderStatusHistories->map(function ($item) {
                    return [
                        'status' => $item->status,
                        'description' => $item->description,
                        'created_at' => Carbon::parse($item->created_at)->translatedFormat('H.i:s, d F Y'),
                    ];
                }),
                'payment_statuses' => $status->payment?->paymentStatusHistories->map(function ($item) {
                    return [
                        'status' => $item->status,
                        'description' => $item->description,
                        'created_at' => Carbon::parse($item->created_at)->translatedFormat('H.i:s, d F Y'),
                    ];
                }),
            ];
        });


        return Inertia::render('OrderStatusSection', [
            'orders' => $orderItems,
            'statusHistory' => $statusHistory,
        ]);
    }

    /**
     * Buy again cake order.
     *
     * This method allows the user to buy the same cake order again.
     *
     * @param string $orderItem
     * @return JsonResponse A JSON response indicating the result of the operation.
     */
    public function buyAgainCakeOrder(string $orderItem): JsonResponse
    {
        try {
            $orderItem = OrderItem::query()->where('id', $orderItem)->firstOrFail();


            $orderItems = collect([$orderItem])->map(function ($item) {
                return [
                    'cake_id' => $item->cake_id,
                    'cake_flavour_id' => $item->cake_flavour_id,
                    'cake_size_id' => $item->cake_size_id,
                    'toppings' => $item->cakeTopping->pluck('id')->toArray(),
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ];
            });


            foreach ($orderItems as $orderItem) {
                $request = new StoreShoppingChartRequest();
                $request->merge($orderItem);

                $shoppingChartController = new ShoppingChartController();
                $response = $shoppingChartController->addChartItem($request);

                // If the response is successful, add it to our results
                if ($response->getStatusCode() === 200) {
                    $addedItems[] = json_decode($response->getContent(), true);
                }
            }

            return response()->json([
                'message' => 'Buy again cake order successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while adding items to the cart.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
