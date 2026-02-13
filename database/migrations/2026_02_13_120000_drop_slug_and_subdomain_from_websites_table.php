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
        Schema::table('websites', function (Blueprint $table) {
            if (Schema::hasColumn('websites', 'slug')) {
                $table->dropColumn('slug');
            }

            if (Schema::hasColumn('websites', 'subdomain')) {
                $table->dropColumn('subdomain');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            if (!Schema::hasColumn('websites', 'slug')) {
                $table->string('slug')->nullable();
            }

            if (!Schema::hasColumn('websites', 'subdomain')) {
                $table->string('subdomain')->nullable();
            }
        });
    }
};
