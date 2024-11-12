<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categoryCakeName = [
            'Tart Cake',
            'Wedding Cake',
            'Brownies',
            'Pudding',
            'Pie',
            'Cupcake',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($categoryCakeName),
        ];
    }
}
