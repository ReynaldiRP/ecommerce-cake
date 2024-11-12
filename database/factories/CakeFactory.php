<?php

namespace Database\Factories;

use App\Models\Cake;
use App\Models\Category;
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
            'Tart Cake',
            'Wedding Cake',
        ];

        $cakeImageUrl = [
            'Pudding Cup' => '/assets/image/cakes/pudding-cup.png',
            'Fudge Brownies' => '/assets/image/cakes/fudge-brownies.png',
            'Pie Buah' => '/assets/image/cakes/pie-buah.png',
            'Cupcake (5 pcs)' => '/assets/image/cakes/cupcakes.png',
            'Cupcake (6 pcs)' => '/assets/image/cakes/cupcakes.png',
            'Wedding Cake' => '/assets/image/cakes/cakes.jpg',
            'Tart Cake' => '/assets/image/cakes/bento-cake.jpg',
        ];

        $cakeDescription = [
            'Pudding Cup' => 'Dessert mungil yang memanjakan, disajikan dalam cup transparan, menampilkan lapisan krim custard lembut dan topping buah segar yang menggoda. Cocok untuk Anda yang ingin menikmati hidangan manis personal, kapan saja dan di mana saja—baik sebagai teman ngemil atau penutup santap lezat Anda.',
            'Fudge Brownies' => 'Brownies cokelat pekat berbentuk persegi yang siap memanjakan lidah Anda! Tekstur yang fudgy dan lembut berpadu sempurna dengan rasa cokelat yang kaya dan intens. Cocok untuk dinikmati sendiri atau dibagi bersama teman dan keluarga. Tambahkan es krim atau whipped cream di atasnya untuk sentuhan ekstra yang memanjakan!',
            'Pie Buah' => 'Dessert klasik ala Amerika dengan kulit yang renyah keemasan, diisi dengan buah-buahan musiman yang manis dan segar seperti apel, beri, atau persik. Setiap gigitannya menghadirkan perpaduan tekstur yang sempurna dan sensasi rasa buah yang menyegarkan.',
            'Cupcake (5 pcs)' => 'Kue kecil yang meriah, dipanggang dalam wadah kertas dekoratif. Kue lembut ini hadir dalam berbagai rasa, dilengkapi dengan swirl frosting buttercream, taburan sprinkles, atau dekorasi yang bisa dimakan, menjadikannya sempurna untuk pesta atau sekadar memanjakan diri sendiri.',
            'Cupcake (6 pcs)' => 'Kue kecil yang meriah, dipanggang dalam wadah kertas dekoratif. Kue lembut ini hadir dalam berbagai rasa, dilengkapi dengan swirl frosting buttercream, taburan sprinkles, atau dekorasi yang bisa dimakan, menjadikannya sempurna untuk pesta atau sekadar memanjakan diri sendiri.',
            'Pastry' => 'Kue panggang yang lembut dan renyah, sering kali dibuat dengan mentega atau shortening, seperti croissant, danish, atau tart. Setiap gigitan memberikan sensasi gurih mentega dan kerenyahan yang memuaskan. Baik itu croissant, danish, atau tart, semua pastry ini menghadirkan lapisan-lapisan kelezatan dengan isian manis atau gurih yang memanjakan.',
            'Wedding Cake' => 'Kue yang ringan dan lembut dengan tekstur remah yang halus. Dibuat dari bahan sederhana seperti telur, gula, dan tepung, kue ini cocok menjadi dasar untuk kue berlapis, trifle, atau dinikmati langsung dengan buah beri segar dan krim.',
            'Tart Cake' => 'Kue mungil nan cantik yang pas untuk porsi satu atau dua orang. Dikemas dalam kotak bento yang praktis, kue ini hadir dengan desain yang sederhana namun penuh gaya, cocok sebagai hadiah atau kejutan kecil untuk orang terkasih. Meskipun ukurannya mini, rasanya tetap luar biasa dengan tekstur lembut dan topping yang dapat disesuaikan sesuai selera. Pilihan sempurna untuk merayakan momen spesial dalam keintiman!'
        ];

        $cakePrice = [
            'Pudding Cup' => 5000,
            'Pie Buah' => 150000,
            'Cupcake (5 pcs)' => 45000,
            'Cupcake (6 pcs)' => 50000,
            'Fudge Brownies' => 40000,
            'Tart Cake' => 100000,
            'Wedding Cake' => 130000,
        ];

        return [
            'name' => $this->faker->unique()->randomElement(array_merge($nonCustomizedCake, $customizedCake)),
            'category_id' => function (array $attributes) use ($customizedCake, $nonCustomizedCake) {
                // Define mapping of cake names to category names
                $categoryMapping = [
                    // Customized cakes
                    'Tart Cake' => 'Tart Cake',
                    'Wedding Cake' => 'Wedding Cake',

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
            'image_url' => function (array $attributes) use ($cakeImageUrl) {
                return $cakeImageUrl[$attributes['name']];
            },
            'base_price' => function (array $attributes) use ($cakePrice) {
                return $cakePrice[$attributes['name']];
            },
            'description' => function (array $attributes) use ($cakeDescription) {
                return $cakeDescription[$attributes['name']];
            },
            'personalization_type' => function (array $attributes) use ($customizedCake) {
                return in_array($attributes['name'], $customizedCake) ? 'customized' : 'non-customized';
            },
        ];
    }
}
