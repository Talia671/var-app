<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkup_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkup_document_id');
            $table->unsignedBigInteger('checkup_item_id');

            $table->enum('hasil',['Baik','Rusak','Tidak Ada']);
            $table->text('tindakan_perbaikan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkup_results');
    }
};