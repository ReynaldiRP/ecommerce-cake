<?php

namespace Database\Seeders;

use App\Models\Cake;
use App\Models\CakeSize;
use Database\Factories\CakeFactory;
use Illuminate\Database\Seeder;

class CakesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cake::Factory()
            ->count(7)
            ->create();
    }
}
