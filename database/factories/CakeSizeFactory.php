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
            13 => 45000,
            14 => 50000,
            15 => 55000,
            16 => 60000,
            17 => 65000,
            18 => 70000,
        ];

        return [
            'size' => $this->faker->unique()->numberBetween(13, 18),
            'price' => function (array $attributes) use ($cakeSizePrice) {
                return $cakeSizePrice[$attributes['size']];
            },
        ];
    }
}
