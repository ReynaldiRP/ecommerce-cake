<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use App\Models\ShoppingChartItem;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\OrderItem\StoreOrderItemRequest;
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
        return Order::firstOrCreate([
            'user_id' => auth()->id(),
        ], [
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
        $createOrder = $this->createOrder([
            'user_address' => $request['user_address'],
            'cake_recipent' => $request['cake_recipent'],
            'estimated_delivery_date' => $request['estimated_delivery_date'],
        ]);

        dd($createOrder);

        // $chartItems = $request->input('chartItems');

        // dd($chartItems);
        // foreach ($chartItems as $chartItem) {
        // }

        // OrderItem::create([
        //     'order_id' => $createOrder['id'],
        //     'cake_id' => $request['cake_id'],
        //     'cake_flavour_id' => $request['cake_flavour_id'] ?? null,
        //     'quantity' => $request['quantity'],
        //     'price' => $request['price'],
        // ]);



        return response()->json(['message' => 'Order item created successfully.']);
    }
}
