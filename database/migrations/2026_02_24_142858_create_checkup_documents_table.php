<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkup_documents', function (Blueprint $table) {
            $table->id();

            $table->string('nama_pengemudi');
            $table->string('npk');
            $table->string('nomor_sim')->nullable();
            $table->string('nomor_simper')->nullable();
            $table->string('masa_berlaku')->nullable();

            $table->string('no_pol');
            $table->string('no_lambung')->nullable();
            $table->string('perusahaan');
            $table->string('jenis_kendaraan');
            $table->date('tanggal_pemeriksaan');

            $table->enum('rekomendasi', ['layak','tidak_layak'])->nullable();
            $table->enum('zona', ['zona1','zona2'])->nullable();

            $table->enum('workflow_status', [
                'draft',
                'submitted',
                'approved',
                'rejected'
            ])->default('draft');

            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->boolean('is_locked')->default(false);

            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkup_documents');
    }
};