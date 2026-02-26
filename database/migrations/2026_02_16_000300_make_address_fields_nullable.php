<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreignId('city_id')->nullable()->change();
            $table->foreignId('country_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->foreignId('city_id')->nullable(false)->change();
            $table->foreignId('country_id')->nullable(false)->change();
        });
    }
};
