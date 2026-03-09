<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class ResetDataButKeepUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Disable Foreign Key Checks
        Schema::disableForeignKeyConstraints();

        // 2. Get all tables
        $tables = DB::select('SHOW TABLES');

        // 3. Truncate all tables except 'users', 'migrations', and system tables
        foreach ($tables as $table) {
            $tableArray = (array) $table;
            $tableName = reset($tableArray);

            // Skip users table (we will handle it separately)
            if ($tableName === 'users') {
                continue;
            }

            // Skip migrations table
            if ($tableName === 'migrations') {
                continue;
            }

            // Skip other system tables if necessary (e.g. telescope, jobs, etc. if you want to keep them)
            // For a full reset, we usually truncate them too.
            // But let's keep jobs/failed_jobs/cache just in case, though usually reset clears them.
            // User asked to "reset all data", so likely these should be cleared too.
            
            $this->command->info("Truncating table: {$tableName}");
            DB::table($tableName)->truncate();
        }

        // 4. Handle Users Table: Delete users that are NOT in the original seeder list
        // List of emails from UserSeeder
        $seededEmails = [
            'superadmin@example.com',
            'admin1@example.com',
            'admin2@example.com',
            'checker1@example.com',
            'checker2@example.com',
            'avp1@example.com',
            'avp2@example.com',
            'viewer1@example.com',
            'viewer2@example.com',
            'viewer3@example.com',
        ];

        $this->command->info("Cleaning up users table (keeping seeded accounts)...");
        User::whereNotIn('email', $seededEmails)->delete();

        // 5. Re-run other seeders (CoreSeeder only)
        // We do NOT run UserSeeder because the user said "except account seeder"
        // We do NOT run TokenSeeder, ExamSeeder, ExamScenarioSeeder because user wants to check manually
        $this->command->info("Re-running CoreSeeder (Master Data)...");
        
        $this->call([
            CoreSeeder::class,
        ]);

        // 6. Enable Foreign Key Checks
        Schema::enableForeignKeyConstraints();

        $this->command->info("Database reset complete (Users preserved).");
    }
}
