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
        Schema::table('ujsimp_tests', function (Blueprint $table) {
            $table->unsignedBigInteger('petugas_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ujsimp_tests', function (Blueprint $table) {
            $table->dropColumn('petugas_id');
        });
    }
};
