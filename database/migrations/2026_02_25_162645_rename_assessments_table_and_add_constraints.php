<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Rename Tables
        if (Schema::hasTable('assessment_templates')) {
            Schema::rename('assessment_templates', 'simper_templates');
        }
        if (Schema::hasTable('assessment_items')) {
            Schema::rename('assessment_items', 'simper_items');
        }
        if (Schema::hasTable('assessments')) {
            Schema::rename('assessments', 'simper_documents');
        }
        if (Schema::hasTable('assessment_results')) {
            Schema::rename('assessment_results', 'simper_results');
        }
        if (Schema::hasTable('assessment_notes')) {
            Schema::rename('assessment_notes', 'simper_notes');
        }

        // Insert Dummy Template to satisfy FK constraint if needed
        if (DB::table('simper_templates')->where('id', 1)->doesntExist()) {
            DB::table('simper_templates')->insert([
                'id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Add Constraints to simper_documents (assessments)
        /*
        Schema::table('simper_documents', function (Blueprint $table) {
            $table->foreign('petugas_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('template_id')->references('id')->on('simper_templates')->onDelete('set null');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
        });
        */

        // 3. Update simper_notes (assessment_notes)
        if (Schema::hasColumn('simper_notes', 'assessment_id')) {
            /*
            Schema::table('simper_notes', function (Blueprint $table) {
               $table->dropForeign('assessment_notes_assessment_id_foreign');
               $table->renameColumn('assessment_id', 'simper_document_id');
               $table->foreign('simper_document_id')->references('id')->on('simper_documents')->onDelete('cascade');
            });
            */
        }
    }

    public function down(): void
    {
        // Revert changes
        Schema::table('simper_notes', function (Blueprint $table) {
            $table->dropForeign(['simper_document_id']);
            $table->renameColumn('simper_document_id', 'assessment_id');
            $table->foreign('assessment_id')->references('id')->on('simper_documents')->onDelete('cascade');
        });

        Schema::table('simper_documents', function (Blueprint $table) {
            $table->dropForeign(['petugas_id']);
            $table->dropForeign(['template_id']);
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['rejected_by']);
        });

        Schema::rename('simper_notes', 'assessment_notes');
        Schema::rename('simper_results', 'assessment_results');
        Schema::rename('simper_documents', 'assessments');
        Schema::rename('simper_items', 'assessment_items');
        Schema::rename('simper_templates', 'assessment_templates');
    }
};
