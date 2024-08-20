<?php

namespace Database\Factories;

use App\Models\CakeSize;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cake>
 */
class CakeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $cakes = [
            'Base cake',
            'Pudding cup',
            'Pudding box',
            'Pie buah',
            'Cup cake',
            'Pastry',

        ];

        static $uniqueNames = [];

        return [
            'name' => function (array $attributes) use (&$uniqueNames, $cakes) {
                $name = $this->faker->randomElement($cakes);

                if ($name !== 'Base cake') {
                    while (in_array($name, $uniqueNames)) {
                        $name = $this->faker->randomElement($cakes);
                    }
                    $uniqueNames[] = $name;
                }

                return $name;
            },
            'cake_size_id' => function (array $attributes) {
                if ($attributes['name'] === 'Base cake') {
                    $cakeSizeIds = CakeSize::pluck('id')->toArray();
                    return !empty($cakeSizeIds) ? $this->faker->randomElement($cakeSizeIds) : null;
                } else {
                    return null;
                }
            },
            'base_price' => $this->faker->numberBetween(10, 13) * 5000,
            'personalization_type' => function (array $attributes) {
                return $attributes['cake_size_id'] !== null ? 'customized' : 'non-customized';
            }
        ];
    }
}
