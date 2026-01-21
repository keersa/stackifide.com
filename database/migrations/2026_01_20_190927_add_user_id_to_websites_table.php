<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $connection = DB::getDriverName();
        
        // If column exists, drop foreign key first (in case migration partially ran)
        if (Schema::hasColumn('websites', 'user_id')) {
            // Try to drop foreign key if it exists
            try {
                if ($connection === 'mysql') {
                    $database = DB::getDatabaseName();
                    $foreignKeys = DB::select("
                        SELECT CONSTRAINT_NAME 
                        FROM information_schema.KEY_COLUMN_USAGE 
                        WHERE TABLE_SCHEMA = ? 
                        AND TABLE_NAME = 'websites' 
                        AND COLUMN_NAME = 'user_id' 
                        AND REFERENCED_TABLE_NAME IS NOT NULL
                    ", [$database]);
                    
                    if (!empty($foreignKeys)) {
                        $constraintName = $foreignKeys[0]->CONSTRAINT_NAME;
                        DB::statement("ALTER TABLE websites DROP FOREIGN KEY {$constraintName}");
                    }
                }
            } catch (\Exception $e) {
                // Foreign key might not exist, continue
            }
            
            // Drop the column to start fresh
            Schema::table('websites', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
        }

        // Add the column as nullable first
        Schema::table('websites', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id');
            $table->index('user_id');
        });

        // Set a default user_id for existing websites (use first admin or super_admin)
        $defaultUser = DB::table('users')
            ->whereIn('role', ['admin', 'super_admin'])
            ->orderBy('id')
            ->first();

        if (!$defaultUser) {
            throw new \Exception('No admin or super_admin user found. Please create one before running this migration.');
        }

        // Update all NULL user_id values
        DB::table('websites')
            ->whereNull('user_id')
            ->update(['user_id' => $defaultUser->id]);

        // Now make it NOT NULL and add the foreign key constraint
        if ($connection === 'mysql') {
            DB::statement('ALTER TABLE websites MODIFY COLUMN user_id BIGINT UNSIGNED NOT NULL');
        } else {
            // For SQLite, we need to recreate the table or use a different approach
            // SQLite doesn't support MODIFY COLUMN, so we'll keep it nullable for SQLite
            // and handle the constraint at the application level
        }
        
        // Add foreign key constraint
        Schema::table('websites', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
