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
        // check role permission
        if (!auth()->user()->hasPermissionTo('read-dashboard')) {
            abort(403, 'Unauthorized access');
        }

        $payment = new Payment();
        $order = new Order();
        $orderItem = new OrderItem();


        $getAllCakeSold = $orderItem->getAllCakeSold('2025');
        // Get total revenue cake orders from the payment model
        $totalRevenueCakeOrders = $payment->totalRevenueOrder(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        // Get total cake sold
        $totalCakeSold = $orderItem->getTotalCakeSold(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        // Get the most popular cake
        $mostPopularCake = $orderItem->getMostPopularCakes(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        // Get the most popular cake type
        $mostPopularCakeType = $orderItem->getMostPopularCakeType(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        // Get the most popular cake category
        $mostPopularCakeCategory = $orderItem->getMostPopularCakeCategory(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        // Get the total transaction
        $totalTransaction = $payment->getTotalTransaction(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
        // Get the growth revenue for the last three months
        $growthGrowthRevenueForThreeMonth = $order->getGrowthRevenueRangeThreeMonthByPercentage();
        // Get the average revenue for last three months
        $averageRevenueForThreeMonth = $order->getTheAverageRevenueThreeMonth();
        // Show chart data for the total revenue of cake orders per month
        $chartData = $order->showAllRevenueForEachMonths('2025');
        // Show total transaction per month for the last 12 months based on selected year
        $chartDataTotalTransaction = $order->showAllTransactionForEachMonths('2025');
        // Show the current month
        $currentMonth = Carbon::now()->translatedFormat('F Y');

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
            'currentMonth' => $currentMonth,
        ]);
    }
}
