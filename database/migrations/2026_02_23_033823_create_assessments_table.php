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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('template_id')->nullable();
            $table->foreignId('petugas_id');

            $table->string('nama');
            $table->string('npk');
            $table->string('perusahaan');
            $table->string('jenis_kendaraan');
            $table->string('nomor_sim');
            $table->string('jenis_sim');
            $table->date('tanggal_uji')->nullable();

            $table->string('status')->default('pending');

            $table->foreignId('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->foreignId('rejected_by')->nullable();
            $table->text('rejected_reason')->nullable();
            $table->timestamp('rejected_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('template_id')->nullable();
            $table->foreignId('petugas_id');

            $table->string('nama');
            $table->string('npk');
            $table->string('perusahaan');
            $table->string('jenis_kendaraan');
            $table->string('nomor_sim');
            $table->string('jenis_sim');
            $table->date('tanggal_uji')->nullable();

            $table->string('status')->default('pending');

            $table->foreignId('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->foreignId('rejected_by')->nullable();
            $table->text('rejected_reason')->nullable();
            $table->timestamp('rejected_at')->nullable();

            $table->timestamps();
        });
    }
};
