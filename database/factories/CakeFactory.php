<?php

namespace Database\Factories;

use App\Models\CakeSize;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;


/**
 * @extends Factory<\App\Models\Cake>
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
            'Bento Cake',
            'Cakes',
        ];

        $cakeImageUrl = [
            'Pudding Cup' => '/assets/image/cakes/pudding-cup.png',
            'Fudge Brownies' => '/assets/image/cakes/fudge-brownies.png',
            'Pie Buah' => '/assets/image/cakes/pie-buah.png',
            'Cupcake (5 pcs)' => '/assets/image/cakes/cupcakes.png',
            'Cupcake (6 pcs)' => '/assets/image/cakes/cupcakes.png',
            'Cakes' => '/assets/image/cakes/cakes.jpg',
            'Bento Cake' => '/assets/image/cakes/bento-cake.jpg',
        ];

        $cakeDescription = [
            'Pudding Cup' => 'Dessert mungil yang memanjakan, disajikan dalam cup transparan, menampilkan lapisan krim custard lembut dan topping buah segar yang menggoda. Cocok untuk Anda yang ingin menikmati hidangan manis personal, kapan saja dan di mana saja—baik sebagai teman ngemil atau penutup santap lezat Anda.',
            'Fudge Brownies' => 'Brownies cokelat pekat berbentuk persegi yang siap memanjakan lidah Anda! Tekstur yang fudgy dan lembut berpadu sempurna dengan rasa cokelat yang kaya dan intens. Cocok untuk dinikmati sendiri atau dibagi bersama teman dan keluarga. Tambahkan es krim atau whipped cream di atasnya untuk sentuhan ekstra yang memanjakan!',
            'Pie Buah' => 'Dessert klasik ala Amerika dengan kulit yang renyah keemasan, diisi dengan buah-buahan musiman yang manis dan segar seperti apel, beri, atau persik. Setiap gigitannya menghadirkan perpaduan tekstur yang sempurna dan sensasi rasa buah yang menyegarkan.',
            'Cupcake (5 pcs)' => 'Kue kecil yang meriah, dipanggang dalam wadah kertas dekoratif. Kue lembut ini hadir dalam berbagai rasa, dilengkapi dengan swirl frosting buttercream, taburan sprinkles, atau dekorasi yang bisa dimakan, menjadikannya sempurna untuk pesta atau sekadar memanjakan diri sendiri.',
            'Cupcake (6 pcs)' => 'Kue kecil yang meriah, dipanggang dalam wadah kertas dekoratif. Kue lembut ini hadir dalam berbagai rasa, dilengkapi dengan swirl frosting buttercream, taburan sprinkles, atau dekorasi yang bisa dimakan, menjadikannya sempurna untuk pesta atau sekadar memanjakan diri sendiri.',
            'Pastry' => 'Kue panggang yang lembut dan renyah, sering kali dibuat dengan mentega atau shortening, seperti croissant, danish, atau tart. Setiap gigitan memberikan sensasi gurih mentega dan kerenyahan yang memuaskan. Baik itu croissant, danish, atau tart, semua pastry ini menghadirkan lapisan-lapisan kelezatan dengan isian manis atau gurih yang memanjakan.',
            'Cakes' => 'Kue yang ringan dan lembut dengan tekstur remah yang halus. Dibuat dari bahan sederhana seperti telur, gula, dan tepung, kue ini cocok menjadi dasar untuk kue berlapis, trifle, atau dinikmati langsung dengan buah beri segar dan krim.',
            'Bento Cake' => 'Kue mungil nan cantik yang pas untuk porsi satu atau dua orang. Dikemas dalam kotak bento yang praktis, kue ini hadir dengan desain yang sederhana namun penuh gaya, cocok sebagai hadiah atau kejutan kecil untuk orang terkasih. Meskipun ukurannya mini, rasanya tetap luar biasa dengan tekstur lembut dan topping yang dapat disesuaikan sesuai selera. Pilihan sempurna untuk merayakan momen spesial dalam keintiman!'
        ];

        $cakePrice = [
            'Pudding Cup' => 5000,
            'Pie Buah' => 150000,
            'Cupcake (5 pcs)' => 45000,
            'Cupcake (6 pcs)' => 50000,
            'Fudge Brownies' => 40000,
            'Bento Cake' => 25000,
            'Cakes' => 60000,
        ];

        static $uniqueNames = [];
        static $assignedSizes = [];

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
            'cake_size_id' => function (array $attributes) use (&$assignedSizes, $customizedCake) {
                if (in_array($attributes['name'], $customizedCake)) {
                    // Initialize array for this cake type if it doesn't exist
                    if (!isset($assignedSizes[$attributes['name']])) {
                        $assignedSizes[$attributes['name']] = [];
                    }

                    // Get all available cake sizes from the database
                    $allCakeSizes = CakeSize::pluck('id')->toArray();
                    // Get sizes that haven't been assigned to this cake type yet
                    $availableSizes = array_diff($allCakeSizes, $assignedSizes[$attributes['name']]);

                    // Debug information
                    Log::info("Creating {$attributes['name']} cake");
                    Log::info("Available sizes: " . implode(', ', $availableSizes));
                    Log::info("Already assigned: " . implode(', ', $assignedSizes[$attributes['name']]));

                    if (!empty($availableSizes)) {
                        // Pick a random available size
                        $selectedSize = $this->faker->randomElement(array_values($availableSizes));
                        // Record that we've used this size for this cake type
                        $assignedSizes[$attributes['name']][] = $selectedSize;
                        return $selectedSize;
                    }
                    // If all sizes are used, return null or handle as needed
                    return null;
                }
                    return null;
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
            'personalization_type' => function (array $attributes) {
                return $attributes['cake_size_id'] !== null ? 'customized' : 'non-customized';
            }
        ];
    }
}
