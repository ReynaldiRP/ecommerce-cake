<?php

namespace Database\Factories;

use App\Models\Cake;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;


/**
 * @extends Factory<Cake>
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
            'Fudge Brownies',
            'Pie Buah',
            'Cupcake (5 pcs)',
            'Cupcake (6 pcs)',
        ];

        $customizedCake = [
            'Tart' => [
                'Black Forest Cake',
                'Red Velvet Cake',
                'Tiramisu Cake',
                'Mocha Cake',
            ],
            'Wedding' => [
                'Traditional Tiered Cake',
                'Naked Cake',
                'Semi-Naked Cake',
            ]
        ];

        $cakeImageUrl = [
            'Pudding Cup' => '/assets/image/cakes/pudding-cup.png',
            'Fudge Brownies' => '/assets/image/cakes/fudge-brownies.png',
            'Pie Buah' => '/assets/image/cakes/pie-buah.png',
            'Cupcake (5 pcs)' => '/assets/image/cakes/cupcakes.png',
            'Cupcake (6 pcs)' => '/assets/image/cakes/cupcakes.png',
            'Wedding' => [
                'Traditional Tiered Cake' => '/assets/image/cakes/traditional-wedding-cake.jpg',
                'Naked Cake' => '/assets/image/cakes/wedding-cake-2.jpg',
                'Semi-Naked Cake' => '/assets/image/cakes/wedding-cake-3.jpg',
            ],
            'Tart' => [
                'Black Forest Cake' => '/assets/image/cakes/black-forrest-cake.jpg',
                'Red Velvet Cake' => '/assets/image/cakes/bento-cake.jpg',
                'Tiramisu Cake' => '/assets/image/cakes/tiramisu-cake.jpg',
                'Mocha Cake' => '/assets/image/cakes/mocha-cake.jpg',
            ],
        ];

        $cakeDescription = [
            'Pudding Cup' => 'Dessert mungil yang memanjakan, disajikan dalam cup transparan, menampilkan lapisan krim custard lembut dan topping buah segar yang menggoda. Cocok untuk Anda yang ingin menikmati hidangan manis personal, kapan saja dan di mana saja—baik sebagai teman ngemil atau penutup santap lezat Anda.',
            'Fudge Brownies' => 'Brownies cokelat pekat berbentuk persegi yang siap memanjakan lidah Anda! Tekstur yang fudgy dan lembut berpadu sempurna dengan rasa cokelat yang kaya dan intens. Cocok untuk dinikmati sendiri atau dibagi bersama teman dan keluarga. Tambahkan es krim atau whipped cream di atasnya untuk sentuhan ekstra yang memanjakan!',
            'Pie Buah' => 'Dessert klasik ala Amerika dengan kulit yang renyah keemasan, diisi dengan buah-buahan musiman yang manis dan segar seperti apel, beri, atau persik. Setiap gigitannya menghadirkan perpaduan tekstur yang sempurna dan sensasi rasa buah yang menyegarkan.',
            'Cupcake (5 pcs)' => 'Kue kecil yang meriah, dipanggang dalam wadah kertas dekoratif. Kue lembut ini hadir dalam berbagai rasa, dilengkapi dengan swirl frosting buttercream, taburan sprinkles, atau dekorasi yang bisa dimakan, menjadikannya sempurna untuk pesta atau sekadar memanjakan diri sendiri.',
            'Cupcake (6 pcs)' => 'Kue kecil yang meriah, dipanggang dalam wadah kertas dekoratif. Kue lembut ini hadir dalam berbagai rasa, dilengkapi dengan swirl frosting buttercream, taburan sprinkles, atau dekorasi yang bisa dimakan, menjadikannya sempurna untuk pesta atau sekadar memanjakan diri sendiri.',
            'Pastry' => 'Kue panggang yang lembut dan renyah, sering kali dibuat dengan mentega atau shortening, seperti croissant, danish, atau tart. Setiap gigitan memberikan sensasi gurih mentega dan kerenyahan yang memuaskan. Baik itu croissant, danish, atau tart, semua pastry ini menghadirkan lapisan-lapisan kelezatan dengan isian manis atau gurih yang memanjakan.',
            'Tart' => [
                'Black Forest Cake' => 'Kue tart klasik dengan lapisan krim lembut, taburan cokelat, dan ceri merah di atasnya. Setiap gigitan menghadirkan sensasi rasa manis, asam, dan gurih yang memanjakan lidah Anda. Cocok untuk dinikmati bersama secangkir teh atau kopi hangat.',
                'Red Velvet Cake' => 'Kue tart merah muda dengan lapisan krim keju lembut yang manis dan gurih. Setiap gigitan menggoda dengan rasa cokelat yang lembut dan keju yang kaya. Cocok untuk dinikmati sebagai hidangan penutup istimewa di hari spesial Anda.',
                'Tiramisu Cake' => 'Kue tart klasik Italia yang lembut dan lezat, diisi dengan lapisan krim keju mascarpone yang manis dan kopi espresso yang kuat. Setiap gigitan menghadirkan perpaduan rasa kopi, cokelat, dan keju yang memanjakan lidah Anda. Cocok untuk dinikmati sebagai hidangan penutup istimewa di hari spesial Anda.',
                'Mocha Cake' => 'Kue tart klasik dengan lapisan krim lembut dan taburan cokelat bubuk di atasnya. Setiap gigitan menghadirkan sensasi rasa manis, asam, dan gurih yang memanjakan lidah Anda dengan aroma kopi yang harum. Cocok untuk dinikmati bersama secangkir teh atau kopi hangat.',
            ],
            'Wedding' => [
                'Traditional Tiered Cake' => 'Kue pernikahan klasik dengan lapisan krim lembut dan hiasan bunga yang indah. Setiap gigitan menghadirkan sensasi rasa manis dan gurih yang memanjakan lidah Anda. Cocok untuk dinikmati bersama keluarga dan teman di hari bahagia Anda.',
                'Naked Cake' => 'Kue pernikahan dengan lapisan krim tipis yang memperlihatkan lapisan kue di dalamnya. Tampilan yang natural dan sederhana ini memberikan kesan hangat dan ramah, cocok untuk pernikahan di taman atau suasana yang santai.',
                'Semi-Naked Cake' => 'Kue pernikahan dengan lapisan krim tipis yang memperlihatkan lapisan kue di dalamnya. Tampilan yang natural dan sederhana ini memberikan kesan hangat dan ramah, cocok untuk pernikahan di taman atau suasana yang santai.',
            ]
        ];

        $cakePrice = [
            'Pudding Cup' => 5000,
            'Pie Buah' => 150000,
            'Cupcake (5 pcs)' => 45000,
            'Cupcake (6 pcs)' => 50000,
            'Fudge Brownies' => 40000,
            'Tart' => [
                'Black Forest Cake' => 120000,
                'Red Velvet Cake' => 120000,
                'Tiramisu Cake' => 120000,
                'Mocha Cake' => 120000,
            ],
            'Wedding' => [
                'Traditional Tiered Cake' => 100000,
                'Naked Cake' => 80000,
                'Semi-Naked Cake' => 90000,
            ],
        ];

        return [
            'name' => $this->faker->unique()->randomElement(array_merge($nonCustomizedCake, ...array_values($customizedCake))),
            'category_id' => function (array $attributes) {
                // Define mapping of cake names to category names
                $categoryMapping = [
                    // Tart cakes
                    'Black Forest Cake' => 'Tart',
                    'Red Velvet Cake' => 'Tart',
                    'Tiramisu Cake' => 'Tart',
                    'Mocha Cake' => 'Tart',

                    // Wedding cakes
                    'Traditional Tiered Cake' => 'Wedding',
                    'Naked Cake' => 'Wedding',
                    'Semi-Naked Cake' => 'Wedding',

                    // Non-customized cakes
                    'Pudding Cup' => 'Pudding',
                    'Fudge Brownies' => 'Brownies',
                    'Pie Buah' => 'Pie',
                    'Cupcake (5 pcs)' => 'Cupcake',
                    'Cupcake (6 pcs)' => 'Cupcake',
                ];

                // Get the category name for this cake
                $categoryName = $categoryMapping[$attributes['name']] ?? null;

                if ($categoryName === null) {
                    Log::error("No category found for cake name '{$attributes['name']}'");
                    return null;
                }

                return Category::query()
                    ->where('name', '=', $categoryName)
                    ->first()
                    ->id;
            },
            'discount_id' => $this->faker->optional(0.2, null)->numberBetween(1, 3),
            'image_url' => function (array $attributes) use ($cakeImageUrl) {
                $cakeName = $attributes['name'];

                // First check if it's a direct mapping
                if (isset($cakeImageUrl[$cakeName])) {
                    return $cakeImageUrl[$cakeName];
                }

                // If not found directly, search in nested categories
                foreach (['Wedding', 'Tart'] as $category) {
                    if (isset($cakeImageUrl[$category][$cakeName])) {
                        return $cakeImageUrl[$category][$cakeName];
                    }
                }

                return null;
            },
            'base_price' => function (array $attributes) use ($cakePrice) {
                $cakeName = $attributes['name'];

                // First check if it's a direct mapping
                if (isset($cakePrice[$cakeName])) {
                    return $cakePrice[$cakeName];
                }

                // If not found directly, search in nested categories
                foreach (['Wedding', 'Tart'] as $category) {
                    if (isset($cakePrice[$category][$cakeName])) {
                        return $cakePrice[$category][$cakeName];
                    }
                }

                return null;
            },
            'discounted_price' => function (array $attributes) {
                if ($attributes['discount_id'] === null) {
                    return 0;
                }

                $discountPercentage = Discount::query()
                    ->where('id', '=', $attributes['discount_id'])
                    ->first()
                    ->discount_percentage;

                return $attributes['base_price'] * (1 - $discountPercentage / 100);

            },
            'description' => function (array $attributes) use ($cakeDescription) {
                $cakeName = $attributes['name'];

                // First check if it's a direct mapping
                if (isset($cakeDescription[$cakeName])) {
                    return $cakeDescription[$cakeName];
                }

                // If not found directly, search in nested categories
                foreach (['Wedding', 'Tart'] as $category) {
                    if (isset($cakeDescription[$category][$cakeName])) {
                        return $cakeDescription[$category][$cakeName];
                    }
                }

                return null;
            },
            'personalization_type' => function (array $attributes) use ($customizedCake) {
                foreach ($customizedCake as $category => $cakes) {
                    if (in_array($attributes['name'], $cakes)) {
                        return 'customized';
                    }
                }
                return 'non-customized';
            },
        ];
    }
}
