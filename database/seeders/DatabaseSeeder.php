<?php

namespace Database\Seeders;

use App\Models\CakeSize;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Flavour;
use App\Models\Topping;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Exception;

class DatabaseSeeder extends Seeder
{
    /**
     * System permissions organized by resource
     */
    private array $permissions = [
        // Cake management
        'create-cake',
        'read-cake',
        'update-cake',
        'delete-cake',

        // Category management
        'create-category',
        'read-category',
        'update-category',
        'delete-category',

        // Discount management
        'create-discount',
        'read-discount',
        'update-discount',
        'delete-discount',

        // Flavour management
        'create-flavour',
        'read-flavour',
        'update-flavour',
        'delete-flavour',

        // Role & Permission management
        'create-role',
        'read-role',
        'update-role',
        'delete-role',
        'create-permission',
        'read-permission',
        'update-permission',
        'delete-permission',

        // Size management
        'create-size',
        'read-size',
        'update-size',
        'delete-size',

        // Topping management
        'create-topping',
        'read-topping',
        'update-topping',
        'delete-topping',

        // Order management
        'update-order-status',
        'read-orders',
        'manage-orders',

        // Dashboard & Analytics
        'read-dashboard',
        'view-analytics',
        'export-reports',

        // User management
        'manage-users',
        'view-customers',
    ];

    /**
     * Role-based permission assignments
     */
    private array $rolePermissions = [
        'owner' => [
            // Full system access
            'create-role',
            'read-role',
            'update-role',
            'delete-role',
            'create-permission',
            'read-permission',
            'update-permission',
            'delete-permission',
            'read-dashboard',
            'view-analytics',
            'export-reports',
            'manage-users',
            'view-customers',
            'manage-orders',
            'read-orders',
        ],
        'admin' => [
            // Product and order management
            'create-cake',
            'read-cake',
            'update-cake',
            'delete-cake',
            'create-category',
            'read-category',
            'update-category',
            'delete-category',
            'create-discount',
            'read-discount',
            'update-discount',
            'delete-discount',
            'create-flavour',
            'read-flavour',
            'update-flavour',
            'delete-flavour',
            'create-size',
            'read-size',
            'update-size',
            'delete-size',
            'create-topping',
            'read-topping',
            'update-topping',
            'delete-topping',
            'update-order-status',
            'manage-orders',
            'read-orders',
            'read-dashboard',
            'view-analytics',
            'view-customers',
        ],
        'pelanggan' => [
            // Customer access only
            'read-cake',
            'read-category',
            'read-flavour',
            'read-size',
            'read-topping',
        ],
    ];

    /**
     * System users configuration
     */
    private array $systemUsers = [
        [
            'username' => 'owner',
            'email' => 'owner@cakestore.local',
            'role' => 'owner',
            'phone_number' => '+62812-3456-7890',
            'address' => 'Jl. Bisnis Utama No. 1, Jakarta Selatan',
            'gender' => 'M',
        ],
        [
            'username' => 'admin',
            'email' => 'admin@cakestore.local',
            'role' => 'admin',
            'phone_number' => '+62813-4567-8901',
            'address' => 'Jl. Operasional No. 5, Jakarta Pusat',
            'gender' => 'F',
        ],
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Security check for production environment
        if (App::environment('production') && !config('seeder.security.production_safe', false)) {
            $this->command->error('❌ Seeder is not configured to run safely in production!');
            $this->command->error('Set SEEDER_PRODUCTION_SAFE=true in your .env file if you really want to run this.');
            return;
        }

        // Check if we should use transactions
        if (config('seeder.security.use_transactions', true)) {
            DB::transaction(function () {
                $this->executeSeeding();
            });
        } else {
            $this->executeSeeding();
        }
    }

