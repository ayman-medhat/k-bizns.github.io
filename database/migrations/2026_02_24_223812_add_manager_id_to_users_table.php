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
        Schema::table('users', function (Blueprint $table) {
            // Already added to fillable in User model earlier
            if (! Schema::hasColumn('users', 'manager_id')) {
                $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'manager_id')) {
                try {
                    $table->dropForeign(['manager_id']);
                } catch (\Throwable $e) {
                    // Ignore when foreign key does not exist.
                }
                $table->dropColumn('manager_id');
            }
        });
    }
};
