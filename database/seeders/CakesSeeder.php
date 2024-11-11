<?php

namespace Database\Seeders;

use App\Models\Cake;
use App\Models\CakeSize;
use Illuminate\Database\Seeder;

class CakesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Calculate how many cakes to create based on available sizes
        $totalSizes = CakeSize::query()->count();
        $customizedCakeTypes = ['Bento Cake', 'Cakes'];
        $totalCakesToCreate = $totalSizes * count($customizedCakeTypes);

        Cake::factory($totalCakesToCreate)->create();
    }
}
