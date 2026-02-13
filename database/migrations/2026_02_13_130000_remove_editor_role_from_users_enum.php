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
        // Map removed role to least-privileged existing role before shrinking ENUM.
        DB::table('users')->where('role', 'editor')->update(['role' => 'customer']);

        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'customer', 'public') DEFAULT 'admin'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'admin', 'customer', 'editor', 'public') DEFAULT 'admin'");
    }
};
