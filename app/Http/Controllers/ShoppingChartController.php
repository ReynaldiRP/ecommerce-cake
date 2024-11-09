<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShoppingChart;
use App\Models\ShoppingChartItem;
use Illuminate\Http\JsonResponse;
use App\Models\ShoppingChartItemTopping;
use Illuminate\Validation\ValidationException;

class ShoppingChartController extends Controller
{
    /**
     * Create a new shopping cart instance for the authenticated user, or return the existing one if it already exists.
     *
     * @return ShoppingChart The existing or newly created shopping cart instance.
     */
    public function addChart(): ShoppingChart
    {
        return ShoppingChart::firstOrCreate(
            ['user_id' => auth()->id()],
            ['total_price' => 0]
        );
    }


    /**
     * Add an item to the shopping cart.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing the item details.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the added cart item details or an error message.
     *
     * @throws \Illuminate\Validation\ValidationException If validation fails.
     * @throws \Exception If any other error occurs while adding the item to the cart.
     */
    public function addChartItem(Request $request): JsonResponse
    {

        try {
            $cart = $this->addChart();

            $cartItem = ShoppingChartItem::create([
                'shopping_chart_id' => $cart->id,
                'cake_id' => $request['cake_id'],
                'cake_flavour_id' => $request['cake_flavour_id'] ?? null,
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
        } catch (ValidationException $e) {
            // Handle validation errors and return a response with the errors
            return response()->json([
                'errors' => $e->errors(), // The validation errors
            ], 422);
        } catch (\Exception $e) {
            // Handle any other possible exceptions
            return response()->json([
                'message' => 'An error occurred while adding the item to the cart.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Retrieves the shopping chart items for the currently authenticated user.
     *
     * @return JsonResponse A JSON response containing the shopping chart items.
     *                      If the user is not authenticated, returns a JSON response with a message indicating the user is not authenticated.
     *                      If the cart is empty, returns a JSON response with a message indicating that the cart is empty.
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

        $cartItem = ShoppingChartItem::with('cart', 'cake', 'cake.cakeSize', 'cakeFlavour', 'cakeTopping')->where('shopping_chart_id', '=', $cart->first()->id)->get();

        return response()->json([
            'cart' => $cartItem,
        ]);
    }



    /**
     * Deletes one or multiple shopping chart items based on the provided item IDs.
     *
     * @param Request $request - The HTTP request containing the selected item IDs.
     * @return JsonResponse - A JSON response with a success or error message.
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
    }
}
