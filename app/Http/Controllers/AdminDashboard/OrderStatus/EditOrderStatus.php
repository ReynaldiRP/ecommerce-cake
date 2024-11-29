<?php

namespace App\Http\Controllers\AdminDashboard\OrderStatus;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EditOrderStatus extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Order $order): JsonResponse
    {
        try {
            $orderStatus = $order->query()->select('id', 'status')->where('id', $order->id)->first();

            return response()->json([
                'message' => 'Success fetch the order status',
                'order' => $orderStatus
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
