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

        $flavour = [
            'Blackforest',
            'Double choco',
            'Straberry jam',
            'Vanilla jam',
            'Bluberry jam',
            'Pandan',
            'Red Velvet',
            'Matcha'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($flavour),
            'price' => $this->faker->numberBetween(10, 13) * 5000,
            'image_url' => 'assets/image/default-img'
        ];
    }
}
