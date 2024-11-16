<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowAllPaymentController extends Controller
{
    /**
     * Display a paginated list of payments.
     *
     * This method retrieves a paginated list of payments, transforms the payment data,
     * and renders the 'AdminDashboard/Payment/Index' view with the transformed payments.
     *
     * @return Response The response containing the rendered view with the payments' data.
     */
    public function __invoke(Request $request, Payment $payment): Response
    {
        $payments = Payment::with('order')->orderBy('created_at', 'desc')->paginate(5);

        // Transform the payments
        $payments->getCollection()->transform(function ($payment) {
            return [
                'transaction_id' => $payment->transaction_id,
                'order_code' => $payment->order->order_code,
                'payment_method' => $payment->payment_method,
                'payment_status' => $payment->payment_status,
                'payment_created_at' => $payment->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss'),
                'payment_paid_at' => $payment->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss'),
            ];
        });

        return Inertia::render('AdminDashboard/Payment/Index', [
            'payments' => $payments,
        ]);
    }
}
