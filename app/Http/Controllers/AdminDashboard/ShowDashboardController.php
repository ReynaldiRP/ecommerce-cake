<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShowDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        $payment = new Payment();
        $order = new Order();
        $orderItem = new OrderItem();


        // FIXME: the date range is still not working properly
        $getAllCakeSold = $orderItem->getAllCakeSold();
        // Get total revenue cake orders from the payment model
        $totalRevenueCakeOrders = $payment->totalRevenueOrder('2025-01-01', '2025-12-31');
        // Get total cake sold
        $totalCakeSold = $orderItem->getTotalCakeSold('2025-01-01', '2025-12-31');
        // Get the most popular cake
        $mostPopularCake = $orderItem->getMostPopularCakes();
        // Get the most popular cake type
        $mostPopularCakeType = $orderItem->getMostPopularCakeType();
        // Get the most popular cake category
        $mostPopularCakeCategory = $orderItem->getMostPopularCakeCategory();
        // Get the total transaction
        $totalTransaction = $payment->getTotalTransaction('2025-01-01', '2025-12-31');
        // Get the growth revenue per month by percentage
        $growthRevenuePerMonthByPercentage = $order->getGrowthRevenueRangeThreeMonthByPercentage();
        // Show chart data for the total revenue of cake orders per month
        $chartData = $order->showAllRevenueForEachMonths('2025');
        // Show total transaction per month for the last 12 months based on selected year
        $chartDataTotalTransaction = $order->showAllTransactionForEachMonths('2025');

        return Inertia::render('AdminDashboard/HomeSection', [
            'totalRevenue' => $totalRevenueCakeOrders ?? 0,
            'totalCakeSold' => $totalCakeSold ?? 0,
            'mostPopularCake' => $mostPopularCake ?? [],
            'mostPopularCakeType' => $mostPopularCakeType ?? [],
            'mostPopularCakeCategory' => $mostPopularCakeCategory ?? [],
            'growthRevenuePerMonthByPercentage' => $growthRevenuePerMonthByPercentage ?? [],
            'totalTransaction' => $totalTransaction ?? 0,
            'chartData' => $chartData ?? [],
            'chartDataCakeSold' => $getAllCakeSold ?? [],
            'chartDataTotalTransaction' => $chartDataTotalTransaction ?? [],
        ]);
    }
}
