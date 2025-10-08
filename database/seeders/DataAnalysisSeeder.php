<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderStatusHistory;
use App\Models\PaymentStatusHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataAnalysisSeeder extends Seeder
{
    /**
     * Run the database seeds to show statistics about the generated data.
     */
    public function run(): void
    {
        $this->command->info("=== ENHANCED ORDER DATA ANALYSIS ===\n");

        $this->showOrderStatistics();
        $this->showCancellationAnalysis();
        $this->showPaymentStatistics();
        $this->showRevenueAnalysis();
        $this->showStatusDistribution();
        $this->showTimeAnalysis();
    }

    private function showOrderStatistics(): void
    {
        $this->command->info("📊 ORDER STATISTICS:");
        $this->command->line("─────────────────────");

        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_price');
        $avgOrderValue = Order::avg('total_price');

        $this->command->line("Total Orders: {$totalOrders}");
        $this->command->line("Total Revenue: Rp " . number_format($totalRevenue, 0, ',', '.'));
        $this->command->line("Average Order Value: Rp " . number_format($avgOrderValue, 0, ',', '.'));

        // Order status breakdown
        $statusBreakdown = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->orderBy('count', 'desc')
            ->get();

        $this->command->line("\nOrder Status Breakdown:");
        foreach ($statusBreakdown as $status) {
            $percentage = round(($status->count / $totalOrders) * 100, 1);
            $this->command->line("  • {$status->status}: {$status->count} ({$percentage}%)");
        }

        // Delivery method breakdown
        $deliveryBreakdown = Order::select('method_delivery', DB::raw('count(*) as count'))
            ->groupBy('method_delivery')
            ->get();

        $this->command->line("\nDelivery Method Breakdown:");
        foreach ($deliveryBreakdown as $delivery) {
            $percentage = round(($delivery->count / $totalOrders) * 100, 1);
            $this->command->line("  • {$delivery->method_delivery}: {$delivery->count} ({$percentage}%)");
        }

        $this->command->line("");
    }

    private function showCancellationAnalysis(): void
    {
        $this->command->info("❌ CANCELLATION ANALYSIS:");
        $this->command->line("─────────────────────────");

        $cancelledOrders = Order::where('status', 'Pesanan dibatalkan')->get();
        $totalOrders = Order::count();

        $cancellationRate = $totalOrders > 0 ? round(($cancelledOrders->count() / $totalOrders) * 100, 1) : 0;

        $this->command->line("Total Cancelled Orders: {$cancelledOrders->count()}");
        $this->command->line("Cancellation Rate: {$cancellationRate}%");

        // Cancellation reasons from order status history
        $cancellationReasons = OrderStatusHistory::where('status', 'Pesanan dibatalkan')
            ->select('description', DB::raw('count(*) as count'))
            ->groupBy('description')
            ->orderBy('count', 'desc')
            ->get();

        $this->command->line("\nCancellation Reasons:");
        foreach ($cancellationReasons as $reason) {
            $percentage = $cancelledOrders->count() > 0 ? round(($reason->count / $cancelledOrders->count()) * 100, 1) : 0;
            $reasonText = strlen($reason->description) > 60
                ? substr($reason->description, 0, 60) . '...'
                : $reason->description;
            $this->command->line("  • {$reasonText}: {$reason->count} ({$percentage}%)");
        }

        // Cancellation timing analysis
        $cancellationStages = [];
        foreach ($cancelledOrders as $order) {
            $statusHistory = OrderStatusHistory::where('order_id', $order->id)
                ->where('status', '!=', 'Pesanan dibatalkan')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($statusHistory) {
                $stage = $statusHistory->status;
                $cancellationStages[$stage] = ($cancellationStages[$stage] ?? 0) + 1;
            }
        }

        $this->command->line("\nCancellation Stages:");
        arsort($cancellationStages);
        foreach ($cancellationStages as $stage => $count) {
            $percentage = $cancelledOrders->count() > 0 ? round(($count / $cancelledOrders->count()) * 100, 1) : 0;
            $this->command->line("  • After '{$stage}': {$count} ({$percentage}%)");
        }

        $this->command->line("");
    }

    private function showPaymentStatistics(): void
    {
        $this->command->info("💳 PAYMENT STATISTICS:");
        $this->command->line("──────────────────────");

        $totalPayments = Payment::count();

        // Payment status breakdown
        $paymentStatusBreakdown = Payment::select('payment_status', DB::raw('count(*) as count'))
            ->groupBy('payment_status')
            ->orderBy('count', 'desc')
            ->get();

        $this->command->line("Payment Status Breakdown:");
        foreach ($paymentStatusBreakdown as $status) {
            $percentage = round(($status->count / $totalPayments) * 100, 1);
            $this->command->line("  • {$status->payment_status}: {$status->count} ({$percentage}%)");
        }

        // Payment method breakdown
        $paymentMethodBreakdown = Payment::select('payment_method', DB::raw('count(*) as count'))
            ->groupBy('payment_method')
            ->orderBy('count', 'desc')
            ->get();

        $this->command->line("\nPayment Method Breakdown:");
        foreach ($paymentMethodBreakdown as $method) {
            $percentage = round(($method->count / $totalPayments) * 100, 1);
            $this->command->line("  • {$method->payment_method}: {$method->count} ({$percentage}%)");
        }

        $this->command->line("");
    }

    private function showRevenueAnalysis(): void
    {
        $this->command->info("💰 REVENUE ANALYSIS:");
        $this->command->line("───────────────────");

        $completedOrders = Order::where('status', 'Pesanan selesai')->get();
        $paidOrders = Payment::where('payment_status', 'Pesanan terbayar')
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->select('orders.*')
            ->get();

        $completedRevenue = $completedOrders->sum('total_price');
        $paidRevenue = $paidOrders->sum('total_price');

        $this->command->line("Revenue from Completed Orders: Rp " . number_format($completedRevenue, 0, ',', '.'));
        $this->command->line("Revenue from Paid Orders: Rp " . number_format($paidRevenue, 0, ',', '.'));

        // Monthly revenue breakdown
        $monthlyRevenue = Order::join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', 'Pesanan terbayar')
            ->select(
                DB::raw('YEAR(orders.created_at) as year'),
                DB::raw('MONTH(orders.created_at) as month'),
                DB::raw('SUM(orders.total_price) as revenue'),
                DB::raw('COUNT(orders.id) as order_count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $this->command->line("\nMonthly Revenue (Last 6 Months):");
        foreach ($monthlyRevenue->take(6) as $month) {
            $monthName = date('F Y', mktime(0, 0, 0, $month->month, 1, $month->year));
            $revenue = number_format($month->revenue, 0, ',', '.');
            $this->command->line("  • {$monthName}: Rp {$revenue} ({$month->order_count} orders)");
        }

        $this->command->line("");
    }

    private function showStatusDistribution(): void
    {
        $this->command->info("📈 STATUS HISTORY ANALYSIS:");
        $this->command->line("──────────────────────────");

        $orderStatusCount = OrderStatusHistory::count();
        $paymentStatusCount = PaymentStatusHistory::count();

        $this->command->line("Total Order Status Changes: {$orderStatusCount}");
        $this->command->line("Total Payment Status Changes: {$paymentStatusCount}");

        // Most common status transitions
        $orderTransitions = DB::table('order_status_histories as h1')
            ->join('order_status_histories as h2', function ($join) {
                $join->on('h1.order_id', '=', 'h2.order_id')
                    ->whereRaw('h2.id = h1.id + 1');
            })
            ->select('h1.status as from_status', 'h2.status as to_status', DB::raw('count(*) as count'))
            ->groupBy('h1.status', 'h2.status')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();

        $this->command->line("\nTop Order Status Transitions:");
        foreach ($orderTransitions as $transition) {
            $this->command->line("  • {$transition->from_status} → {$transition->to_status}: {$transition->count}");
        }

        $this->command->line("");
    }

    private function showTimeAnalysis(): void
    {
        $this->command->info("⏰ TIME ANALYSIS:");
        $this->command->line("────────────────");

        // Average time between order creation and completion
        $completedOrders = Order::where('status', 'Pesanan selesai')
            ->select('id', 'created_at')
            ->get();

        $totalCompletionTime = 0;
        $completedCount = 0;

        foreach ($completedOrders as $order) {
            $lastStatusHistory = OrderStatusHistory::where('order_id', $order->id)
                ->where('status', 'Pesanan selesai')
                ->first();

            if ($lastStatusHistory) {
                $completionTime = $order->created_at->diffInHours($lastStatusHistory->created_at);
                $totalCompletionTime += $completionTime;
                $completedCount++;
            }
        }

        if ($completedCount > 0) {
            $avgCompletionTime = round($totalCompletionTime / $completedCount, 1);
            $avgCompletionDays = round($avgCompletionTime / 24, 1);
            $this->command->line("Average Order Completion Time: {$avgCompletionTime} hours ({$avgCompletionDays} days)");
        }

        // Average time between order and payment
        $paidPayments = Payment::where('payment_status', 'Pesanan terbayar')
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->select('payments.id', 'orders.created_at as order_created')
            ->get();

        $totalPaymentTime = 0;
        $paidCount = 0;

        foreach ($paidPayments as $payment) {
            $paymentHistory = PaymentStatusHistory::where('payment_id', $payment->id)
                ->where('status', 'Pesanan terbayar')
                ->first();

            if ($paymentHistory) {
                $paymentTime = \Carbon\Carbon::parse($payment->order_created)->diffInHours($paymentHistory->created_at);
                $totalPaymentTime += $paymentTime;
                $paidCount++;
            }
        }

        if ($paidCount > 0) {
            $avgPaymentTime = round($totalPaymentTime / $paidCount, 1);
            $this->command->line("Average Time to Payment: {$avgPaymentTime} hours");
        }

        $this->command->line("");
        $this->command->info("✅ Data analysis complete! Your refined order data has realistic:");
        $this->command->line("• Progressive order statuses with proper timing");
        $this->command->line("• Realistic payment methods and statuses");
        $this->command->line("• Indonesian addresses and names");
        $this->command->line("• Proper order-payment relationships");
        $this->command->line("• Complete status history tracking");
        $this->command->line("• Weighted distributions for realistic data patterns");
    }
}
