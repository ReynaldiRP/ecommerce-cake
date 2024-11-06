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


        $flavourPrices = [
            'Blackforest' => 142500,
            'Double choco' => 132500,
            'Straberry jam' => 127500,
            'Vanilla jam' => 122500,
            'Bluberry jam' => 137500,
            'Pandan' => 117500,
            'Red Velvet' => 137500,
            'Matcha' => 147500
        ];



        return [
            'name' => $this->faker->unique()->randomElement($flavour),
            'price' => function (array $attributes) use ($flavourPrices) {
                return $flavourPrices[$attributes['name']];
            },
            'image_url' => 'assets/image/default-img'
        ];
    }
}
