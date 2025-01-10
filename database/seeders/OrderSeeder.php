<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get user that has role of user from spatie
        $users = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->get();

        // Faker data
        $faker = Factory::create();

        // Loop create order for each user
        for ($i = 0; $i < 10; $i++) {
            Order::create([
                'user_id' => $users->random()->id,
                'order_code' => Str::uuid(),
                'estimated_delivery_date' => $faker->dateTimeBetween('2024-01-01', '2024-12-31')->modify('+2 days'),
                'method_delivery' => $faker->randomElement(['Dikirim', 'Ambil di toko']),
                'user_address' => $faker->address,
                'cake_recipient' => $faker->name,
                'status' => 'Pesanan diterima',
                'total_price' => $faker->randomFloat(2, 100, 1000),
                'created_at' => $faker->dateTimeBetween('2024-01-01', '2024-12-31'),
            ]);
        }

    }
}
