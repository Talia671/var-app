<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1 Admin
        User::updateOrCreate(
            ['email' => 'admin@var.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 5 Petugas
        for ($i = 1; $i <= 5; $i++) {
            User::updateOrCreate(
                ['email' => "petugas{$i}@var.com"],
                [
                    'name' => "Petugas {$i}",
                    'password' => Hash::make('password'),
                    'role' => 'petugas',
                ]
            );
        }

        // 2 Viewers
        User::updateOrCreate(
            ['email' => 'budi@var.com'],
            [
                'name' => 'Budi',
                'password' => Hash::make('password'),
                'role' => 'viewer',
            ]
        );

        User::updateOrCreate(
            ['email' => 'andi@var.com'],
            [
                'name' => 'Andi',
                'password' => Hash::make('password'),
                'role' => 'viewer',
            ]
        );
    }
}