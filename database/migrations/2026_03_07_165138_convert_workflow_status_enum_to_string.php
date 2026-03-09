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
        $tables = ['simper_documents', 'ujsimp_tests', 'checkup_documents', 'ranmor_documents'];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->string('workflow_status')->default('submitted')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['simper_documents', 'ujsimp_tests', 'checkup_documents', 'ranmor_documents'];

        foreach ($tables as $table) {
            DB::statement("
                ALTER TABLE $table 
                MODIFY workflow_status ENUM(
                    'draft',
                    'submitted',
                    'verified',
                    'approved',
                    'rejected'
                )
            ");
        }
    }
};
