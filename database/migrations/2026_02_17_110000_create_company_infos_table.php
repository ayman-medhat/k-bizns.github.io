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
        Schema::create('company_infos', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('name');
            $blueprint->text('address');
            $blueprint->string('email');
            $blueprint->string('phone');
            $blueprint->string('logo');
            $blueprint->string('commercial_reg')->nullable();
            $blueprint->string('tax_card')->nullable();
            $blueprint->string('industrial');
            $blueprint->text('description');
            $blueprint->string('website')->nullable();
            $blueprint->string('facebook')->nullable();
            $blueprint->string('youtube')->nullable();
            $blueprint->string('founder');
            $blueprint->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_infos');
    }
};
