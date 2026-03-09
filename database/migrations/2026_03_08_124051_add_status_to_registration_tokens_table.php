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
            $table->enum('status', ['active', 'used', 'revoked'])->default('active')->after('token');
            // We can drop is_used column if we want, but let's keep it for now and ignore it
            // Or better, drop it since we are refactoring.
            $table->dropColumn('is_used');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registration_tokens', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->boolean('is_used')->default(false);
        });
    }
};
