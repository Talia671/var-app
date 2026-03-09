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
        Schema::table('registration_tokens', function (Blueprint $table) {
            // Enforce NOT NULL constraints
            $table->string('token_lookup')->nullable(false)->change();
            $table->string('token_hash')->nullable(false)->change();
            $table->text('token_encrypted')->nullable(false)->change();

            // Add UNIQUE constraint to token_lookup
            $table->unique('token_lookup');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registration_tokens', function (Blueprint $table) {
            // Drop UNIQUE constraint
            $table->dropUnique(['token_lookup']);

            // Revert to nullable
            $table->string('token_lookup')->nullable()->change();
            $table->string('token_hash')->nullable()->change();
            $table->text('token_encrypted')->nullable()->change();
        });
    }
};
