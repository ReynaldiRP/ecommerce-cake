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
        // Get orders with their latest status changes (last 7 days)
        $orders = Order::with([
            'payment',
            'payment.paymentStatusHistories' => function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(7))
                    ->orderBy('created_at', 'desc');
            },
            'orderStatusHistories' => function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(7))
                    ->orderBy('created_at', 'desc');
            }
        ])
            ->where('user_id', $request->user()->id)
            ->where('created_at', '>=', Carbon::now()->subDays(30)) // Orders from last 30 days
            ->orderBy('created_at', 'desc')
            ->get();

        $notifications = [];
        $statusCounts = [
            'Berjalan' => 0,
            'Sukses' => 0,
            'Gagal' => 0
        ];

        foreach ($orders as $order) {
            // Count status categories
            $this->categorizeOrderStatus($order->status, $statusCounts);

            // Get latest order status changes
            foreach ($order->orderStatusHistories as $statusHistory) {
                $notifications[] = [
                    'id' => uniqid(),
                    'type' => 'order_status',
                    'order_code' => $order->order_code,
                    'status' => $statusHistory->status,
                    'description' => $statusHistory->description,
                    'created_at' => $statusHistory->created_at,
                    'created_at_human' => Carbon::parse($statusHistory->created_at)->diffForHumans(),
                    'order_date' => $order->created_at->format('d M Y'),
                    'is_recent' => Carbon::parse($statusHistory->created_at)->isAfter(Carbon::now()->subHours(24))
                ];
            }

            // Get latest payment status changes
            if ($order->payment) {
                foreach ($order->payment->paymentStatusHistories as $paymentHistory) {
                    $notifications[] = [
                        'id' => uniqid(),
                        'type' => 'payment_status',
                        'order_code' => $order->order_code,
                        'status' => $paymentHistory->status,
                        'description' => $paymentHistory->description,
                        'created_at' => $paymentHistory->created_at,
                        'created_at_human' => Carbon::parse($paymentHistory->created_at)->diffForHumans(),
                        'order_date' => $order->created_at->format('d M Y'),
                        'is_recent' => Carbon::parse($paymentHistory->created_at)->isAfter(Carbon::now()->subHours(24))
                    ];
                }
            }
        }

        // Sort notifications by created_at desc and limit to 10 most recent
        $notifications = collect($notifications)
            ->sortByDesc('created_at')
            ->take(10)
            ->values()
            ->toArray();

        return response()->json([
            'notifications' => $notifications,
            'status_counts' => $statusCounts,
            'total_notifications' => count($notifications)
        ]);
    }

    /**
     * Categorize order status into running, success, or failed
     */
    private function categorizeOrderStatus(string $status, array &$statusCounts): void
    {
        switch ($status) {
            case 'Menunggu pembayaran':
            case 'Pesanan dikonfirmasi':
            case 'Pesanan diproses':
            case 'Pesanan dikemas':
            case 'Pesanan dikirim':
                $statusCounts['Berjalan']++;
                break;

            case 'Pesanan diterima':
                $statusCounts['Sukses']++;
                break;

            case 'Pesanan dibatalkan':
            case 'Pesanan kadaluwarsa':
                $statusCounts['Gagal']++;
                break;
        }
    }
}
