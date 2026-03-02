<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('prospective_contacts')) {
            Schema::create('prospective_contacts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('lead_id');
                $table->string('contact_type', 50); // email, phone_call, facebook, in_person_flyer, sms_message, other
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // Add foreign key only on MySQL/MariaDB when leads.id is compatible (InnoDB, same type)
        $driver = DB::getDriverName();
        if ($driver === 'mysql') {
            try {
                Schema::table('prospective_contacts', function (Blueprint $table) {
                    $table->foreign('lead_id')->references('id')->on('leads')->onDelete('cascade');
                });
            } catch (\Throwable $e) {
                // Ignore if FK fails or already exists (e.g. leads.id is INT, or MyISAM); app still works
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prospective_contacts');
    }
};
