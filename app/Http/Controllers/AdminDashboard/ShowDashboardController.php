<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Carbon\Carbon;
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
        $getAllCakeSold = $orderItem->getAllCakeSold('2024');
        // Get total revenue cake orders from the payment model
        $totalRevenueCakeOrders = $payment->totalRevenueOrder('2024-11-01', Carbon::now()->format('Y-m-d'));
        // Get total cake sold
        $totalCakeSold = $orderItem->getTotalCakeSold('2024-11-01', Carbon::now()->format('Y-m-d'));
        // Get the most popular cake
        $mostPopularCake = $orderItem->getMostPopularCakes();
        // Get the most popular cake type
        $mostPopularCakeType = $orderItem->getMostPopularCakeType('2024-11-01', Carbon::now()->format('Y-m-d'));
        // Get the most popular cake category
        $mostPopularCakeCategory = $orderItem->getMostPopularCakeCategory('2024-11-01', Carbon::now()->format('Y-m-d'));
        // Get the total transaction
        $totalTransaction = $payment->getTotalTransaction('2024-11-01', Carbon::now()->format('Y-m-d'));
        // Get the growth revenue for the last three months
        $growthGrowthRevenueForThreeMonth = $order->getGrowthRevenueRangeThreeMonthByPercentage();
        // Get the average revenue for last three months
        $averageRevenueForThreeMonth = $order->getTheAverageRevenueThreeMonth();
        // Show chart data for the total revenue of cake orders per month
        $chartData = $order->showAllRevenueForEachMonths('2024');
        // Show total transaction per month for the last 12 months based on selected year
        $chartDataTotalTransaction = $order->showAllTransactionForEachMonths('2024');

        return Inertia::render('AdminDashboard/HomeSection', [
            'totalRevenue' => $totalRevenueCakeOrders ?? 0,
            'totalCakeSold' => $totalCakeSold ?? 0,
            'mostPopularCake' => $mostPopularCake ?? [],
            'mostPopularCakeType' => $mostPopularCakeType ?? [],
            'mostPopularCakeCategory' => $mostPopularCakeCategory ?? [],
            'growthRevenuePerMonthByPercentage' => $growthGrowthRevenueForThreeMonth ?? [],
            'averageRevenue' => $averageRevenueForThreeMonth ?? 0,
            'totalTransaction' => $totalTransaction ?? 0,
            'chartData' => $chartData ?? [],
            'chartDataCakeSold' => $getAllCakeSold ?? [],
            'chartDataTotalTransaction' => $chartDataTotalTransaction ?? [],
        ]);
    }
}
