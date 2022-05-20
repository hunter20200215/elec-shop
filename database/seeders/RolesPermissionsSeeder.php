<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesPermissionsSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            Permission::create(['name' => 'manage-users', 'display_name' => 'Manage users']),
            Permission::create(['name' => 'manage-permissions', 'display_name' => 'Manage permissions']),
            Permission::create(['name' => 'manage-roles', 'display_name' => 'Manage roles']),
            Permission::create(['name' => 'manage-media', 'display_name' => 'Manage media']),
            Permission::create(['name' => 'manage-categories', 'display_name' => 'Manage categories']),
            Permission::create(['name' => 'manage-attributes', 'display_name' => 'Manage attributes']),
            Permission::create(['name' => 'manage-attribute-values', 'display_name' => 'Manage attribute values']),
            Permission::create(['name' => 'manage-settings', 'display_name' => 'Manage settings']),
            Permission::create(['name' => 'manage-products', 'display_name' => 'Manage products']),
            Permission::create(['name' => 'manage-pages', 'display_name' => 'Manage pages']),
            Permission::create(['name' => 'manage-orders', 'display_name' => 'Manage orders']),
            Permission::create(['name' => 'access-admin', 'display_name' => 'Access admin']),
        ];


        $role = Role::create(['name' => 'admin', 'display_name' => "Admin"]);
        Role::create(['name' => 'customer', 'display_name' => "Customer"]);
        $role->syncPermissions($permissions);

        User::first()->assignRole($role);
    }
}
