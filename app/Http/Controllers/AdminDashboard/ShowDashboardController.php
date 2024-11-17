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
        $totalRevenueCakeOrders = $payment->totalRevenueOrder();

        // Get total cake sold
        $totalCakeSold = $orderItem->getTotalCakeSold();
        // Get the most popular cake
        $mostPopularCake = $orderItem->getMostPopularCakes();
        // Get the most popular cake category
        $mostPopularCakeCategory = $orderItem->getMostPopularCakeCategory();
        // Show chart data for the total revenue of cake orders per month
        $chartData = $order->showAllRevenueForEachMonths('2024');

        return Inertia::render('AdminDashboard/HomeSection', [
            'totalRevenue' => $totalRevenueCakeOrders,
            'totalCakeSold' => $totalCakeSold,
            'mostPopularCake' => $mostPopularCake,
            'mostPopularCakeCategory' => $mostPopularCakeCategory,
            'chartData' => $chartData
        ]);
    }
}
