<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Carbon;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Reset Cached Roles and Permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions
        $permissions = [
            'access admin panel',
            'dashboard',
            'users',
            'permissions',
            'roles',
            'categories',
            'create-category',
            'edit-category',
            'delete-category',
            'view-trashed-category',
            'restore-category',
            'force-delete-category',
            'products',
            'create-product',
            'edit-product',
            'delete-product',
            'view-trashed-product',
            'restore-product',
            'force-delete-product',
            'delete-product-image',
            'orders',

        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles and Assign Permissions

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Assign Permissions to Roles
        $adminRole->syncPermissions($permissions);
        $customerRole->syncPermissions(['access admin panel','dashboard','categories','products','orders']);

        // Create an Admin User
        $admin = User::firstOrCreate([
            'email' => 'admin@gmail.com'
        ], [
            'name' => 'Admin',
            'password' => bcrypt('admin@123'),
            'email_verified_at' => Carbon::now()->toDateTimeString()
        ]);

        $admin->assignRole($adminRole);


        // Create a Normal User
        $user = User::firstOrCreate([
            'email' => 'user@gmail.com'
        ], [
            'name' => 'User',
            'password' => bcrypt('user@123'),
            'email_verified_at' => Carbon::now()->toDateTimeString()
        ]);

        $user->assignRole($customerRole);

        $this->command->info('Sample Admin and User created and  Roles and permissions seeded successfully!');
    }
}
