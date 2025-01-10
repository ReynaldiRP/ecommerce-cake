<?php

namespace Database\Seeders;

use App\Models\Cake;
use App\Models\CakeSize;
use App\Models\Flavour;
use App\Models\Order;
use App\Models\Topping;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get order data
        $orders = Order::with('user')->get();

        // Get item data
        $cakes = Cake::with('discount')->get();
        $cakeSize = CakeSize::all();
        $cakeFlavour = Flavour::all();
        $cakeTopping = Topping::all();

        // Faker data
        $faker = Factory::create();

        // Loop create order item for each order
        foreach ($orders as $order) {
            $itemCount = $faker->numberBetween(1, 4);
            $includeProbability = $faker->boolean(50);

            for ($i = 0; $i < $itemCount; $i++) {
                $cake = $cakes->random();
                $size = $cakeSize->random();
                $flavour = $cakeFlavour->random();
                $topping = $cakeTopping->random();

                $order->orderItems()->create([
                    'cake_id' => $cake->id,
                    'cake_size_id' => $includeProbability ? $size->id : null,
                    'cake_flavour_id' => $includeProbability ? $flavour->id : null,
                    'quantity' => $faker->numberBetween(1, 3),
                    'price' => $cake->base_price + ($includeProbability ? $size->price : 0) + ($includeProbability ? $flavour->price : 0) + ($includeProbability ? $topping->price : 0),
                ]);

                // Attach topping if included
                if ($includeProbability) {
                    $order->orderItems()->first()->cakeTopping()->attach($topping->id);
                }
            }
        }
    }
}
