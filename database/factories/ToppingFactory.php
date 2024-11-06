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

        $toppingPrice = [
            'Sliced kiwi' => 5000,
            'Straberry' => 6000,
            'Hazelnuts' => 7000,
            'Kit kat' => 8000,
            'Gummy bears' => 9000,
            'Lollipops' => 10000,
            'Macarons' => 11000,
            'Chocolate bar' => 12000
        ];

        return [
            'name' => $this->faker->unique()->randomElement($toppings),
            'price' => function (array $attributes) use ($toppingPrice) {
                return $toppingPrice[$attributes['name']];
            },
            'image_url' => 'assets/image/default-img'
        ];
    }
}
