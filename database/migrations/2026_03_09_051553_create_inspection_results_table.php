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
        Schema::create('inspection_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id')->index(); // Polymorphic-ish ID (links to checkup_documents.id, ujsimp_tests.id, etc)
            $table->foreignId('inspection_item_id')->constrained('inspection_items')->onDelete('cascade');
            $table->string('nilai_huruf')->nullable();
            $table->integer('nilai_angka')->nullable();
            $table->string('status')->nullable(); // baik, rusak, etc
            $table->text('tindakan')->nullable();
            $table->timestamps();
            
            // Composite index for efficient querying
            $table->index(['document_id', 'inspection_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_results');
    }
};
