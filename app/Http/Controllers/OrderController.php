<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ShoppingChartItem;
use Illuminate\Http\JsonResponse;


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
            'status' => 'Order Confirmed',
            'user_address' => $data['user_address'],
            'cake_recipent' => $data['cake_recipent'],
            'estimated_delivery_date' => $data['estimated_delivery_date'],
        ]);
    }




    /**
     * Create a new order and associate it with the current user. The order items are created from the chart items
     * passed in the request body. The order items are then associated with the order.
     *
     * @param Request $request
     * @return JsonResponse
     */
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
            'data' => [
                'order' => [
                    'id' => $createOrder->id,
                    'order_code' => $createOrder->order_code,
                    'user_address' => $createOrder->user_address,
                    'cake_recipent' => $createOrder->cake_recipent,
                    'estimated_delivery_date' => $createOrder->estimated_delivery_date,
                    'status' => $createOrder->status,
                    'total_price' => $createOrder->total_price,
                    'order_items' => $createOrder->orderItems()->with([
                        'cake',
                        'cakeFlavour',
                    ])->get()->toArray(),
                ],
            ]
        ]);
    }





    public function redirectPaymentMidtrans(Request $request): JsonResponse
    {
        try {
            //Order Details
            $orderResponse = $this->createOrderItem($request);

            // Get the response data from JsonResponse as an object
            $orderDetails = $orderResponse->getData();

            if ($orderResponse->status() !== 200) {
                return response()->json([
                    'message' => 'Order creation failed.',
                    'data' => null,
                ], 400);
            }

            // Polpulate items_details array for midtrans
            $items = [];
            foreach ($orderDetails->data->order->order_items as $orderItem) {
                $items[] = [
                    'id' => $orderItem->id,
                    'name' => $orderItem->cake->name,
                    'price' => $orderItem->price,
                    'category' => $orderItem->cake->personalization_type,
                    'quantity' => $orderItem->quantity,
                ];
            }

            // Create payload for midtrans
            $payload = [
                'transaction_details' => [
                    'order_id'     => $orderDetails->data->order->order_code,
                    'gross_amount' => $orderDetails->data->order->total_price,
                ],
                'customer_details' => [
                    'first_name' => $orderDetails->data->order->cake_recipent,
                    'email'      => auth()->user()->email,
                    'phone' => auth()->user()->phone_number,
                    'shipping_address' => [
                        'address' => $orderDetails->data->order->user_address
                    ]
                ],
                'item_details' => $items,
            ];

            // Get Snap Payment Page URL
            $paymentUrl = \Midtrans\Snap::createTransaction($payload)->redirect_url;

            // Return the payment page URL
            return response()->json([
                'success' => true,
                'paymentUrl' => $paymentUrl
            ]);
        } catch (\Throwable $th) {
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'Payment creation failed. Please try again.',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
