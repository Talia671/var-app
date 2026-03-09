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
        // 1. Simper Items (was previously assessment_items, now simper_items)
        if (Schema::hasTable('simper_items')) {
            Schema::table('simper_items', function (Blueprint $table) {
                if (!Schema::hasColumn('simper_items', 'name')) {
                    $table->string('name')->nullable()->after('id');
                }
                if (!Schema::hasColumn('simper_items', 'category')) {
                    $table->string('category')->nullable()->after('name');
                }
                if (!Schema::hasColumn('simper_items', 'field_type')) {
                    $table->string('field_type')->default('text')->after('category');
                }
                if (!Schema::hasColumn('simper_items', 'options')) {
                    $table->json('options')->nullable()->after('field_type');
                }
                if (!Schema::hasColumn('simper_items', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('options');
                }
                if (!Schema::hasColumn('simper_items', 'urutan')) {
                    $table->integer('urutan')->default(0)->after('is_active');
                }
            });
        }

        // 2. UJSIMP Items (ujsimp_master_items)
        if (Schema::hasTable('ujsimp_master_items')) {
            Schema::table('ujsimp_master_items', function (Blueprint $table) {
                if (!Schema::hasColumn('ujsimp_master_items', 'field_type')) {
                    $table->string('field_type')->default('checklist')->after('uraian');
                }
                if (!Schema::hasColumn('ujsimp_master_items', 'options')) {
                    $table->json('options')->nullable()->after('field_type');
                }
                if (!Schema::hasColumn('ujsimp_master_items', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('options');
                }
            });
        }

        // 3. Checkup Items (checkup_items)
        if (Schema::hasTable('checkup_items')) {
            Schema::table('checkup_items', function (Blueprint $table) {
                if (!Schema::hasColumn('checkup_items', 'category')) {
                    $table->string('category')->nullable()->after('urutan');
                }
                if (!Schema::hasColumn('checkup_items', 'field_type')) {
                    $table->string('field_type')->default('checklist')->after('category');
                }
                if (!Schema::hasColumn('checkup_items', 'options')) {
                    $table->json('options')->nullable()->after('field_type');
                }
                if (!Schema::hasColumn('checkup_items', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('options');
                }
            });
        }

        // 4. Ranmor Fields (ranmor_fields) - New Table
        if (!Schema::hasTable('ranmor_fields')) {
            Schema::create('ranmor_fields', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('category')->nullable();
                $table->string('field_type')->default('text');
                $table->json('options')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('urutan')->default(0);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 4. Ranmor Fields
        Schema::dropIfExists('ranmor_fields');

        // 3. Checkup Items
        if (Schema::hasTable('checkup_items')) {
            Schema::table('checkup_items', function (Blueprint $table) {
                $table->dropColumn(['category', 'field_type', 'options', 'is_active']);
            });
        }

        // 2. UJSIMP Items
        if (Schema::hasTable('ujsimp_master_items')) {
            Schema::table('ujsimp_master_items', function (Blueprint $table) {
                $table->dropColumn(['field_type', 'options', 'is_active']);
            });
        }

        // 1. Simper Items
        if (Schema::hasTable('simper_items')) {
            Schema::table('simper_items', function (Blueprint $table) {
                $table->dropColumn(['name', 'category', 'field_type', 'options', 'is_active', 'urutan']);
            });
        }
    }
};
