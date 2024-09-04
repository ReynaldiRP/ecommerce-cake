<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cake;
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
        Flavour::factory(8)->create();
        CakeSize::factory(6)->create();
        Topping::factory(8)->create();
    }
}
