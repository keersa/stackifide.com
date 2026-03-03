<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add 'new' to the websites.status ENUM so admin-created sites can use it.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }
        DB::statement("ALTER TABLE websites MODIFY COLUMN status ENUM('active', 'suspended', 'pending', 'trial', 'new') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Before dropping 'new', any rows with status 'new' would need to be updated
        DB::table('websites')->where('status', 'new')->update(['status' => 'pending']);
        DB::statement("ALTER TABLE websites MODIFY COLUMN status ENUM('active', 'suspended', 'pending', 'trial') NOT NULL DEFAULT 'pending'");
    }
};
