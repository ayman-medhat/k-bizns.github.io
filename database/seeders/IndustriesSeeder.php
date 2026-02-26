<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class IndustriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industries = [
            ['name_en' => 'Technology', 'name_ar' => 'تكنولوجيا'],
            ['name_en' => 'Finance', 'name_ar' => 'مالية'],
            ['name_en' => 'Healthcare', 'name_ar' => 'رعاية صحية'],
            ['name_en' => 'Education', 'name_ar' => 'تعليم'],
            ['name_en' => 'Retail', 'name_ar' => 'تجزئة'],
            ['name_en' => 'Manufacturing', 'name_ar' => 'تصنيع'],
            ['name_en' => 'Construction', 'name_ar' => 'بناء'],
            ['name_en' => 'Real Estate', 'name_ar' => 'عقارات'],
            ['name_en' => 'Transportation', 'name_ar' => 'نقل'],
            ['name_en' => 'Agriculture', 'name_ar' => 'زراعة'],
            ['name_en' => 'Energy', 'name_ar' => 'طاقة'],
            ['name_en' => 'Telecommunications', 'name_ar' => 'اتصالات'],
            ['name_en' => 'Entertainment', 'name_ar' => 'ترفيه'],
            ['name_en' => 'Hospitality', 'name_ar' => 'ضيافة'],
            ['name_en' => 'Consulting', 'name_ar' => 'استشارات'],
        ];

        foreach ($industries as $industry) {
            \App\Models\Industry::create($industry);
        }
    }
}
