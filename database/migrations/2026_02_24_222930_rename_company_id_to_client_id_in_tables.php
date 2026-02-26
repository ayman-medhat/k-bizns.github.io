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
        Schema::table('contacts', function (Blueprint $table) {
            $table->renameColumn('company_id', 'client_id');
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->renameColumn('company_id', 'client_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->renameColumn('client_id', 'company_id');
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->renameColumn('client_id', 'company_id');
        });
    }
};
