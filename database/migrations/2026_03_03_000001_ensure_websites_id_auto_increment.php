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

        // MySQL requires the AUTO_INCREMENT column to be the first column of a key (usually PRIMARY KEY).
        // If the server's table has id without a key, we must add PRIMARY KEY (id) first.
        try {
            DB::statement('ALTER TABLE websites DROP PRIMARY KEY');
        } catch (\Throwable $e) {
            // No primary key or already dropped; ignore
        }

        DB::statement('ALTER TABLE websites ADD PRIMARY KEY (id)');
        DB::statement('ALTER TABLE websites MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op to avoid breaking inserts
    }
};
