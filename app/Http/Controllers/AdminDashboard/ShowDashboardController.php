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


        // Get total revenue cake orders from the payment model
        $totalRevenueCakeOrders = $payment->totalRevenueOrder('2024-09-01', '2024-12-31');
        // Get total cake sold
        $totalCakeSold = $orderItem->getTotalCakeSold('2024-01-01', '2024-12-31');
        // Get the most popular cake
        $mostPopularCake = $orderItem->getMostPopularCakes();
        // Get the most popular cake type
        $mostPopularCakeType = $orderItem->getMostPopularCakeType();
        // Get the most popular cake category
        $mostPopularCakeCategory = $orderItem->getMostPopularCakeCategory();
        // Get the growth revenue per month by percentage
        $growthRevenuePerMonthByPercentage = $order->getGrowthRevenueRangeThreeMonthByPercentage();
        // Show chart data for the total revenue of cake orders per month
        $chartData = $order->showAllRevenueForEachMonths('2024');


        return Inertia::render('AdminDashboard/HomeSection', [
            'totalRevenue' => $totalRevenueCakeOrders ?? 0,
            'totalCakeSold' => $totalCakeSold ?? 0,
            'mostPopularCake' => $mostPopularCake ?? [],
            'mostPopularCakeType' => $mostPopularCakeType ?? [],
            'mostPopularCakeCategory' => $mostPopularCakeCategory ?? [],
            'growthRevenuePerMonthByPercentage' => $growthRevenuePerMonthByPercentage ?? 0,
            'chartData' => $chartData ?? [],
        ]);
    }
}
