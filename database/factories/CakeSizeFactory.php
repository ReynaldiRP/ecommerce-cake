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
        // Realistic cake sizes (in cm) with progressive pricing
        // Sizes are based on common cake pan sizes used in Indonesia
        $cakeSizes = [
            12 => 15000,   // Mini size - perfect for 2-4 people
            15 => 25000,   // Small size - ideal for 4-6 people
            18 => 40000,   // Medium size - great for 6-10 people
            20 => 55000,   // Large size - suitable for 10-15 people
            22 => 70000,   // Extra large - perfect for 15-20 people
            24 => 90000,   // Party size - ideal for 20+ people
        ];

        $selectedSize = $this->faker->unique()->randomElement(array_keys($cakeSizes));

        return [
            'size' => $selectedSize,
            'price' => $cakeSizes[$selectedSize],
        ];
    }
}
