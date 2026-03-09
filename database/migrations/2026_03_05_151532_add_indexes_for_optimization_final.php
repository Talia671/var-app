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
        // 1. Users table indexes
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                // Check if index already exists to avoid errors (MySQL usually handles this but good practice)
                // Since we can't easily check for index existence with Schema facade in a generic way,
                // we'll wrap in try-catch or just attempt.
                // However, Schema::hasIndex is not standard.
                // We'll trust that this migration is new and unique.
                $table->index('role');
            }
        });

        // 2. Activity Logs table indexes (action is frequently queried in monitoring)
        Schema::table('activity_logs', function (Blueprint $table) {
            if (Schema::hasColumn('activity_logs', 'action')) {
                $table->index('action');
            }
            // created_at and user_id already indexed in previous migrations
        });

        // 3. Workflow status indexes for Exam tables
        // UJSIMP already indexed in previous optimization migration.
        
        // SIMPER
        Schema::table('simper_documents', function (Blueprint $table) {
            if (Schema::hasColumn('simper_documents', 'workflow_status')) {
                $table->index('workflow_status');
            }
        });

        // CHECKUP
        Schema::table('checkup_documents', function (Blueprint $table) {
            if (Schema::hasColumn('checkup_documents', 'workflow_status')) {
                $table->index('workflow_status');
            }
        });

        // RANMOR
        Schema::table('ranmor_documents', function (Blueprint $table) {
            if (Schema::hasColumn('ranmor_documents', 'workflow_status')) {
                $table->index('workflow_status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex(['action']);
        });

        Schema::table('simper_documents', function (Blueprint $table) {
            $table->dropIndex(['workflow_status']);
        });

        Schema::table('checkup_documents', function (Blueprint $table) {
            $table->dropIndex(['workflow_status']);
        });

        Schema::table('ranmor_documents', function (Blueprint $table) {
            $table->dropIndex(['workflow_status']);
        });
    }
};
