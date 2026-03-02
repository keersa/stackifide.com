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
        Schema::table('prospective_contacts', function (Blueprint $table) {
            if (! Schema::hasColumn('prospective_contacts', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('lead_id')
                    ->constrained()
                    ->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prospective_contacts', function (Blueprint $table) {
            if (Schema::hasColumn('prospective_contacts', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};

