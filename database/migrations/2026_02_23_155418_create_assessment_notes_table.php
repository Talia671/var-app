<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('assessment_notes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
        $table->integer('no_urut');
        $table->text('uraian');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('assessment_notes');
    }
};
