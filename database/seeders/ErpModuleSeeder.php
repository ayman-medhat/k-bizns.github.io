<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Contact;
use App\Models\Client;
use App\Models\Deal;
use App\Models\Lead;
use App\Models\Company;

class ErpModuleSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::first();
        if (!$company) {
            return;
        }

        // Create dummy Products
        Product::firstOrCreate(
            ['sku' => 'PRD-001'],
            [
                'name_translations' => ['en' => 'Enterprise License', 'ar' => 'ترخيص الشركات'],
                'description_translations' => ['en' => 'Full access ERP license', 'ar' => 'وصول كامل للنظام'],
                'sale_price' => 5000.00,
                'company_id' => $company->id,
            ]
        );

        // Create dummy Employees
        Employee::firstOrCreate(
            ['email' => 'john.doe@example.com'],
            [
                'name_translations' => ['en' => 'John Doe', 'ar' => 'جون دو'],
                'job_title' => 'Sales Manager',
                'company_id' => $company->id,
            ]
        );

        // Create Client
        $client = Client::firstOrCreate(
            ['email' => 'client@acme.inc'],
            [
                'name' => 'Acme Corporation',
                'phone' => '+15551234567',
                'status' => 'active',
                'company_id' => $company->id,
            ]
        );

        // Create Contact
        Contact::firstOrCreate(
            ['email' => 'jane.smith@acme.inc'],
            [
                'first_name_en' => 'Jane',
                'last_name_en' => 'Smith',
                'first_name_ar' => 'جين',
                'last_name_ar' => 'سميث',
                'phone' => '+15559876543',
                'national_id' => '12345678901234',
                'client_id' => $client->id,
                'category' => 'customer',
                'company_id' => $company->id,
            ]
        );

        // Create Deal
        Deal::firstOrCreate(
            ['title' => 'Q4 Enterprise Plan Upgrade'],
            [
                'value' => 15000.00,
                'client_id' => $client->id,
                'status' => 'negotiation',
                'company_id' => $company->id,
            ]
        );

        // Create Lead
        Lead::firstOrCreate(
            ['email' => 'prospect@newcorp.com'],
            [
                'first_name' => 'Alice',
                'last_name' => 'Johnson',
                'company_name' => 'New Corp LLC',
                'status' => 'new',
                'value' => 25000.00,
                'source' => 'Website',
                'company_id' => $company->id,
            ]
        );
    }
}
