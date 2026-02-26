<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RootUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = \App\Models\Company::firstOrCreate(['name' => 'KASHMOS System']);

        \App\Models\User::updateOrCreate(
            ['email' => 'root@kashmos.com'],
            [
                'name' => 'Root Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('Admin123!'),
                'is_root' => true,
                'company_id' => $company->id,
            ]
        );
    }
}
