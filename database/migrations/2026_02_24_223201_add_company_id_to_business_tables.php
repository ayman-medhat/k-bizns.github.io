<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create/get a default company for existing data
        $companyData = [
            'name' => 'Default Company',
        ];

        $defaultCompany = \Illuminate\Support\Facades\DB::table('companies')->where('name', 'Default Company')->first();

        if (! $defaultCompany) {
            $defaultCompanyId = \Illuminate\Support\Facades\DB::table('companies')->insertGetId(array_merge($companyData, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        } else {
            $defaultCompanyId = $defaultCompany->id;
        }

        $tables = ['users', 'clients', 'contacts', 'deals', 'activities', 'addresses'];

        foreach ($tables as $tableName) {
            if (! Schema::hasColumn($tableName, 'company_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->unsignedBigInteger('company_id')->nullable();
                });
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                try {
                    $table->foreign('company_id', $tableName.'_tenant_company_id_foreign')
                        ->references('id')
                        ->on('companies')
                        ->cascadeOnDelete();
                } catch (\Throwable $e) {
                    // Ignore when constraint already exists.
                }
            });

            // 2. Assign existing records to the default company
            \Illuminate\Support\Facades\DB::table($tableName)->whereNull('company_id')->update(['company_id' => $defaultCompanyId]);

            // 3. Make the column non-nullable after migration
            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedBigInteger('company_id')->nullable(false)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['users', 'clients', 'contacts', 'deals', 'activities', 'addresses'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (Schema::hasColumn($tableName, 'company_id')) {
                    try {
                        $table->dropForeign($tableName.'_tenant_company_id_foreign');
                    } catch (\Throwable $e) {
                        try {
                            $table->dropForeign(['company_id']);
                        } catch (\Throwable $e) {
                            // Ignore when foreign key does not exist.
                        }
                    }

                    $table->dropColumn('company_id');
                }
            });
        }

        \Illuminate\Support\Facades\DB::table('companies')->where('name', 'Default Company')->delete();
    }
};
