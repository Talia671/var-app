<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CoreSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\TokenSeeder;
use Database\Seeders\ExamSeeder;
use Database\Seeders\ExamScenarioSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CoreSeeder::class,
            UserSeeder::class,
            TokenSeeder::class,
            ExamSeeder::class,
            ExamScenarioSeeder::class,
            CheckupItemSeeder::class,
        ]);
    }
}
