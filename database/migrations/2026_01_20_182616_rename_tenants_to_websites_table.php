<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Rename tenants table to websites
        Schema::rename('tenants', 'websites');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('websites', 'tenants');
    }
};
