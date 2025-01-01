<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetNotificationOrderStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        // Get the payment and order status history
        $statusHistory = Order::with(['payment', 'payment.paymentStatusHistories', 'orderStatusHistories'])
            ->where('user_id', $request->user()->id)
            ->get();

        // Mapping the payment and order status history
        $statusHistory = $statusHistory->map(function ($status) {
            return [
                'order_statuses' => $status->orderStatusHistories->map(function ($item) {
                    return [
                        'status' => $item->status,
                        'description' => $item->description,
                        'created_at' => Carbon::parse($item->created_at)->diffForHumans(),
                    ];
                }),
                'payment_statuses' => $status->payment?->paymentStatusHistories->map(function ($item) {
                    return [
                        'status' => $item->status,
                        'description' => $item->description,
                        'created_at' => Carbon::parse($item->created_at)->diffForHumans(),
                    ];
                }),
            ];
        });


        return response()->json($statusHistory);
    }
}
