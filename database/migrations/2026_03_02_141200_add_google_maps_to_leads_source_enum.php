<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Add 'google_maps' to the leads.source enum.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE leads MODIFY COLUMN source ENUM('website', 'referral', 'social_media', 'cold_call', 'email', 'other', 'google_maps') NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            // Set any google_maps to 'other' before removing the enum value
            DB::table('leads')->where('source', 'google_maps')->update(['source' => 'other']);
            DB::statement("ALTER TABLE leads MODIFY COLUMN source ENUM('website', 'referral', 'social_media', 'cold_call', 'email', 'other') NULL");
        }
    }
};
