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
        Schema::table('companies', function (Blueprint $table) {

            $table->string('logo_path')->nullable()->after('name');
            $table->foreignId('industry_id')->nullable()->after('website')->constrained('industries')->nullOnDelete();
            $table->foreignId('address_id')->nullable()->after('industry_id')->constrained('addresses')->nullOnDelete();
            $table->foreignId('phone_country_id')->nullable()->after('email')->constrained('countries')->nullOnDelete();
            // We already have email and phone and address(text) in original schema.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {

            //
        });
    }
};
