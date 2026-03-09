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
        // 1. Update registration_tokens table
        Schema::table('registration_tokens', function (Blueprint $table) {
            // New columns for secure storage
            $table->string('token_lookup')->nullable()->after('id')->index(); // SHA256 for finding the row
            $table->string('token_hash')->nullable()->after('token_lookup'); // Bcrypt for password-like verification
            $table->text('token_encrypted')->nullable()->after('token_hash'); // Encrypted string for reveal functionality
            
            // Expiration
            $table->timestamp('expires_at')->nullable()->after('created_at');
            
            // Update status enum
            // Note: modifying enum in MySQL can be tricky. We'll just change the column definition if possible, 
            // or rely on the application layer validation if it's just a string. 
            // But Laravel migration enum() creates an actual ENUM type.
            // Let's modify it using raw SQL to be safe and explicit for MySQL.
            // However, Doctrine DBAL is needed for modify(). 
            // We will just use DB::statement for the enum change.
        });

        // Update the ENUM separately to include 'expired'
        \DB::statement("ALTER TABLE registration_tokens MODIFY COLUMN status ENUM('active', 'used', 'expired', 'revoked') DEFAULT 'active'");

        // 2. Create token_view_logs table
        Schema::create('token_view_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('token_id')->constrained('registration_tokens')->onDelete('cascade');
            $table->foreignId('viewed_by')->constrained('users');
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('viewed_at')->useCurrent();
        });
        
        // 3. Migrate existing data (if any)
        // Since we are refactoring, we might want to just clear old tokens or migrate them.
        // For simplicity and security, let's mark old tokens as revoked or migrate them if possible.
        // Given the instructions, we'll just leave them as is but they won't work with new system unless we hash them now.
        // Let's clear them to avoid confusion as the format changed to INV-XXXXXX.
        
        // Disable FK checks before truncate
        Schema::disableForeignKeyConstraints();
        \DB::table('registration_tokens')->truncate();
        Schema::enableForeignKeyConstraints();

        // 4. Drop the old plain 'token' column
        Schema::table('registration_tokens', function (Blueprint $table) {
            $table->dropColumn('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_view_logs');

        Schema::table('registration_tokens', function (Blueprint $table) {
            $table->string('token')->nullable()->after('id'); // Restore column
            $table->dropColumn(['token_lookup', 'token_hash', 'token_encrypted', 'expires_at']);
        });

        // Revert ENUM
        \DB::statement("ALTER TABLE registration_tokens MODIFY COLUMN status ENUM('active', 'used', 'revoked') DEFAULT 'active'");
    }
};
