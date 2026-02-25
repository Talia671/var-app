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
        Schema::table('simper_notes', function (Blueprint $table) {
            // Drop old FK
            $table->dropForeign('assessment_notes_assessment_id_foreign');
            
            // Rename column
            $table->renameColumn('assessment_id', 'simper_document_id');
            
            // Add new FK
            $table->foreign('simper_document_id')->references('id')->on('simper_documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('simper_notes', function (Blueprint $table) {
            $table->dropForeign(['simper_document_id']);
            $table->renameColumn('simper_document_id', 'assessment_id');
            // Re-add old FK name not strictly required but good for rollback consistency
            $table->foreign('assessment_id', 'assessment_notes_assessment_id_foreign')->references('id')->on('simper_documents')->onDelete('cascade');
        });
    }
};