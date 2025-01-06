<?php

namespace App\Http\Controllers\AdminDashboard\OrderStatus;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Carbon\Carbon;
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

            $orderStatus = [
                'Pesanan diproses' => 'Pesanan sedang diproses oleh penjual',
                'Pesanan dikemas' => 'Pesanan sedang dikemas oleh penjual untuk dikirim atau diambil',
                'Pesanan dikirim' => 'Pesanan sedang dalam perjalanan menuju tujuan',
                'Pesanan diterima' => 'Pesanan telah diterima oleh pembeli dan transaksi selesai',
            ];

            // Insert the order status histories table
           $orderStatus =  OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $order->status,
                'description' => $orderStatus[$order->status]
            ]);

            return response()->json([
                'message' => 'Berhasil merubah status pesanan',
                'order' => [
                    'status' => $orderStatus->status,
                    'description' => $orderStatus->description,
                    'created_at' => Carbon::parse($orderStatus->created_at)->translatedFormat('d F Y, H:i:s')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
