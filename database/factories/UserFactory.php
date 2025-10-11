<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Indonesian first names by gender
     */
    private array $indonesianFirstNames = [
        'male' => [
            'Andi',
            'Budi',
            'Dedi',
            'Eko',
            'Fajar',
            'Galih',
            'Hendra',
            'Indra',
            'Joko',
            'Krisna',
            'Lutfi',
            'Made',
            'Nanda',
            'Oka',
            'Putra',
            'Rizki',
            'Surya',
            'Teguh',
            'Ujang',
            'Wahyu',
            'Ahmad',
            'Bayu',
            'Chandra',
            'Dimas',
            'Erlangga',
            'Firdaus',
            'Gunawan',
            'Handoko',
            'Ivan',
            'Jason',
        ],
        'female' => [
            'Ani',
            'Bella',
            'Citra',
            'Dewi',
            'Eka',
            'Fitri',
            'Gita',
            'Hani',
            'Indah',
            'Kartika',
            'Lestari',
            'Maya',
            'Nuri',
            'Putri',
            'Ratna',
            'Sari',
            'Tuti',
            'Uci',
            'Vina',
            'Wulan',
            'Ayu',
            'Bunga',
            'Cahya',
            'Diana',
            'Elsa',
            'Febi',
            'Grace',
            'Hilda',
            'Intan',
            'Jasmine',
        ]
    ];

    /**
     * Indonesian last names
     */
    private array $indonesianLastNames = [
        'Pratama',
        'Santoso',
        'Wijaya',
        'Susanto',
        'Permana',
        'Nugroho',
        'Handayani',
        'Sari',
        'Lestari',
        'Rahayu',
        'Saputra',
        'Saputri',
        'Kurniawan',
        'Kurniawati',
        'Setiawan',
        'Setiawati',
        'Wibowo',
        'Wibawa',
        'Utomo',
        'Utami',
        'Purnomo',
        'Purnama',
        'Suryanto',
        'Suryani',
        'Maharani',
        'Mahendra',
        'Adiputra',
        'Adiputri',
        'Dermawan',
        'Darmawan',
        'Kusuma',
        'Wardana'
    ];

    /**
     * Indonesian cities and areas
     */
    private array $indonesianAreas = [
        'Jakarta Selatan' => ['Kemang', 'Kebayoran Baru', 'Pondok Indah', 'Senayan', 'Tebet', 'Setiabudi'],
        'Jakarta Pusat' => ['Menteng', 'Tanah Abang', 'Gambir', 'Sawah Besar', 'Kemayoran', 'Senen'],
        'Jakarta Utara' => ['Kelapa Gading', 'Pantai Indah Kapuk', 'Pluit', 'Ancol', 'Sunter', 'Tanjung Priok'],
        'Jakarta Timur' => ['Cakung', 'Cipayung', 'Duren Sawit', 'Jatinegara', 'Kramat Jati', 'Makasar'],
        'Jakarta Barat' => ['Grogol Petamburan', 'Kebon Jeruk', 'Kembangan', 'Palmerah', 'Taman Sari', 'Tambora'],
        'Tangerang' => ['BSD', 'Serpong', 'Alam Sutera', 'Gading Serpong', 'Karawaci', 'Lippo Village'],
        'Depok' => ['Margonda', 'Pancoran Mas', 'Cinere', 'Limo', 'Beji', 'Sukmajaya'],
        'Bekasi' => ['Harapan Indah', 'Galaxy', 'Grand Galaxy', 'Kemang Pratama', 'Pekayon', 'Pondok Gede'],
    ];

    /**
     * Street names common in Indonesia
     */
    private array $streetNames = [
        'Jl. Merdeka',
        'Jl. Sudirman',
        'Jl. Thamrin',
        'Jl. Gatot Subroto',
        'Jl. Ahmad Yani',
        'Jl. Diponegoro',
        'Jl. Veteran',
        'Jl. Pahlawan',
        'Jl. Raya Kebayoran',
        'Jl. Kemang Raya',
        'Jl. Senopati',
        'Jl. Kuningan',
        'Jl. Casablanca',
        'Jl. TB Simatupang',
        'Jl. Rasuna Said',
        'Jl. HR Rasuna',
        'Jl. Kartini',
        'Jl. Cut Nyak Dien',
        'Jl. RA Kartini',
        'Jl. Dewi Sartika'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement(['M', 'F']);
        $genderKey = $gender === 'M' ? 'male' : 'female';

        // Generate realistic Indonesian name
        $firstName = $this->faker->randomElement($this->indonesianFirstNames[$genderKey]);
        $lastName = $this->faker->randomElement($this->indonesianLastNames);
        $fullName = $firstName . ' ' . $lastName;

        // Generate username from name
        $username = strtolower(str_replace(' ', '_', $fullName));

        // Generate realistic Indonesian address
        $cityKeys = array_keys($this->indonesianAreas);
        $selectedCity = $this->faker->randomElement($cityKeys);
        $cityData = $this->indonesianAreas[$selectedCity];
        $area = $this->faker->randomElement($cityData);
        $street = $this->faker->randomElement($this->streetNames);
        $number = $this->faker->numberBetween(1, 999);
        $address = "{$street} No. {$number}, {$area}, {$selectedCity}";

        // Generate realistic Indonesian phone number
        $phoneNumber = '+628' . $this->faker->randomElement(['1', '2', '3', '5', '7', '8']) .
            $this->faker->numerify('#-####-####');

        return [
            'username' => $username,
            'email' => $this->generateRealisticEmail($firstName, $lastName),
            'password' => static::$password ??= Hash::make('customer123'),
            'phone_number' => $phoneNumber,
            'address' => $address,
            'gender' => $gender,
        ];
    }

    /**
     * Generate realistic email based on Indonesian naming patterns
     */
    private function generateRealisticEmail(string $firstName, string $lastName): string
    {
        $emailProviders = [
            'gmail.com' => 40,
            'yahoo.com' => 20,
            'hotmail.com' => 15,
            'outlook.com' => 10,
            'yahoo.co.id' => 8,
            'live.com' => 4,
            'icloud.com' => 3
        ];

        // Choose provider based on weights
        $provider = $this->weightedChoice($emailProviders);

        // Generate email variations
        $emailFormats = [
            strtolower($firstName . '.' . $lastName),
            strtolower($firstName . $lastName),
            strtolower($firstName) . $this->faker->numberBetween(1, 999),
            strtolower($lastName) . '.' . strtolower($firstName),
            strtolower(substr($firstName, 0, 1)) . '.' . strtolower($lastName),
            strtolower($firstName) . '_' . strtolower($lastName),
        ];

        $localPart = $this->faker->randomElement($emailFormats);

        return $localPart . '@' . $provider;
    }

    /**
     * Weighted random choice helper
     */
    private function weightedChoice(array $choices): string
    {
        $totalWeight = array_sum($choices);
        $random = $this->faker->numberBetween(1, $totalWeight);

        $currentWeight = 0;
        foreach ($choices as $choice => $weight) {
            $currentWeight += $weight;
            if ($random <= $currentWeight) {
                return $choice;
            }
        }

        return array_key_first($choices);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            // No email verification column in this table
        ]);
    }

    /**
     * Create a verified user
     */
    public function verified(): static
    {
        return $this->state(fn(array $attributes) => [
            // No email verification column in this table
        ]);
    }

    /**
     * Create a male user
     */
    public function male(): static
    {
        return $this->state(function (array $attributes) {
            $firstName = $this->faker->randomElement($this->indonesianFirstNames['male']);
            $lastName = $this->faker->randomElement($this->indonesianLastNames);
            $fullName = $firstName . ' ' . $lastName;

            return [
                'username' => strtolower(str_replace(' ', '_', $fullName)),
                'email' => $this->generateRealisticEmail($firstName, $lastName),
                'gender' => 'M',
            ];
        });
    }

    /**
     * Create a female user
     */
    public function female(): static
    {
        return $this->state(function (array $attributes) {
            $firstName = $this->faker->randomElement($this->indonesianFirstNames['female']);
            $lastName = $this->faker->randomElement($this->indonesianLastNames);
            $fullName = $firstName . ' ' . $lastName;

            return [
                'username' => strtolower(str_replace(' ', '_', $fullName)),
                'email' => $this->generateRealisticEmail($firstName, $lastName),
                'gender' => 'F',
            ];
        });
    }
}
