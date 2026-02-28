<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class FixUserPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure the permission exists
        $permission = Permission::firstOrCreate(['name' => 'manage users']);

        // Ensure Company Admin role has it
        $role = Role::where('name', 'Company Admin')->first();
        if ($role) {
            $role->givePermissionTo($permission);
        }

        // Ensure Super Admin role has it (and all other permissions)
        $superAdmin = Role::where('name', 'Super Admin')->first();
        if ($superAdmin) {
            $superAdmin->givePermissionTo(Permission::all());
        }

        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
