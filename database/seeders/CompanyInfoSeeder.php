<?php

namespace Database\Seeders;

use App\Models\CompanyInfo;
use Illuminate\Database\Seeder;

class CompanyInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyInfo::updateOrCreate(
            ['name' => 'Kashmos'],
            [
                'address' => '390 ElNakeel 1, October\'s Gardens, Giza, Egypt',
                'email' => 'kashmos@outlook.com',
                'phone' => '+201012872168',
                'logo' => 'company_logos/kashmos_logo.png',
                'commercial_reg' => null,
                'tax_card' => null,
                'industrial' => 'Information Technology (IT) Services <br/> & Business Development Services',
                'description' => 'Founded in 2015, <strong style="color: #ff8100; font-family: \'Eagle Horizon-Personal use\', sans-serif;">Kashmos</strong> has spent nearly a decade bridging the gap between technology and business growth. We\'re not just technicians—we\'re strategic business development partners who understand that technology should drive your success. We deliver end-to-end IT solutions including custom application development, robust network infrastructure design, and comprehensive IT support services. As authorized resellers of computers, laptops, and surveillance systems, we combine quality hardware with expert integration. What sets us apart is our business-first approach: we don\'t just fix technical problems—we identify opportunities to leverage technology for your company\'s growth and competitive advantage.',
                'website' => null,
                'facebook' => null,
                'youtube' => null,
                'founder' => 'Eng. Ayman Medhat',
            ]
        );
    }
}
