<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class WorldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Egypt (Default)
        $egypt = Country::create([
            'name_en' => 'Egypt',
            'name_ar' => 'مصر',
            'nationality_en' => 'Egyptian',
            'nationality_ar' => 'مصري',
            'phone_code' => '+20',
        ]);

        City::insert([
            ['name_en' => 'Cairo', 'name_ar' => 'القاهرة', 'country_id' => $egypt->id],
            ['name_en' => 'Alexandria', 'name_ar' => 'الإسكندرية', 'country_id' => $egypt->id],
            ['name_en' => 'Giza', 'name_ar' => 'الجيزة', 'country_id' => $egypt->id],
        ]);

        // 2. Saudi Arabia
        $ksa = Country::create([
            'name_en' => 'Saudi Arabia',
            'name_ar' => 'السعودية',
            'nationality_en' => 'Saudi',
            'nationality_ar' => 'سعودي',
            'phone_code' => '+966',
        ]);

        City::insert([
            ['name_en' => 'Riyadh', 'name_ar' => 'الرياض', 'country_id' => $ksa->id],
            ['name_en' => 'Jeddah', 'name_ar' => 'جدة', 'country_id' => $ksa->id],
        ]);

        // 3. USA
        $usa = Country::create([
            'name_en' => 'United States',
            'name_ar' => 'الولايات المتحدة',
            'nationality_en' => 'American',
            'nationality_ar' => 'أمريكي',
            'phone_code' => '+1',
        ]);

        City::insert([
            ['name_en' => 'New York', 'name_ar' => 'نيويورك', 'country_id' => $usa->id],
            ['name_en' => 'Los Angeles', 'name_ar' => 'لوس أنجلوس', 'country_id' => $usa->id],
        ]);
    }
}
