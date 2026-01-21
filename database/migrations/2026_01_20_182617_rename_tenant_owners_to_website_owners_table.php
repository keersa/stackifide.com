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
        // Rename tenant_owners table to website_owners
        Schema::rename('tenant_owners', 'website_owners');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('website_owners', 'tenant_owners');
    }
};
