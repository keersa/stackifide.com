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
            if (Schema::hasColumn('websites', 'show_logo_in_hero')) {
                $table->dropColumn('show_logo_in_hero');
            }

            if (Schema::hasColumn('websites', 'hero_title')) {
                $table->dropColumn('hero_title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            if (!Schema::hasColumn('websites', 'show_logo_in_hero')) {
                $table->boolean('show_logo_in_hero')->default(true)->after('tagline');
            }

            if (!Schema::hasColumn('websites', 'hero_title')) {
                $table->string('hero_title', 255)->nullable()->after('show_logo_in_hero');
            }
        });
    }
};
