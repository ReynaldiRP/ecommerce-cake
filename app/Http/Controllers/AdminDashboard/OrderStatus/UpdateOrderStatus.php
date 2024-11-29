<?php

namespace App\Http\Controllers\AdminDashboard\OrderStatus;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UpdateOrderStatus extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $orderId): JsonResponse
    {
        try {
            $data = $request->validate([
                'status' => 'required'
            ], [
                'status.required' => 'Status pemesanan harus diisi'
            ]);


            $order = Order::findorFail($orderId);
            $order->update($data);

            return response()->json([
                'message' => 'Berhasil merubah status pesanan',
                'order' => $order
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
