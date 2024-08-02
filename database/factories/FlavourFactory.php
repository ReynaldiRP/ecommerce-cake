<?php

namespace Database\Factories;

use App\Models\Flavour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flavour>
 */
class FlavourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'price' => $this->faker->numberBetween(10000, 100000),
            'image_url' => 'assets/image/default-img'
        ];
    }
}
