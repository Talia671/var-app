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
        Schema::table('checkup_items', function (Blueprint $table) {
            // STEP 2 — MIGRATE OLD DATA
            if (Schema::hasColumn('checkup_items', 'urutan')) {
                DB::statement("
                    UPDATE checkup_items 
                    SET item_number = urutan 
                    WHERE item_number IS NULL
                ");
            }

            if (Schema::hasColumn('checkup_items', 'uraian')) {
                DB::statement("
                    UPDATE checkup_items 
                    SET item_name = uraian 
                    WHERE item_name IS NULL
                ");
            }
        });

        Schema::table('checkup_items', function (Blueprint $table) {
             // STEP 3 — DROP LEGACY COLUMNS
             if (Schema::hasColumn('checkup_items', 'urutan')) {
                 $table->dropColumn('urutan');
             }
             
             if (Schema::hasColumn('checkup_items', 'uraian')) {
                 $table->dropColumn('uraian');
             }

             // Drop other columns not needed for the strict new structure (as implied by "Only ADD missing structure" in previous turn but here user says "Normalize... without breaking existing data" but also "The table checkup_items should now have the clean structure: id, item_number, item_name, standard, created_at, updated_at")
             // However, there are columns like 'category', 'field_type', 'options', 'is_active' added in 2026_03_05_144900_add_master_data_config_columns.php
             // The user instruction says: "The table checkup_items should now have the clean structure: id, item_number, item_name, standard, created_at, updated_at"
             // This implies we should drop other columns too? 
             // "Do NOT remove existing tables. Do NOT delete existing columns" was in the previous prompt.
             // In THIS prompt: "Normalize the table so the system uses only: item_number, item_name, standard... without breaking existing data."
             // And "Drop Legacy Columns... urutan, uraian".
             // It DOES NOT explicitly say to drop 'category', 'field_type', etc.
             // BUT, "EXPECTED RESULT... The table checkup_items should now have the clean structure: id, item_number, item_name, standard, created_at, updated_at" lists ONLY those columns.
             // Given "without breaking existing data", dropping 'is_active' or 'options' might break logic if used elsewhere.
             // But the user specifically listed the expected structure.
             // Let's stick to dropping `urutan` and `uraian` as explicitly requested in STEP 3.
             // I will NOT drop category, field_type, options, is_active unless explicitly asked, to avoid "breaking existing logic" rule which might depend on them (e.g. dynamic forms).
             // Wait, looking at the previous file `CheckupItem.php`, it uses `category`, `field_type`.
             // If I drop them, the app might break.
             // The user example for Step 3 only shows dropping `urutan` and `uraian`.
             // So I will only drop `urutan` and `uraian`.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkup_items', function (Blueprint $table) {
            if (!Schema::hasColumn('checkup_items', 'urutan')) {
                $table->integer('urutan')->nullable();
            }
            if (!Schema::hasColumn('checkup_items', 'uraian')) {
                $table->string('uraian')->nullable();
            }
        });

        // Restore data
        DB::statement("UPDATE checkup_items SET urutan = item_number");
        DB::statement("UPDATE checkup_items SET uraian = item_name");
    }
};
