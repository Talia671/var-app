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
        Schema::create('ujsimp_tests', function (Blueprint $table) {

            $table->id();

            $table->string('nama');
            $table->string('npk');
            $table->string('perusahaan');
            $table->string('jenis_kendaraan');
            $table->date('tanggal_ujian');
            $table->string('nomor_sim');
            $table->string('jenis_sim');
            $table->string('jenis_simper');

            // HASIL
            $table->enum('status', ['lulus', 'belum_lulus'])->default('belum_lulus');
            $table->decimal('nilai_total', 8, 2)->nullable();
            $table->decimal('nilai_rata_rata', 8, 2)->nullable();
            $table->text('catatan_penguji')->nullable();

            // WORKFLOW
            $table->enum('workflow_status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->boolean('is_locked')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujsimp_tests');
    }
};
