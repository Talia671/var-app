<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('checkup_results', function (Blueprint $table) {
            DB::statement("
                ALTER TABLE checkup_results 
                MODIFY hasil ENUM(
                    'baik', 
                    'tidak_baik', 
                    'tidak_ada'
                ) NOT NULL
            ");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkup_results', function (Blueprint $table) {
            // Revert to assumed original state or safe state
            DB::statement("
                ALTER TABLE checkup_results 
                MODIFY hasil ENUM(
                    'Baik', 
                    'Rusak', 
                    'Tidak Ada'
                ) NOT NULL
            ");
        });
    }
};
