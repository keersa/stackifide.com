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
            $table->string('stripe_id')->nullable()->index();
            $table->string('stripe_subscription_id')->nullable()->index();
            $table->string('stripe_price_id')->nullable();
            $table->string('stripe_status')->nullable();
            $table->timestamp('stripe_trial_ends_at')->nullable();
            $table->timestamp('stripe_ends_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_id',
                'stripe_subscription_id',
                'stripe_price_id',
                'stripe_status',
                'stripe_trial_ends_at',
                'stripe_ends_at',
            ]);
        });
    }
};
