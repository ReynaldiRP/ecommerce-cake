<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShoppingChart\StoreShoppingChartRequest;
use Inertia\Inertia;
use App\Models\Order;
use Inertia\Response;
use App\Models\Payment;
use App\Models\OrderItem;
use App\Mail\PaymentEmail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response as HttpResponse;

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
        \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');


        try {
            $notification = new \Midtrans\Notification();
            $transaction_status = $notification->transaction_status;

            // Log the parsed notification data
            Log::channel('midtrans')->info('Parsed Midtrans Notification', [
                'order_id' => $notification->order_id,
                'transaction_id' => $notification->transaction_id,
                'transaction_status' => $notification->transaction_status,
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


            // Update the payment status based on the transaction status
            if ($transaction_status == 'pending') {
                $payment->payment_status = 'menunggu pembayaran';
            } elseif ($transaction_status == 'settlement') {
                $payment->payment_status = 'terbayar';
            } elseif ($transaction_status == 'expire') {
                $payment->payment_status = 'pembayaran kedaluwarsa';
            } elseif ($transaction_status == 'cancel') {
                $payment->payment_status = 'pembayaran dibatalkan';
            }

            // Save the payment (whether new or updated)
            $payment->save();

            // Send email notification
            Mail::to($order->user->email)->send(new PaymentEmail($order, $payment));

            return response('OK', 200);
        } catch (\Exception $e) {
            Log::channel('midtrans')->error('Midtrans Notification Error: ' . $e->getMessage());
            return response('Error', 500);
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
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        // Transform the order items
        $orderItems->getCollection()->transform(function ($item) {
            return [
                'transaction_id' => $item->order?->payment?->transaction_id,
                'order_code' => $item->order?->order_code,
                'order_item_id' => $item->id,
                'order_status' => $item->order?->status,
                'transaction_status' => $item->order?->payment?->payment_status,
                'cake_name' => $item->cake?->name,
                'cake_size' => $item->cakeSize?->size,
                'cake_flavour' => $item->cakeFlavour?->name,
                'cake_toppings' => $item->cakeTopping?->pluck('name'),
                'quantity' => $item->quantity,
                'cake_image' => $item->cake?->image_url,
                'cake_note' => $item->note,
                'price' => $item->price,
                'payment_url' => $item->order?->payment_url,
                'order_created_at' => $item->order?->created_at?->isoFormat('dddd, D MMMM Y'),
                'order_updated_at' => $item->order?->updated_at?->isoFormat('dddd, D MMMM Y')
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
            if ($status !== 'All') {
                if ($status === 'Berjalan') {
                    $q->whereHas('payment', function ($q) {
                        $q->where('payment_status', 'menunggu pembayaran');
                    });
                } elseif ($status === 'Sukses') {
                    $q->whereHas('payment', function ($q) {
                        $q->where('payment_status', 'terbayar');
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
                'cake_size' => $item->cakeSize?->size,
                'cake_flavour' => $item->cakeFlavour?->name,
                'cake_toppings' => $item->cakeTopping?->pluck('name'),
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
            'orderItems.cakeFlavour',
            'orderItems.cakeTopping',
            'payment'
        ])->where('order_code', $orderCode)->get();

        // Transform the order items
        $orderItems = $orders->map(function ($order) {
            return [
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
                'order_items' => $order->orderItems->map(function ($item) {
                    return [
                        'cake_name' => $item->cake?->name,
                        'cake_image' => $item->cake?->image_url,
                        'cake_size' => $item->cake?->cakeSize?->size,
                        'cake_flavour' => $item->cakeFlavour?->name,
                        'cake_toppings' => $item->cakeTopping?->pluck('name'),
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                    ];
                })
            ];
        });

        return Inertia::render('OrderStatusSection', [
            'orders' => $orderItems,
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
                    'toppings' => $item->cakeTopping->pluck('id')->toArray(),
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ];
            });


            foreach ($orderItems as $orderItem) {
                $request = new StoreShoppingChartRequest();
                $request->merge($orderItem);

                $shoppingChartController = new ShoppingChartController();
                $response =  $shoppingChartController->addChartItem($request);

                // If the response is successful, add it to our results
                if ($response->getStatusCode() === 200) {
                    $addedItems[] = json_decode($response->getContent(), true);
                }
            }

            return response()->json([
                'message' => 'Buy again cake order successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while adding items to the cart.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the estimated delivery date for a specific order.
     *
     * @param Request $request The HTTP request instance containing the new estimated delivery date.
     * @param string $orderCode The unique code of the order to update.
     * @return JsonResponse A JSON response indicating the result of the operation.
     */
    public function updateCakeOrderEstimation(Request $request, string $orderCode): JsonResponse
    {
        $validated = $request->validate([
            'estimated_delivery_date' => 'required|date|after:' . now()->addDays(2)->toDateString(),
        ]);

        $order = Order::query()->where('order_code', $orderCode)->firstOrFail();
        $order->estimated_delivery_date = $validated['estimated_delivery_date'];
        $order->save();

        return response()->json(['message' => 'Estimation date updated successfully.']);
    }
}