    /**
     * Execute the actual seeding process
     */
    private function executeSeeding(): void
    {
        try {
            $this->command->info('🚀 Starting secure database seeding...');
            $this->logAction('Seeding started');

            // Step 1: Create roles and permissions
            $this->seedRolesAndPermissions();

            // Step 2: Create system users
            $this->seedSystemUsers();

            // Step 3: Create customer users
            $this->seedCustomerUsers();

            // Step 4: Create base data
            $this->seedBaseData();

            // Step 5: Create cakes
            $this->seedCakes();

            // Step 6: Create realistic orders
            $this->seedOrders();

            $this->command->info('✅ Database seeding completed successfully!');
            $this->logAction('Seeding completed successfully');
        } catch (Exception $e) {
            $this->command->error("❌ Seeding failed: " . $e->getMessage());
            $this->logAction('Seeding failed: ' . $e->getMessage(), 'error');
            throw $e;
        }
    }

    /**
     * Create roles and permissions with proper assignments
     */
    private function seedRolesAndPermissions(): void
    {
        $this->command->info('📋 Creating roles and permissions...');

        try {
            // Create permissions
            foreach ($this->permissions as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission,
                    'guard_name' => 'web'
                ]);
            }

            // Create roles and assign permissions
            foreach ($this->rolePermissions as $roleName => $permissions) {
                $role = Role::firstOrCreate([
                    'name' => $roleName,
                    'guard_name' => 'web'
                ]);

                $permissionModels = Permission::whereIn('name', $permissions)->get();
                $role->syncPermissions($permissionModels);
            }

