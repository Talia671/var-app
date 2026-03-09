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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Note: ujsimp_items table already exists from previous migration (2026_02_24_021245_create_ujsimp_items_table.php)
        // However, the user request asks to create it with specific structure: id, category, urutan, uraian, timestamps
        // Let's check if we need to modify or create new one.
        // Assuming we should create if not exists or modify.
        // But rule 1 says "Do NOT modify existing migrations".
        // Let's check if the existing table has the required columns.

        if (! Schema::hasTable('ujsimp_master_items')) {
            Schema::create('ujsimp_master_items', function (Blueprint $table) {
                $table->id();
                $table->string('category');
                $table->integer('urutan');
                $table->string('uraian');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujsimp_master_items');
        Schema::dropIfExists('zones');
        Schema::dropIfExists('companies');
    }
};
