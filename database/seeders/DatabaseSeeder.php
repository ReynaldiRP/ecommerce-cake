<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CakeSize;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Flavour;
use App\Models\Topping;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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

        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        User::factory()->createMany([
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

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // create permissions based on the permissions array
        foreach ($this->permissions as $permission) {
            $permissions = Permission::where('name', $permission)->first();
            if ($permissions) {
                $role = Role::where('name', 'admin')->first();
                $role->givePermissionTo($permissions);
            }
        }

        $userAssignRole = User::where('username', 'admin')->first();
        $userAssignRole->assignRole('admin');


        Flavour::factory(8)->create();
        CakeSize::factory(6)->create();
        Topping::factory(8)->create();
        Category::factory(6)->create();
        Discount::factory(3)->create();
    }
}
