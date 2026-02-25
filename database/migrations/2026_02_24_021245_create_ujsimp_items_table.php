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
        Schema::create('ujsimp_items', function (Blueprint $table) {
            $table->id();

            $table->enum('kategori', ['teknik','rambu']);
            $table->integer('urutan');
            $table->text('uraian');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujsimp_items');
    }
};
