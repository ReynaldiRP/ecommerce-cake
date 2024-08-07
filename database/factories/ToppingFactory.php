<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topping>
 */
class ToppingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $toppings = [
            'Sliced kiwi',
            'Straberry',
            'Hazelnuts',
            'Kit kat',
            'Gummy bears',
            'Lollipops',
            'Macarons',
            'Chocolate bar'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($toppings),
            'price' => $this->faker->numberBetween(10, 13) * 5000,
            'image_url' => 'assets/image/default-img'
        ];
    }
}
