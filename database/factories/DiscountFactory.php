<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'discount_percentage' => $this->faker->randomFloat(2, 0, 100),
            'start_date' => $this->faker->date(),
            'end_date' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['start_date'], '+1 year')->format('Y-m-d');
            },
        ];
    }
}
