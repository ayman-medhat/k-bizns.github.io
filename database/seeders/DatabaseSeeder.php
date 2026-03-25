<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            WorldSeeder::class,
            IndustriesSeeder::class,
            RolesAndPermissionsSeeder::class,
            SubscriptionPlanSeeder::class,
            CompanyInfoSeeder::class,
            RootUserSeeder::class,
            ErpModuleSeeder::class,
        ]);
    }
}
