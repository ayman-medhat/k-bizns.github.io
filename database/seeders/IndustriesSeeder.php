<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Seeder;

class IndustriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Based on NAICS sector-level categories.
        // Source: https://www.census.gov/naics/
        $industries = [
            ['name_en' => 'Agriculture, Forestry, Fishing and Hunting', 'name_ar' => 'الزراعة والغابات وصيد الأسماك والقنص'],
            ['name_en' => 'Mining, Quarrying, and Oil and Gas Extraction', 'name_ar' => 'التعدين واستغلال المحاجر واستخراج النفط والغاز'],
            ['name_en' => 'Utilities', 'name_ar' => 'المرافق'],
            ['name_en' => 'Construction', 'name_ar' => 'الإنشاءات'],
            ['name_en' => 'Manufacturing', 'name_ar' => 'التصنيع'],
            ['name_en' => 'Wholesale Trade', 'name_ar' => 'تجارة الجملة'],
            ['name_en' => 'Retail Trade', 'name_ar' => 'تجارة التجزئة'],
            ['name_en' => 'Transportation and Warehousing', 'name_ar' => 'النقل والتخزين'],
            ['name_en' => 'Information', 'name_ar' => 'المعلومات'],
            ['name_en' => 'Finance and Insurance', 'name_ar' => 'التمويل والتأمين'],
            ['name_en' => 'Real Estate and Rental and Leasing', 'name_ar' => 'العقارات والتأجير والاستئجار'],
            ['name_en' => 'Professional, Scientific, and Technical Services', 'name_ar' => 'الخدمات المهنية والعلمية والتقنية'],
            ['name_en' => 'Management of Companies and Enterprises', 'name_ar' => 'إدارة الشركات والمنشآت'],
            ['name_en' => 'Administrative and Support and Waste Management and Remediation Services', 'name_ar' => 'الخدمات الإدارية والدعم وإدارة النفايات والمعالجة'],
            ['name_en' => 'Educational Services', 'name_ar' => 'الخدمات التعليمية'],
            ['name_en' => 'Health Care and Social Assistance', 'name_ar' => 'الرعاية الصحية والمساعدة الاجتماعية'],
            ['name_en' => 'Arts, Entertainment, and Recreation', 'name_ar' => 'الفنون والترفيه والاستجمام'],
            ['name_en' => 'Accommodation and Food Services', 'name_ar' => 'خدمات الإقامة والطعام'],
            ['name_en' => 'Other Services (except Public Administration)', 'name_ar' => 'خدمات أخرى (باستثناء الإدارة العامة)'],
            ['name_en' => 'Public Administration', 'name_ar' => 'الإدارة العامة'],
        ];

        foreach ($industries as $industry) {
            Industry::updateOrCreate(
                ['name_en' => $industry['name_en']],
                ['name_ar' => $industry['name_ar']]
            );
        }
    }
}
