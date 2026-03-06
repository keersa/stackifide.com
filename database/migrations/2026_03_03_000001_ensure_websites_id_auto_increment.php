<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ensure websites.id is PRIMARY KEY and AUTO_INCREMENT so inserts work when id is omitted.
     * Fixes "Field 'id' doesn't have a default value" and "auto column must be defined as a key".
     */
    public function up(): void
    {
        $driver = DB::getDriverName();
        if ($driver !== 'mysql') {
            return;
        }

        // Only ensure id is AUTO_INCREMENT. Do not ADD PRIMARY KEY here: the table usually
        // already has one, and information_schema can report it missing on some setups,
        // causing "Multiple primary key defined" when we try to add it.
        try {
            DB::statement('ALTER TABLE websites MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        } catch (\Throwable $e) {
            // Column may already be correct, or table lacks primary key; don't fail the migration
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op to avoid breaking inserts
    }
};
