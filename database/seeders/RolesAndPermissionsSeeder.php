<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'view contributions']);
        Permission::create(['name' => 'make contributions']);
        Permission::create(['name' => 'manage contributions']);
        Permission::create(['name' => 'manage users']);

        // Create roles and assign created permissions

        // Member role
        $memberRole = Role::create(['name' => 'member']);
        $memberRole->givePermissionTo(['view contributions', 'make contributions']);

        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($memberRole->permissions); // Inherit member permissions
        $adminRole->givePermissionTo(['manage contributions', 'manage users']);

        // Super-admin role
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $superAdminRole->givePermissionTo(Permission::all()); // Grant all permissions
    }
}
