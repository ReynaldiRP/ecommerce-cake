<?php

namespace Database\Factories;

use Carbon\Carbon;
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
        // Realistic discount campaigns
        $discountCampaigns = [
            [
                'name' => 'Weekend Special',
                'percentage' => 15.00,
            ],
            [
                'name' => 'Birthday Month Promo',
                'percentage' => 20.00,
            ],
            [
                'name' => 'Holiday Season Sale',
                'percentage' => 25.00,
            ],
            [
                'name' => 'First Time Customer',
                'percentage' => 10.00,
            ],
            [
                'name' => 'Bulk Order Discount',
                'percentage' => 30.00,
            ],
            [
                'name' => 'Anniversary Special',
                'percentage' => 35.00,
            ]
        ];

        $campaign = $this->faker->randomElement($discountCampaigns);

        // Generate realistic date ranges
        $startDate = $this->faker->dateTimeBetween('-3 months', '+1 month');
        $endDate = Carbon::instance($startDate)->addDays($this->faker->numberBetween(7, 90));

        return [
            'name' => $campaign['name'],
            'discount_percentage' => $campaign['percentage'],
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ];
    }

    /**
     * Create an active discount
     */
    public function active(): static
    {
        return $this->state(function (array $attributes) {
            $now = Carbon::now();

            return [
                'start_date' => $now->subDays(10)->format('Y-m-d'),
                'end_date' => $now->addDays(30)->format('Y-m-d'),
            ];
        });
    }

    /**
     * Create an expired discount
     */
    public function expired(): static
    {
        return $this->state(function (array $attributes) {
            $endDate = Carbon::now()->subDays($this->faker->numberBetween(1, 30));
            $startDate = Carbon::instance($endDate)->subDays($this->faker->numberBetween(7, 60));

            return [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ];
        });
    }

    /**
     * Create a future discount
     */
    public function upcoming(): static
    {
        return $this->state(function (array $attributes) {
            $startDate = Carbon::now()->addDays($this->faker->numberBetween(1, 30));
            $endDate = Carbon::instance($startDate)->addDays($this->faker->numberBetween(7, 60));

            return [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ];
        });
    }
}
