<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CakeSize;
use App\Models\Role;
use App\Models\User;
use App\Models\Flavour;
use App\Models\Topping;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::factory(2)->create();
        User::factory(1)->create();
        Flavour::factory()->createMany([
            [
                'name' => 'Red Velvet',
                'price' => 50000,
                'image_url' => 'assets/image/default-img'
            ],
            [
                'name' => 'Chocolate',
                'price' => 60000,
                'image_url' => 'assets/image/default-img'
            ],
            [
                'name' => 'Tiramisu',
                'price' => 55000,
                'image_url' => 'assets/image/default-img'
            ]
        ]);
        CakeSize::factory(3)->create();
        Topping::factory()->createMany([
            [
                'name' => 'Whipped Cream',
                'price' => 10000,
                'image_url' => 'assets/image/default-img'
            ],
            [
                'name' => 'Stroberry',
                'price' => 12000,
                'image_url' => 'assets/image/default-img'
            ],
            [
                'name' => 'Gold Flake',
                'price' => 5000,
                'image_url' => 'assets/image/default-img'
            ]
        ]);
    }
}
