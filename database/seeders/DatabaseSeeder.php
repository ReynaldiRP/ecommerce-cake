<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cake;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use App\Models\Flavour;
use App\Models\Topping;
use App\Models\CakeSize;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::factory()->createMany([
            ['name' => 'admin'],
            ['name' => 'user'],
        ]);
        User::factory()->createMany([
            [
                'role_id' => 1,
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'role_id' => 2,
                'username' => 'user',
                'email' => 'user@example.com',
                'password' => Hash::make('12345678'),
            ]
        ]);
        Flavour::factory(8)->create();
        CakeSize::factory(6)->create();
        Topping::factory(8)->create();
        Category::factory(6)->create();
    }
}
