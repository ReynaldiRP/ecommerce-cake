<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CakeSize>
 */
class CakeSizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cakeSizePrice = [
            10 => 5000,
            12 => 10000,
            15 => 20000,
            17 => 30000,
            18 => 40000,
            20 => 50000,
            22 => 60000,
            24 => 70000,
        ];


        return [
            'size' => $this->faker->unique()->randomElement(array_keys($cakeSizePrice)),
            'price' => function (array $attributes) use ($cakeSizePrice) {
                return $cakeSizePrice[$attributes['size']];
            },
        ];
    }
}
