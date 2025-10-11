<?php

namespace Database\Factories;

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
        // Realistic cake flavours with proper naming and pricing
        $flavours = [
            'Black Forest',
            'Double Chocolate',
            'Strawberry Cream',
            'Vanilla Cream',
            'Blueberry Cream',
            'Pandan',
            'Red Velvet',
            'Matcha Green Tea'
        ];

        // Pricing based on ingredient complexity and popularity
        $flavourPrices = [
            'Black Forest' => 45000,      // Premium: cherries + chocolate
            'Double Chocolate' => 40000,   // Premium: high chocolate content
            'Strawberry Cream' => 35000,   // Standard: fruit flavor
            'Vanilla Cream' => 30000,      // Basic: simple vanilla
            'Blueberry Cream' => 38000,    // Premium: imported berries
            'Pandan' => 32000,             // Local: traditional Indonesian
            'Red Velvet' => 42000,         // Premium: cream cheese + cocoa
            'Matcha Green Tea' => 48000    // Premium: imported matcha powder
        ];

        // Realistic image paths for flavours
        $flavourImages = [
            'Black Forest' => '/assets/image/flavours/black-forest.jpg',
            'Double Chocolate' => '/assets/image/flavours/double-chocolate.jpg',
            'Strawberry Cream' => '/assets/image/flavours/strawberry-cream.jpg',
            'Vanilla Cream' => '/assets/image/flavours/vanilla-cream.jpg',
            'Blueberry Cream' => '/assets/image/flavours/blueberry-cream.jpg',
            'Pandan' => '/assets/image/flavours/pandan.jpg',
            'Red Velvet' => '/assets/image/flavours/red-velvet.jpg',
            'Matcha Green Tea' => '/assets/image/flavours/matcha.jpg'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($flavours),
            'price' => function (array $attributes) use ($flavourPrices) {
                return $flavourPrices[$attributes['name']];
            },
            'image_url' => function (array $attributes) use ($flavourImages) {
                return $flavourImages[$attributes['name']] ?? '/assets/image/flavours/default.jpg';
            },
        ];
    }
}
