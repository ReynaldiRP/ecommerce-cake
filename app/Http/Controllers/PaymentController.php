<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Inertia\Response;
use App\Models\Payment;
use App\Models\OrderItem;
use App\Mail\PaymentEmail;
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
     * @return \Illuminate\Http\Response
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
            $order = Order::where('order_code', $notification->order_id)->firstOrFail();

            // Check if the payment already exists for this order
            $payment = Payment::where('order_id', $order->id)->first();

            // If no existing payment is found, create a new Payment
            if (empty($payment)) {
                $payment = new Payment();
                $payment->order_id = $order->id;
                $payment->transaction_id = $notification->transaction_id;
                $payment->payment_method = $notification->payment_type;
            }


            // Update the payment status based on the transaction status
            if ($transaction_status == 'pending') {
                $payment->payment_status = 'pending';
            } elseif ($transaction_status == 'settlement') {
                $payment->payment_status = 'paid';
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
     * @return Inertia\Response\Response
     */
    public function transactionHistory(): Response
    {
        // Get all orders with payment details from the authenticated user
        $orderItems = OrderItem::with([
            'order.payment',  // Include payment relationship through order
            'cake',
            'cakeFlavour',
            'cakeTopping'
        ])
            ->whereHas('order', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->paginate(5);

        $orderItems->through(function ($item) {
            return [
                'transaction_id' => $item->order?->payment?->transaction_id,
                'order_code' => $item->order?->order_code,
                'order_status' => $item->order?->status,
                'transaction_status' => $item->order?->payment?->payment_status,
                'cake_name' => $item->cake?->name,
                'cake_flavour' => $item->cakeFlavour?->name,
                'cake_toppings' => $item->cakeTopping?->pluck('name'),
                'quantity' => $item->quantity,
                'price' => $item->price,
                'payment_url' => $item->order?->payment_url,
                'order_created_at' => $item->order?->created_at?->isoFormat('dddd, D MMMM Y'),
                'order_updated_at' => $item->order?->updated_at?->isoFormat('dddd, D MMMM Y')
            ];
        });

        // Filter order items based on the transaction status or order status when click the tab button
        if (request()->has('status')) {
            $orderItems = $orderItems->filter(function ($item) {
                return $item['transaction_status'] === request('status');
            });
        }

        return Inertia::render('OrderHistorySection', [
            'orderItems' => $orderItems,
        ]);
    }

    /**
     * Display the details of a transaction based on the provided order code.
     *
     * @param string $orderCode The unique code of the order to retrieve details for.
     * @return \Illuminate\Http\Response The response containing the order details.
     */
    public function detailTransaction($orderCode): Response
    {
        $orders = Order::with([
            'orderItems',
            'orderItems.cake',
            'orderItems.cakeFlavour',
            'orderItems.cakeTopping',
            'payment'
        ])->where('order_code', $orderCode)->get();

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
                'order_items' => $order->orderItems->map(function ($item) {
                    return [
                        'cake_name' => $item->cake?->name,
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
}
