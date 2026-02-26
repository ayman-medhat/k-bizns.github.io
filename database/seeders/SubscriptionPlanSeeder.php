<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        SubscriptionPlan::create([
            'name' => 'Basic',
            'price' => 29,
            'interval' => 'month',
            'limits' => [
                'max_users' => 3,
                'max_clients' => 10,
                'max_contacts' => 50,
                'max_deals' => 20,
            ],
            'features' => ['Basic Reporting', 'Email Support'],
        ]);

        SubscriptionPlan::create([
            'name' => 'Pro',
            'price' => 99,
            'interval' => 'month',
            'limits' => [
                'max_users' => 10,
                'max_clients' => 100,
                'max_contacts' => 500,
                'max_deals' => 200,
            ],
            'features' => ['Advanced Reporting', 'Priority Support', 'Custom Fields'],
        ]);

        SubscriptionPlan::create([
            'name' => 'Enterprise',
            'price' => 299,
            'interval' => 'month',
            'limits' => [
                'max_users' => 50,
                'max_clients' => 1000,
                'max_contacts' => 5000,
                'max_deals' => 2000,
            ],
            'features' => ['Full Audit Logs', 'Dedicated Support', 'API Access'],
        ]);
    }
}
