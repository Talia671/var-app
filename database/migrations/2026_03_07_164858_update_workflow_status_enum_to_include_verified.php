<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
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
                ) NOT NULL DEFAULT 'draft'
            ");
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
                    'approved',
                    'rejected'
                ) NOT NULL DEFAULT 'draft'
            ");
        }
    }
};
