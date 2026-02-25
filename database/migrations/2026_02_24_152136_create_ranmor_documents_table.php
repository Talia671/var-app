<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ranmor_documents', function (Blueprint $table) {
            $table->id();

            // Header Data
            $table->enum('zona', ['zona1', 'zona2']);
            $table->string('no_pol');
            $table->string('no_lambung');
            $table->string('tahun_pembuatan')->nullable();
            $table->string('warna')->nullable();
            $table->string('perusahaan')->nullable();
            $table->string('merk_kendaraan')->nullable();
            $table->string('pengemudi')->nullable();
            $table->string('nomor_sim')->nullable();
            $table->string('nomor_simper')->nullable();
            $table->string('masa_berlaku')->nullable();
            $table->date('tanggal_periksa');

            // Workflow
            $table->enum('workflow_status', [
                'draft',
                'submitted',
                'approved',
                'rejected'
            ])->default('draft');

            $table->boolean('is_locked')->default(false);

            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->unsignedBigInteger('created_by');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ranmor_documents');
    }
};