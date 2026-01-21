<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Get the actual foreign key constraint name for a table and column.
     */
    private function getForeignKeyName(string $table, string $column): ?string
    {
        $database = DB::getDatabaseName();
        $result = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = ? 
            AND COLUMN_NAME = ? 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ", [$database, $table, $column]);
        
        return $result[0]->CONSTRAINT_NAME ?? null;
    }

    /**
     * Safely drop a foreign key constraint.
     */
    private function dropForeignKeyIfExists(string $table, string $column): void
    {
        $constraintName = $this->getForeignKeyName($table, $column);
        if ($constraintName) {
            DB::statement("ALTER TABLE {$table} DROP FOREIGN KEY {$constraintName}");
        }
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Rename tenant_id to website_id in website_owners table
        $this->dropForeignKeyIfExists('website_owners', 'tenant_id');
        DB::statement('ALTER TABLE website_owners CHANGE tenant_id website_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE website_owners ADD CONSTRAINT website_owners_website_id_foreign FOREIGN KEY (website_id) REFERENCES websites(id) ON DELETE CASCADE');

        // Rename tenant_id to website_id in leads table
        $this->dropForeignKeyIfExists('leads', 'tenant_id');
        DB::statement('ALTER TABLE leads CHANGE tenant_id website_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE leads ADD CONSTRAINT leads_website_id_foreign FOREIGN KEY (website_id) REFERENCES websites(id) ON DELETE CASCADE');

        // Rename tenant_id to website_id in menu_items table
        $this->dropForeignKeyIfExists('menu_items', 'tenant_id');
        DB::statement('ALTER TABLE menu_items CHANGE tenant_id website_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE menu_items ADD CONSTRAINT menu_items_website_id_foreign FOREIGN KEY (website_id) REFERENCES websites(id) ON DELETE CASCADE');

        // Rename tenant_id to website_id in pages table
        $this->dropForeignKeyIfExists('pages', 'tenant_id');
        DB::statement('ALTER TABLE pages CHANGE tenant_id website_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE pages ADD CONSTRAINT pages_website_id_foreign FOREIGN KEY (website_id) REFERENCES websites(id) ON DELETE CASCADE');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert pages table
        $this->dropForeignKeyIfExists('pages', 'website_id');
        DB::statement('ALTER TABLE pages CHANGE website_id tenant_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE pages ADD CONSTRAINT pages_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE');

        // Revert menu_items table
        $this->dropForeignKeyIfExists('menu_items', 'website_id');
        DB::statement('ALTER TABLE menu_items CHANGE website_id tenant_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE menu_items ADD CONSTRAINT menu_items_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE');

        // Revert leads table
        $this->dropForeignKeyIfExists('leads', 'website_id');
        DB::statement('ALTER TABLE leads CHANGE website_id tenant_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE leads ADD CONSTRAINT leads_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE');

        // Revert website_owners table
        $this->dropForeignKeyIfExists('website_owners', 'website_id');
        DB::statement('ALTER TABLE website_owners CHANGE website_id tenant_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE website_owners ADD CONSTRAINT website_owners_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE');
    }
};
