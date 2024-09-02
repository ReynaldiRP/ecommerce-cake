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

        $nonCustomizedCake = [
            'Pudding cup',
            'Pudding box',
            'Fruit pie',
            'Cup cake',
            'Pastry',
        ];

        $customizedCake = [
            'Butter cake',
            'Sponge cake',
        ];

        static $uniqueNames = [];
        $name = null;

        if (count($uniqueNames) < count($nonCustomizedCake)) {
            do {
                $name = $this->faker->randomElement($nonCustomizedCake);
            } while (in_array($name, $uniqueNames));
            $uniqueNames[] = $name;
        } else {
            $name =
                $this->faker->randomElement($customizedCake);;
        }


        return [
            'name' => $name,
            'cake_size_id' => function (array $attributes) use ($customizedCake) {
                if (in_array($attributes['name'], $customizedCake)) {
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
