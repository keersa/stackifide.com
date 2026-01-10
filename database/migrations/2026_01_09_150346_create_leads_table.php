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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('restaurant_name');
            $table->string('contact_first_name')->nullable();
            $table->string('contact_last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('secondary_phone')->nullable();
            
            // Address Information (all optional)
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            
            // Business Information
            $table->string('current_url')->nullable();
            $table->string('business_type')->nullable(); // e.g., "Restaurant", "Cafe", "Bar", etc.
            $table->string('cuisine_type')->nullable(); // e.g., "Italian", "Mexican", etc.
            $table->integer('number_of_locations')->nullable();
            $table->string('current_ordering_system')->nullable();
            $table->text('special_requirements')->nullable();
            
            // Lead Status & Tracking
            $table->enum('status', ['new', 'contacted', 'qualified', 'proposal', 'negotiation', 'won', 'lost'])->default('new');
            $table->enum('source', ['website', 'referral', 'social_media', 'cold_call', 'email', 'other'])->nullable();
            $table->decimal('estimated_value', 10, 2)->nullable();
            $table->date('first_contact_date')->nullable();
            $table->date('last_contact_date')->nullable();
            $table->date('follow_up_date')->nullable();
            
            // Notes & Additional Information
            $table->text('notes')->nullable();
            $table->text('internal_notes')->nullable(); // Private notes not shown to client
            $table->json('tags')->nullable(); // For custom tagging
            
            // Assigned User
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
