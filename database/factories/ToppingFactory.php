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
        // Realistic cake toppings with proper naming
        $toppings = [
            'Fresh Kiwi Slices',
            'Fresh Strawberries',
            'Crushed Hazelnuts',
            'Kit Kat Chunks',
            'Gummy Bears',
            'Chocolate Lollipops',
            'French Macarons',
            'Premium Chocolate Bar'
        ];

        // Realistic pricing based on ingredient cost and complexity
        $toppingPrices = [
            'Fresh Kiwi Slices' => 8000,      // Fresh fruit - seasonal pricing
            'Fresh Strawberries' => 10000,    // Premium fresh fruit
            'Crushed Hazelnuts' => 12000,     // Premium nuts
            'Kit Kat Chunks' => 15000,        // Branded candy
            'Gummy Bears' => 6000,            // Basic candy
            'Chocolate Lollipops' => 8000,    // Decorative candy
            'French Macarons' => 25000,       // Premium pastry
            'Premium Chocolate Bar' => 18000  // High-quality chocolate
        ];

        // Realistic image paths for toppings
        $toppingImages = [
            'Fresh Kiwi Slices' => '/assets/image/toppings/kiwi-slices.jpg',
            'Fresh Strawberries' => '/assets/image/toppings/fresh-strawberries.jpg',
            'Crushed Hazelnuts' => '/assets/image/toppings/hazelnuts.jpg',
            'Kit Kat Chunks' => '/assets/image/toppings/kitkat-chunks.jpg',
            'Gummy Bears' => '/assets/image/toppings/gummy-bears.jpg',
            'Chocolate Lollipops' => '/assets/image/toppings/chocolate-lollipops.jpg',
            'French Macarons' => '/assets/image/toppings/french-macarons.jpg',
            'Premium Chocolate Bar' => '/assets/image/toppings/chocolate-bar.jpg'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($toppings),
            'price' => function (array $attributes) use ($toppingPrices) {
                return $toppingPrices[$attributes['name']];
            },
            'image_url' => function (array $attributes) use ($toppingImages) {
                return $toppingImages[$attributes['name']] ?? '/assets/image/toppings/default.jpg';
            },
        ];
    }
}
