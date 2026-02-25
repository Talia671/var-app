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
        Schema::table('ranmor_documents', function (Blueprint $table) {
            $table->string('npk')->nullable()->after('pengemudi');
            $table->string('jenis_kendaraan')->nullable()->after('merk_kendaraan');
            $table->string('no_rangka')->nullable()->after('jenis_kendaraan');
            $table->string('no_mesin')->nullable()->after('no_rangka');
            $table->string('status_kepemilikan')->nullable()->after('no_mesin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ranmor_documents', function (Blueprint $table) {
            $table->dropColumn(['npk', 'jenis_kendaraan', 'no_rangka', 'no_mesin', 'status_kepemilikan']);
        });
    }
};
