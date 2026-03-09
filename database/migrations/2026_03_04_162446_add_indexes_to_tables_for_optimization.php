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
            $table->index('workflow_status');
            // Check if column exists before adding index to avoid errors
            if (Schema::hasColumn('ujsimp_tests', 'retry_available_at')) {
                $table->index('retry_available_at');
            }
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('created_at');
        });

        Schema::table('registration_tokens', function (Blueprint $table) {
            $table->index('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ujsimp_tests', function (Blueprint $table) {
            $table->dropIndex(['workflow_status']);
            if (Schema::hasColumn('ujsimp_tests', 'retry_available_at')) {
                $table->dropIndex(['retry_available_at']);
            }
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('registration_tokens', function (Blueprint $table) {
            $table->dropIndex(['token']);
        });
    }
};
