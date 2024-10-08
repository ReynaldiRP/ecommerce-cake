<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use App\Models\ShoppingChartItem;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\OrderItem\StoreOrderItemRequest;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Setup Midtrans configuration.
     *
     * This will be called once when the controller instance is created.
     *
     * @return void
     */
    public function __construct()
    {
        \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized  = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds        = config('services.midtrans.is3ds');
    }


    public function getDetailOrderItem(): JsonResponse
    {
        return response()->json(['message' => 'Order item retrieved successfully.']);
    }


    /**
     * Create a new order and associate it with the current user.
     *
     * @param  array  $data
     * @return \App\Models\Order
     */
    public function createOrder(array $data): Order
    {
        return Order::create([
            'user_id' => auth()->id(),
            'order_code' => uniqid(),
            'total_price' => 0,
            'status' => 'pending',
            'user_address' => $data['user_address'],
            'cake_recipent' => $data['cake_recipent'],
            'estimated_delivery_date' => $data['estimated_delivery_date'],
        ]);
    }



    public function createOrderItem(Request $request): JsonResponse
    {
        // Create the order with additional data
        $createOrder = $this->createOrder([
            'user_address' => $request['user_address'],
            'cake_recipent' => $request['cake_recipent'],
            'estimated_delivery_date' => $request['estimated_delivery_date'],
        ]);


        $chartItems = $request->input('chartItems');
        $totalPrice = 0;

        // Loop through each chart item and create an order item
        foreach ($chartItems as $chartItem) {
            $orderItem = OrderItem::create([
                'order_id' => $createOrder['id'],
                'cake_id' => $chartItem['cake_id'],
                'cake_flavour_id' => $chartItem['cake_flavour_id'] ?? null,
                'quantity' => $chartItem['quantity'],
                'price' => $chartItem['price'],
            ]);

            // Add the current item's total (price * quantity) to the total order price
            $totalPrice += $orderItem->price;
        }

        // Update the order's total price after all items are added
        $createOrder->update(['total_price' => $totalPrice]);

        //Extract ids from chartItems
        $chartItemIds = array_column($chartItems, 'id');

        // Delete the shopping chart items
        ShoppingChartItem::whereIn('id', $chartItemIds)->delete();


        return response()->json([
            'message' => 'Order item created successfully.',
        ]);
    }


    public function payments(Request $request): JsonResponse
    {
        

        return response()->json(['message' => 'Payment retrieved successfully.']);
    }
}
