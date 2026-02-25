<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ujsimp_tests', function (Blueprint $table) {
            $table->enum('workflow_status', [
                'draft',
                'submitted',
                'approved',
                'rejected'
            ])->default('draft')->change();
        });
    }

    public function down(): void
    {
        //
    }
};