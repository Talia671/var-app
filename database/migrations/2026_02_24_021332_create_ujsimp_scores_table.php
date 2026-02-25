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
        Schema::create('ujsimp_scores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ujsimp_test_id')
                ->constrained('ujsimp_tests')
                ->cascadeOnDelete();

            $table->foreignId('ujsimp_item_id')
                ->constrained('ujsimp_items')
                ->cascadeOnDelete();

            $table->enum('nilai_huruf', ['B','S','K'])->nullable();
            $table->integer('nilai_angka')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujsimp_scores');
    }
};
