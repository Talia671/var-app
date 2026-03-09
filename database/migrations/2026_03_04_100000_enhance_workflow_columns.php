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
        // 1. SIMPER (simper_documents)
        Schema::table('simper_documents', function (Blueprint $table) {
            if (! Schema::hasColumn('simper_documents', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable()->after('is_locked');
                $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            }
            if (! Schema::hasColumn('simper_documents', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
            if (! Schema::hasColumn('simper_documents', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('approved_at');
                $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            }
            if (! Schema::hasColumn('simper_documents', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
            if (! Schema::hasColumn('simper_documents', 'rejected_by')) {
                $table->unsignedBigInteger('rejected_by')->nullable()->after('verified_at');
                $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
            }
            if (! Schema::hasColumn('simper_documents', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('rejected_by');
            }
        });

        // 2. UJSIMP (ujsimp_tests)
        Schema::table('ujsimp_tests', function (Blueprint $table) {
            if (! Schema::hasColumn('ujsimp_tests', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('approved_at');
                $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            }
            if (! Schema::hasColumn('ujsimp_tests', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
            if (! Schema::hasColumn('ujsimp_tests', 'rejected_by')) {
                $table->unsignedBigInteger('rejected_by')->nullable()->after('verified_at');
                $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
            }
            if (! Schema::hasColumn('ujsimp_tests', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('rejected_by');
            }
        });

        // 3. CHECKUP (checkup_documents)
        Schema::table('checkup_documents', function (Blueprint $table) {
            if (! Schema::hasColumn('checkup_documents', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('approved_at');
                $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            }
            if (! Schema::hasColumn('checkup_documents', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
            if (! Schema::hasColumn('checkup_documents', 'rejected_by')) {
                $table->unsignedBigInteger('rejected_by')->nullable()->after('verified_at');
                $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
            }
            if (! Schema::hasColumn('checkup_documents', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('rejected_by');
            }
        });

        // 4. RANMOR (ranmor_documents)
        Schema::table('ranmor_documents', function (Blueprint $table) {
            if (! Schema::hasColumn('ranmor_documents', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('approved_at');
                $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            }
            if (! Schema::hasColumn('ranmor_documents', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
            if (! Schema::hasColumn('ranmor_documents', 'rejected_by')) {
                $table->unsignedBigInteger('rejected_by')->nullable()->after('verified_at');
                $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
            }
            if (! Schema::hasColumn('ranmor_documents', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('rejected_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Simple down that attempts to drop if exists
        $tables = ['ranmor_documents', 'checkup_documents', 'ujsimp_tests', 'simper_documents'];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (Schema::hasColumn($tableName, 'verified_by')) {
                        $table->dropForeign(['verified_by']);
                        $table->dropColumn(['verified_by', 'verified_at']);
                    }
                    if (Schema::hasColumn($tableName, 'rejected_by')) {
                        // Only drop if we are sure we added it?
                        // It's hard to know if it was pre-existing without tracking.
                        // But for this task, we assume we want to roll back our additions.
                        // However, since rejected_by ALREADY EXISTED in simper_documents, dropping it might be dangerous.
                        // SAFE APPROACH: Do not drop pre-existing columns.
                        // Since we don't know for sure, we will skip dropping rejected_by for simper_documents if we want to be super safe.
                        // But for the purpose of this task (dev environment), dropping is usually acceptable if we are iterating.
                        // Let's just try to drop the ones we likely added.

                        if ($tableName !== 'simper_documents') {
                            $table->dropForeign(['rejected_by']);
                            $table->dropColumn(['rejected_by', 'rejected_at']);
                        }
                    }
                });
            }
        }

        // Handle simper_documents approved_by specifically
        if (Schema::hasColumn('simper_documents', 'approved_by')) {
            // We only want to drop it if WE added it.
            // Since we can't know, we leave it or risk it.
            // Leaving it is safer.
        }
    }
};
