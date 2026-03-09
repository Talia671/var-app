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
        Schema::table('checkup_items', function (Blueprint $table) {
            if (!Schema::hasColumn('checkup_items', 'item_number')) {
                $table->integer('item_number')->nullable()->after('id');
            }
            
            // Add index for ordering
            $table->index('item_number');

            if (!Schema::hasColumn('checkup_items', 'item_name')) {
                $table->string('item_name')->nullable()->after('item_number');
            }

            if (!Schema::hasColumn('checkup_items', 'standard')) {
                $table->text('standard')->nullable()->after('item_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkup_items', function (Blueprint $table) {
            if (Schema::hasColumn('checkup_items', 'standard')) {
                $table->dropColumn('standard');
            }
            if (Schema::hasColumn('checkup_items', 'item_name')) {
                $table->dropColumn('item_name');
            }
            if (Schema::hasColumn('checkup_items', 'item_number')) {
                $table->dropIndex(['item_number']);
                $table->dropColumn('item_number');
            }
        });
    }
};