            $this->command->info("✓ Created " . count($this->permissions) . " permissions and " . count($this->rolePermissions) . " roles");
            $this->logAction("Created permissions and roles");
        } catch (Exception $e) {
            $this->command->error("Failed to create roles and permissions: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create system users (owner, admin) with secure passwords
     */
    private function seedSystemUsers(): void
    {
        $this->command->info('👤 Creating system users...');

        try {
            foreach ($this->systemUsers as $userData) {
                $role = $userData['role'];
                unset($userData['role']);

                // Generate secure password based on environment
                $password = $this->generateSecurePassword($role);

                // Create user with secure password
                $user = User::firstOrCreate(
                    ['email' => $userData['email']],
                    array_merge($userData, [
                        'password' => Hash::make($password),
                    ])
                );

                // Assign role
                if (!$user->hasRole($role)) {
                    $user->assignRole($role);
                }

                // Log password information for development (not production)
                if (!App::environment('production')) {
                    $this->command->info("  → {$role}: {$userData['email']} (password: {$password})");
                }
            }

            $this->command->info("✓ Created " . count($this->systemUsers) . " system users");
            $this->logAction("Created system users");
        } catch (Exception $e) {
            $this->command->error("Failed to create system users: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create realistic customer users
     */
    private function seedCustomerUsers(): void
    {
        $this->command->info('👥 Creating customer users...');

        try {
            $customerRole = Role::where('name', 'pelanggan')->first();
            $customerCount = config('seeder.users.customer_count', 20);

            // Create predefined realistic customers
            $predefinedCustomers = [
                [
                    'username' => 'andi_pratama',
                    'email' => 'andi.pratama@gmail.com',
                    'phone_number' => '+62821-2345-6789',
                    'address' => 'Jl. Kemang Raya No. 15, Jakarta Selatan',
                    'gender' => 'M',
                ],
                [
                    'username' => 'sari_dewi',
                    'email' => 'sari.dewi@yahoo.com',
                    'phone_number' => '+62822-3456-7890',
                    'address' => 'Jl. Pondok Indah No. 8, Jakarta Selatan',
                    'gender' => 'F',
                ],
                [
                    'username' => 'budi_santoso',
                    'email' => 'budi.santoso@hotmail.com',
                    'phone_number' => '+62823-4567-8901',
                    'address' => 'Jl. BSD Raya No. 22, Tangerang Selatan',
                    'gender' => 'M',
                ],
                [
                    'username' => 'maya_indira',
                    'email' => 'maya.indira@gmail.com',
                    'phone_number' => '+62824-5678-9012',
                    'address' => 'Jl. Kelapa Gading No. 45, Jakarta Utara',
                    'gender' => 'F',
                ],
                [
                    'username' => 'rizki_ahmad',
                    'email' => 'rizki.ahmad@outlook.com',
                    'phone_number' => '+62825-6789-0123',
                    'address' => 'Jl. Menteng Dalam No. 12, Jakarta Pusat',
                    'gender' => 'M',
                ],
            ];

            // Create predefined customers
            foreach ($predefinedCustomers as $customerData) {
                $user = User::firstOrCreate(
                    ['email' => $customerData['email']],
                    array_merge($customerData, [
                        'password' => Hash::make(config('seeder.passwords.customer', 'customer123')),
                    ])
                );

                if (!$user->hasRole('pelanggan')) {
                    $user->assignRole($customerRole);
                }
            }

            // Create additional customers using factory
            $additionalCount = max(0, $customerCount - count($predefinedCustomers));
            if ($additionalCount > 0) {
                $additionalCustomers = User::factory()
                    ->count($additionalCount)
                    ->create([
                        'password' => Hash::make(config('seeder.passwords.customer', 'customer123')),
                    ]);

                foreach ($additionalCustomers as $customer) {
                    if (!$customer->hasRole('pelanggan')) {
                        $customer->assignRole($customerRole);
                    }
                }
            }

            $totalCustomers = count($predefinedCustomers) + $additionalCount;
            $this->command->info("✓ Created {$totalCustomers} customer users");
            $this->logAction("Created {$totalCustomers} customer users");
        } catch (Exception $e) {
            $this->command->error("Failed to create customer users: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create base data (categories, flavours, sizes, toppings, discounts)
     */
    private function seedBaseData(): void
    {
        $this->command->info('🎂 Creating base cake data...');

        try {
            // Create base data only if it doesn't exist
            $dataTypes = [
                'categories' => [Category::class, 6],
                'flavours' => [Flavour::class, 8],
                'cake sizes' => [CakeSize::class, 6],
                'toppings' => [Topping::class, 8],
                'discounts' => [Discount::class, 3],
            ];

            foreach ($dataTypes as $type => [$model, $count]) {
                if ($model::count() === 0) {
                    $model::factory($count)->create();
                    $this->command->info("  → Created {$count} {$type}");
                } else {
                    $this->command->info("  → {$type} already exist, skipping");
                }
            }

            $this->command->info('✓ Base cake data ready');
            $this->logAction("Created base cake data");
        } catch (Exception $e) {
            $this->command->error("Failed to create base data: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create cakes using the CakesSeeder
     */
    private function seedCakes(): void
    {
        $this->command->info('🍰 Creating cakes...');

        try {
            $this->call(CakesSeeder::class);
            $this->command->info('✓ Cakes created');
            $this->logAction("Created cakes");
        } catch (Exception $e) {
            $this->command->error("Failed to create cakes: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Create realistic orders using the EnhancedOrderSeeder
     */
    private function seedOrders(): void
    {
        $this->command->info('📦 Creating realistic orders...');

        try {
            $this->call(EnhancedOrderSeeder::class);
            $this->command->info('✓ Orders created');
            $this->logAction("Created orders");
        } catch (Exception $e) {
            $this->command->error("Failed to create orders: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate secure password based on environment and role
     */
    private function generateSecurePassword(string $role): string
    {
        if (App::environment('production')) {
            // Generate strong random password for production
            return Str::random(32);
        }

        // Use configured passwords for development
        $passwords = config('seeder.passwords', []);
        return $passwords[$role] ?? 'SecurePass123!';
    }

    /**
     * Log seeder actions if logging is enabled
     */
    private function logAction(string $message, string $level = 'info'): void
    {
        if (config('seeder.security.log_actions', true)) {
            Log::channel('daily')->{$level}("DatabaseSeeder: {$message}");
        }
    }
}
