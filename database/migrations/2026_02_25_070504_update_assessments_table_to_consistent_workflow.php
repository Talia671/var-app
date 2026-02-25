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
        Schema::table('assessments', function (Blueprint $table) {
            $table->enum('workflow_status', ['draft', 'submitted', 'approved', 'rejected'])
                ->default('draft')
                ->after('tanggal_uji');
            $table->boolean('is_locked')->default(false)->after('workflow_status');
            
            // Simpan status lama ke workflow_status jika perlu (opsional untuk seeder, tapi bagus untuk konsistensi)
            // Namun karena ini seeder-based, kita bisa biarkan default.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn(['workflow_status', 'is_locked']);
        });
    }
};
