<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Mail\PaymentEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    /**
     * Midtrans Webhook.
     *
     * This controller is responsible for handling Midtrans's webhook notification.
     * When a payment status is changed, Midtrans will send a notification to
     * this endpoint.
     *
     * The logic is as follows:
     * 1. Parse the notification data
     * 2. Find the related order based on the order_id
     * 3. Create a new Payment model if the transaction status is pending
     * 4. Update the order status based on the transaction status
     *
     * @return \Illuminate\Http\Response
     */
    public function midtransWebhook()
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
}
