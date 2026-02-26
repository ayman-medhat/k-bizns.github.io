<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
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
            'assign roles',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        // Create Roles and Assign Permissions

        // 1. Super Admin (System wide, no company scope needed usually, but here we scope everything)
        $superAdmin = \Spatie\Permission\Models\Role::create(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(\Spatie\Permission\Models\Permission::all());

        // 2. Company Admin
        $companyAdmin = \Spatie\Permission\Models\Role::create(['name' => 'Company Admin']);
        $companyAdmin->givePermissionTo([
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
            'assign roles',
        ]);

        // 3. Sales Manager
        $salesManager = \Spatie\Permission\Models\Role::create(['name' => 'Sales Manager']);
        $salesManager->givePermissionTo([
            'view clients',
            'create clients',
            'edit clients',
            'view contacts',
            'create contacts',
            'edit contacts',
            'view deals',
            'create deals',
            'edit deals',
            'view activities',
            'create activities',
            'view reports',
        ]);

        // 4. Sales Agent
        $salesAgent = \Spatie\Permission\Models\Role::create(['name' => 'Sales Agent']);
        $salesAgent->givePermissionTo([
            'view clients',
            'view contacts',
            'create contacts',
            'edit contacts',
            'view deals',
            'create deals',
            'edit deals',
            'view activities',
            'create activities',
        ]);

        // 5. Accountant
        $accountant = \Spatie\Permission\Models\Role::create(['name' => 'Accountant']);
        $accountant->givePermissionTo(['view reports', 'view deals']);

        // 6. Support
        $support = \Spatie\Permission\Models\Role::create(['name' => 'Support']);
        $support->givePermissionTo(['view clients', 'view contacts', 'view activities', 'create activities']);

        // 7. Viewer
        $viewer = \Spatie\Permission\Models\Role::create(['name' => 'Viewer']);
        $viewer->givePermissionTo(['view clients', 'view contacts', 'view deals']);
    }
}
