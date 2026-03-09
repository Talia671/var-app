<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ranmor_findings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ranmor_document_id')
                ->constrained('ranmor_documents')
                ->cascadeOnDelete();

            $table->text('uraian')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ranmor_findings');
    }
};
