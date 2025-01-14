<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CakeSize;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Flavour;
use App\Models\OrderItem;
use App\Models\Topping;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{

    private array $permissions = [
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
        'create-role',
        'read-role',
        'update-role',
        'delete-role',
        'create-permission',
        'read-permission',
        'update-permission',
        'delete-permission',
        'create-size',
        'read-size',
        'update-size',
        'delete-size',
        'create-topping',
        'read-topping',
        'update-topping',
        'delete-topping',
        'update-order-status',
    ];


    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        User::factory()->createMany([
            [
                'username' => 'owner',
                'email' => 'owner@example.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('12345678'),
            ],
            [
                'username' => 'user',
                'email' => 'user@example.com',
                'password' => Hash::make('12345678'),
            ]
        ]);
        Role::create(['name' => 'owner']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // create permissions based on the permissions array
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // assign permissions to roles
        $ownerPermissions = Permission::query()->where('name', 'LIKE', '%role')
            ->orWhere('name', 'LIKE', '%permission')->get();

        $adminPermissions = Permission::query()->where('name', 'LIKE', '%cake')
            ->orWhere('name', 'LIKE', '%category')
            ->orWhere('name', 'LIKE', '%discount')
            ->orWhere('name', 'LIKE', '%flavour')
            ->orWhere('name', 'LIKE', '%size')
            ->orWhere('name', 'LIKE', '%topping')
            ->orWhere('name', 'LIKE', '%order-status')->get();

        if ($ownerPermissions) {
            // assign permissions to roles
            collect(['owner', 'admin'])->each(function ($role) use ($ownerPermissions, $adminPermissions) {
                Role::query()->where('name', $role)->first()->syncPermissions($role === 'owner' ? $ownerPermissions : $adminPermissions);
            });
        }

        // assign user roles
        collect(['admin', 'user', 'owner'])->each(function ($role) {
            User::query()->where('username', $role)->first()->assignRole($role);
        });

        Flavour::factory(8)->create();
        CakeSize::factory(6)->create();
        Topping::factory(8)->create();
        Category::factory(6)->create();
        Discount::factory(3)->create();

        $this->call([
            CakesSeeder::class,
            OrderSeeder::class,
            PaymentSeeder::class
        ]);
    }
}
