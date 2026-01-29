<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE websites MODIFY COLUMN plan VARCHAR(255) NOT NULL DEFAULT 'none'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE websites MODIFY COLUMN plan VARCHAR(255) NOT NULL DEFAULT 'basic'");
    }
};
