<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class GrantAdminPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure 'Super Admin' role exists
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);

        // 2. Ensure all permissions exist and are assigned to Super Admin
        $permissions = [
            'view clients',
            'create clients',
            'edit clients',
            'delete clients',
            'view contacts',
            'create contacts',
            'edit contacts',
            'delete contacts',
            'view deals',
            'create deals',
            'edit deals',
            'delete deals',
            'view activities',
            'create activities',
            'manage company',
            'view reports',
            'manage subscriptions',
            'manage users',
            'assign roles'
        ];

        foreach ($permissions as $p) {
            $perm = Permission::firstOrCreate(['name' => $p]);
            if (!$superAdminRole->hasPermissionTo($perm)) {
                $superAdminRole->givePermissionTo($perm);
            }
        }

        // 3. Find User 1 and assign the Super Admin role
        $user = User::find(1);
        if ($user) {
            $user->assignRole($superAdminRole);
            echo "Assigned 'Super Admin' role to user 1.\n";
        } else {
            echo "User 1 not found.\n";
        }

        // 4. Also ensure 'Company Admin' exists and has 'manage users'
        $companyAdminRole = Role::firstOrCreate(['name' => 'Company Admin']);
        $companyAdminRole->givePermissionTo('manage users');

        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
