<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\ErpModuleSeeder;
use Database\Seeders\RootUserSeeder;
use Database\Seeders\CompanyInfoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_orders_page_renders_for_authenticated_admin(): void
    {
        $this->seed(CompanyInfoSeeder::class);
        $this->seed(RootUserSeeder::class);
        $this->seed(ErpModuleSeeder::class);

        $user = User::first();

        $response = $this->actingAs($user)->get('/erp/sales-orders');
        $response->assertStatus(200);
    }
}
