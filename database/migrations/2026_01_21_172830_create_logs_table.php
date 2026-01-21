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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action'); // e.g., 'login', 'website.updated', 'page.updated', 'menu_item.updated'
            $table->string('model_type')->nullable(); // e.g., 'App\Models\Website', 'App\Models\Page', 'App\Models\MenuItem'
            $table->unsignedBigInteger('model_id')->nullable(); // ID of the model that was updated
            $table->json('changes')->nullable(); // Store what changed (before/after)
            $table->text('description')->nullable(); // Human-readable description
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('user_id');
            $table->index('action');
            $table->index(['model_type', 'model_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
