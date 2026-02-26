<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Rename existing columns
            $table->renameColumn('first_name', 'first_name_en');
            $table->renameColumn('last_name', 'last_name_en');

            // Add new columns
            $table->string('first_name_ar')->nullable()->after('first_name_en');
            $table->string('last_name_ar')->nullable()->after('last_name_en');

            $table->foreignId('nationality_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->string('national_id')->nullable();
            $table->string('passport_no')->nullable();

            $table->date('birthdate')->nullable();
            $table->string('category')->nullable();

            $table->foreignId('address_id')->nullable()->constrained('addresses')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->renameColumn('first_name_en', 'first_name');
            $table->renameColumn('last_name_en', 'last_name');

            $table->dropColumn([
                'first_name_ar',
                'last_name_ar',
                'nationality_id',
                'national_id',
                'passport_no',
                'birthdate',
                'category',
                'address_id',
            ]);
        });
    }
};
