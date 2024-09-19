<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShoppingChart\StoreShoppingChartRequest;
use App\Models\ShoppingChart;
use App\Models\ShoppingChartItem;
use App\Models\ShoppingChartItemTopping;
use Illuminate\Http\JsonResponse;

class ShoppingChartController extends Controller
{
    /**
     * Retrieves or creates a shopping chart for the currently authenticated user.
     *
     * @return ShoppingChart The shopping chart instance.
     */
    public function addChart(): ShoppingChart
    {
        return ShoppingChart::firstOrCreate(
            ['user_id' => auth()->id()],
            ['total_price' => 0]
        );
    }



    /**
     * Adds an item to the shopping cart.
     *
     * @param StoreShoppingChartRequest $request The request containing the item details.
     * @return JsonResponse A JSON response containing the updated cart and item details.
     */
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

        // Insert in pivot table ChartItemTopping
        if ($request->has('toppings') && is_array($request['toppings'])) {
            $toppings = array_map('intval', $request['toppings']);
            foreach ($toppings as $toppingId) {
                ShoppingChartItemTopping::create([
                    'shopping_chart_item_id' => $cartItem->id,
                    'topping_id' => $toppingId
                ]);
            }
        }

        $cartItemWithRelations = ShoppingChartItem::with('cart', 'cake', 'cakeFlavour', 'cakeTopping')
            ->find($cartItem->id);


        return response()->json([
            'cart' => $cart,
            'cartItem' => $cartItemWithRelations,
            'message' => 'Item added to cart successfully!'
        ]);
    }


    /**
     * Retrieves a list of shopping chart items for the authenticated user.
     *
     * @return JsonResponse A JSON response containing the shopping chart items.
     */
    public function getShoppingChartItems(): JsonResponse
    {
        if (!auth()->check()) {
            return response()->json([
                'message' => 'User not authenticated',
                'cart' => [],
            ]);
        }

        $cart = ShoppingChart::with('user')->where('user_id', '=', auth()->id())->get();

        if ($cart->isEmpty()) {
            return response()->json([
                'message' => 'Cart is empty',
                'cart' => [],
            ]);
        }

        $cartItem = ShoppingChartItem::with('cart', 'cake', 'cakeFlavour', 'cakeTopping')->where('shopping_chart_id', '=', $cart->first()->id)->get();

        return response()->json([
            'cart' => $cartItem,
        ]);
    }
}
