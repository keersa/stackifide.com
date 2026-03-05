<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('facebook_url', 500)->nullable()->after('current_url');
            $table->string('instagram_url', 500)->nullable()->after('facebook_url');
            $table->string('yelp_url', 500)->nullable()->after('instagram_url');
            $table->string('youtube_url', 500)->nullable()->after('yelp_url');
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['facebook_url', 'instagram_url', 'yelp_url', 'youtube_url']);
        });
    }
};
