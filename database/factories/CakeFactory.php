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
            'Pudding Cup',
            'Pudding Box',
            'Fruit Pie',
            'Cup Cake',
            'Pastry',
        ];

        $customizedCake = [
            'Shape Cakes',
            'Sponge Cake',
            'Vanilla Cake'
        ];

        $cakeDescription = [
            'Pudding Cup' => 'A delightful, individual-sized dessert, encased in a clear cup, showcasing its vibrant layers of creamy custard and fruity toppings. Ideal for those who love to savor a personal treat on-the-go or after a meal.',
            'Pudding Box' => 'A larger, rectangular pudding, perfect for sharing with friends and family. Its smooth, velvety texture combined with rich, sweet flavors makes it a comforting treat that pairs wonderfully with fresh fruit or whipped cream.',
            'Fruit Pie' => 'A classic American dessert with a golden, flaky crust filled with sweet and tangy seasonal fruits, such as apples, berries, or peaches. Each bite offers a delightful contrast of textures and a burst of refreshing fruit flavor.',
            'Cup Cake' => 'A small, festive cake baked in a decorative paper liner. These moist cakes come in various flavors, topped with swirls of buttercream frosting, sprinkles, or edible decorations, making them perfect for parties or personal indulgence.',
            'Pastry' => 'A delicate, flaky baked good, often made with butter or shortening, such as croissants, danishes, or tarts, offering a buttery and satisfying crunch. Whether its a croissant, danish, or tart, each pastry offers layers of satisfying crispness with sweet or savory fillings.',
            'Shape Cakes' => 'A cake shaped like a specific object or character, adding a playful and whimsical touch to any occasion. Whether it’s for a themed birthday party or a special occasion, these cakes are perfect for making a bold, memorable statement.',
            'Sponge Cake' => 'A light and airy cake with a fluffy, delicate crumb. Made with simple ingredients like eggs, sugar, and flour, it serves as a versatile base for layered cakes, trifles, or simply paired with fresh berries and cream.',
            'Vanilla Cake' => 'A timeless classic, this moist vanilla-flavored cake serves as the perfect foundation for a variety of toppings, from rich chocolate ganache to fresh fruit. Its simple yet rich flavor makes it a favorite for all occasions.'
        ];

        $customizedCakePrice = [
            'Shape Cakes' => 90000,
            'Sponge Cake' => 100000,
            'Vanilla Cake' => 60000
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
            'base_price' => function (array $attributes) use ($customizedCakePrice) {
                if ($attributes['cake_size_id'] !== null) {
                    return $customizedCakePrice[$attributes['name']];
                } else {
                    return $this->faker->numberBetween(10, 13) * 5000;
                }
            },
            'description' => function (array $attributes) use ($cakeDescription) {
                return $cakeDescription[$attributes['name']];
            },
            'personalization_type' => function (array $attributes) {
                return $attributes['cake_size_id'] !== null ? 'customized' : 'non-customized';
            }
        ];
    }
}
