<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ShowDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        // Get total revenue cake orders
        $totalRevenueCakeOrders = Payment::query()->where('payment_status', '=', 'terbayar')
                                    ->join('orders', 'payments.order_id', '=', 'orders.id')
                                    ->sum('orders.total_price');


        // Get total cake solds
        $totalCakeSold = (int) OrderItem::with('order', 'order.payment')
            ->whereHas('order.payment', function ($query) {
                $query->where('payment_status', '=', 'terbayar');
            })
            ->sum('quantity');


        // Get the most popular cake
        $cakeSales = OrderItem::query()->select('cakes.name as cake_name', 'cakes.image_url as cake_image' ,DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('cakes', 'order_items.cake_id', '=', 'cakes.id')
            ->groupBy('cakes.name', 'cakes.image_url');

        // Use a subquery to find the max sold cake
        $maxSold = DB::table(DB::raw("({$cakeSales->toSql()}) as subquery"))
            ->mergeBindings($cakeSales->getQuery())
            ->max('total_sold');

        // Fetch the most popular cake
        $mostPopularCake = $cakeSales->having('total_sold', '=', $maxSold)->first();

        return Inertia::render('AdminDashboard/HomeSection', [
            'totalRevenue' => $totalRevenueCakeOrders,
            'totalCakeSold' => $totalCakeSold,
            'mostPopularCake' => $mostPopularCake
        ]);
    }
}
