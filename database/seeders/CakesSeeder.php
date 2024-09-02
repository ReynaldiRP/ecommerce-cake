<?php

namespace Database\Seeders;

use App\Models\Cake;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CakesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cake::factory()->count(11)->create();
    }
}
