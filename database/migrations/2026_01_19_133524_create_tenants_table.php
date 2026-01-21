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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Restaurant/business name
            $table->string('slug')->unique(); // URL-friendly identifier
            $table->string('domain')->unique()->nullable(); // Custom domain (e.g., restaurant.com)
            $table->string('subdomain')->unique()->nullable(); // Subdomain (e.g., restaurant.stackifide.com)
            $table->enum('status', ['active', 'suspended', 'pending', 'trial'])->default('pending');
            $table->string('plan')->default('basic'); // basic, pro, enterprise
            $table->json('settings')->nullable(); // Theme, colors, logo, etc.
            $table->json('contact_info')->nullable(); // Phone, email, address, etc.
            $table->text('description')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('subscription_ends_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('domain');
            $table->index('subdomain');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
