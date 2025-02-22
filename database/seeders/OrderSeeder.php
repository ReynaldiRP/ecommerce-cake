<?php

namespace Database\Seeders;

use App\Models\Cake;
use App\Models\CakeSize;
use App\Models\Flavour;
use App\Models\Order;
use App\Models\Topping;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Customized cake
        $customizedCake = [
            'Black Forest Cake',
            'Red Velvet Cake',
            'Tiramisu Cake',
            'Mocha Cake',
            'Traditional Tiered Cake',
            'Naked Cake',
            'Semi-Naked Cake',
        ];


        // Get user that has role of user from spatie
        $users = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->get();

        // Get item data
        $cakes = Cake::with('discount')->get();
        $cakeSize = CakeSize::all();
        $cakeFlavour = Flavour::all();
        $cakeTopping = Topping::all();

        // Faker data
        $faker = Factory::create();

        // Loop create order for each user
        for ($i = 0; $i < 30; $i++) {
            $order = Order::create([
                'user_id' => $users->random()->id,
                'order_code' => Str::uuid(),
                'estimated_delivery_date' => $faker->dateTimeBetween('2023-01-01', '2024-12-31')->modify('+2 days'),
                'method_delivery' => $faker->randomElement(['Dikirim', 'Ambil di toko']),
                'user_address' => $faker->address,
                'cake_recipient' => $faker->name,
                'status' => 'Pesanan diterima',
                'total_price' => 0,
                'created_at' => $faker->dateTimeBetween('2023-01-01', '2024-12-31'),
            ]);

            // Loop create order item for each order
            $itemCount = $faker->numberBetween(1, 4);

            for ($j = 0; $j < $itemCount; $j++) {
                $cake = $cakes->random();
                // Check if cake is customized its will include size, flavour, and topping
                if (in_array($cake->name, $customizedCake)) {
                    $size = $cakeSize->random();
                    $flavour = $cakeFlavour->random();
                    $topping = $cakeTopping->random();
                } else {
                    $size = null;
                    $flavour = null;
                    $topping = null;
                }

                $order->orderItems()->create([
                    'cake_id' => $cake->id,
                    'cake_size_id' => $size->id ?? null,
                    'cake_flavour_id' => $flavour->id ?? null,
                    'quantity' => $faker->numberBetween(1, 3),
                    'price' => $cake->base_price + ($size->price ?? 0) + ($flavour->price ?? 0) + ($topping->price ?? 0),
                    'created_at' => $faker->dateTimeBetween('2024-01-01', '2024-12-31'),
                ]);

                // Attach topping if included
                if (isset($topping)) {
                    $order->orderItems()->first()->cakeTopping()->attach($topping->id);
                }

                // log the order item
                Log::info('Order item created', [
                    'cake_name' => $cake->name,
                    'cake_size' =>  $size->size ?? null,
                    'cake_flavour_id' => $flavour->name ?? null,
                    'topping_id' => $topping->name ?? null,
                ]);
            }

            // Update total price
            $order->update([
                'total_price' => $order->orderItems->sum('price'),
            ]);
        }

    }
}
