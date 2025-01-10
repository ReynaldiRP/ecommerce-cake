<?php

namespace Database\Seeders;

use App\Models\Order;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get order data
        $orders = Order::with('user')->get();

        // Faker data
        $faker = Factory::create();

        // Loop create payment for each order
        foreach ($orders as $order) {
            $order->payment()->create([
                'transaction_id' => Str::uuid(),
                'payment_method' => $faker->randomElement(['Transfer', 'Cash']),
                'payment_status' => 'Pesanan terbayar',
                'created_at' => $faker->dateTimeBetween('2024-01-01', '2024-12-31'),
            ]);
        }
    }
}
