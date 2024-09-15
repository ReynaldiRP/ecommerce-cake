<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShoppingChart\StoreShoppingChartRequest;
use App\Models\Cake;
use App\Models\Flavour;
use App\Models\ShoppingChart;
use App\Models\ShoppingChartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ShoppingChartController extends Controller
{
    public function addChart(): ShoppingChart
    {
        return ShoppingChart::firstOrCreate(
            ['user_id' => auth()->id()],
            ['total_price' => 0]
        );
    }

    public function addChartItem(StoreShoppingChartRequest $request): JsonResponse
    {

        $cart = $this->addChart();

        $cartItem = ShoppingChartItem::create([
            'shopping_chart_id' => $cart->id,
            'cake_id' => $request['cake_id'],
            'cake_flavour_id' => $request['flavour_id'] ? $request['flavour_id'] : null,
            'quantity' => $request['quantity'],
            'price' => $request['price'],
        ]);

        $cart->total_price += $request['price'];
        $cart->save();

        return response()->json([
            'cart' => $cart,
            'cartItem' => $cartItem,
            'message' => 'Item added to cart successfully!'
        ]);
    }
}
