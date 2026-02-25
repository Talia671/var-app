<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('assessments', function (Blueprint $table) {
        $table->string('zona')->after('petugas_id');
        $table->string('jenis_simper')->after('jenis_sim');
        $table->string('penguji_nama')->nullable()->after('tanggal_uji');
        $table->text('catatan_umum')->nullable()->after('penguji_nama');
    });
}   

    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn(['zona', 'jenis_simper', 'penguji_nama', 'catatan_umum']);
        });
    }
};
