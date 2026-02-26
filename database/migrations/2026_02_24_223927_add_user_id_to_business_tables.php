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
        $rootUserId = \Illuminate\Support\Facades\DB::table('users')
            ->where('is_root', true)
            ->value('id');
        $fallbackUserId = \Illuminate\Support\Facades\DB::table('users')->value('id');
        $ownerUserId = $rootUserId ?? $fallbackUserId;

        $tables = ['clients', 'contacts', 'deals'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                if (! Schema::hasColumn($table->getTable(), 'user_id')) {
                    $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
                }
            });

            // Assign existing records to an existing user if available.
            if ($ownerUserId) {
                \Illuminate\Support\Facades\DB::table($tableName)
                    ->whereNull('user_id')
                    ->update(['user_id' => $ownerUserId]);
            }

            if ($ownerUserId) {
                // Only enforce non-null when we can safely backfill.
                Schema::table($tableName, function (Blueprint $table) {
                    $table->foreignId('user_id')->nullable(false)->change();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['clients', 'contacts', 'deals'];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }
    }
};
