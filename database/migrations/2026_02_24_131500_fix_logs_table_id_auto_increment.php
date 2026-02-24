<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Fixes production MySQL error: "Field 'id' doesn't have a default value"
     * when the logs table was created without AUTO_INCREMENT on id.
     * MySQL requires the auto column to be a key; we ensure id is PRIMARY KEY.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver !== 'mysql') {
            return;
        }

        // Skip if id already has AUTO_INCREMENT (idempotent for re-runs)
        $hasAutoIncrement = DB::selectOne(
            "SELECT COLUMN_NAME FROM information_schema.COLUMNS 
             WHERE TABLE_SCHEMA = ? AND TABLE_NAME = 'logs' AND COLUMN_NAME = 'id' AND EXTRA LIKE '%auto_increment%'",
            [DB::getDatabaseName()]
        );
        if ($hasAutoIncrement) {
            return;
        }

        // Drop existing primary key so we can define id as the only auto column and key
        try {
            DB::statement('ALTER TABLE `logs` DROP PRIMARY KEY');
        } catch (\Throwable $e) {
            // No primary key or different error; continue
        }

        // Define id as primary key with AUTO_INCREMENT (must be a key)
        DB::statement('ALTER TABLE `logs` MODIFY `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No safe reverse without knowing previous state
    }
};
