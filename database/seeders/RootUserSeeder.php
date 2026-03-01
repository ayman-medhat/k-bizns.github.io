<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RootUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = \App\Models\Company::firstOrCreate(['name' => 'KASHMOS System']);
        $rootPassword = env('ROOT_USER_PASSWORD');

        if (!$rootPassword) {
            $rootPassword = app()->environment(['local', 'testing']) ? 'Admin123!' : Str::random(32);
        }

        $rootUser = \App\Models\User::updateOrCreate(
            ['email' => 'root@kashmos.com'],
            [
                'name' => 'Root Admin',
                'password' => \Illuminate\Support\Facades\Hash::make($rootPassword),
                'is_root' => true,
                'company_id' => $company->id,
            ]
        );

        if (class_exists(\Spatie\Permission\Models\Role::class)
            && \Spatie\Permission\Models\Role::query()->where('name', 'Super Admin')->exists()) {
            $rootUser->assignRole('Super Admin');
        }
    }
}
