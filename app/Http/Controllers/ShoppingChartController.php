<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShoppingChart\StoreShoppingChartRequest;
use App\Models\ShoppingChart;
use App\Models\ShoppingChartItem;
use App\Models\ShoppingChartItemTopping;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * Adds a new item to the shopping chart.
     *
     * @param StoreShoppingChartRequest $request The request object containing the item details.
     * @return JsonResponse The JSON response containing the added item details and a success message.
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
            'cartItem' => [
                'cake_name' => $cartItemWithRelations->cake?->name,
                'cake_image' => $cartItemWithRelations->cake?->image_url,
                'cake_flavour_name' => $cartItemWithRelations->cakeFlavour?->name,
                'cake_toppings' =>  $cartItemWithRelations->cakeTopping?->pluck('name'),
            ],

            'cartItems' => [$cartItemWithRelations],
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


    /**
     * Deletes a shopping chart item and its associated toppings.
     *
     * @param ShoppingChartItem $shoppingChartItem The shopping chart item to delete.
     *
     * @return JsonResponse A JSON response with a success message.
     */
    public function deleteShoppingChartItem(Request $request): JsonResponse
    {
        // Retrieve the selected item IDs for multiple deletions or single item deletion
        $itemIds = $request->input('selectCake', []); // Array of selected item IDs

        if (count($itemIds) > 0) {
            // Delete the items
            ShoppingChartItemTopping::whereIn('shopping_chart_item_id', $itemIds)->delete();
            ShoppingChartItem::whereIn('id', $itemIds)->delete();

            // Determine the message based on the number of items
            $message = count($itemIds) === 1 ? 'Cake successfully deleted!' : 'Cake(s) successfully deleted!';

            return response()->json([
                'message' => $message,
            ]);
        }

        return response()->json([
            'message' => 'No items selected for deletion.',
        ], 400);

        return response()->json([
            'message' => 'No items selected for deletion.',
        ], 400);
    }
}
