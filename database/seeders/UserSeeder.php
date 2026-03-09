<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password');

        $users = [
            // 1. Super Admin
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => $password,
                'role' => 'super_admin',
                'department' => null,
                'npk' => null,
            ],
            // 2. Admin Perijinan
            [
                'name' => 'Admin Perijinan 1',
                'email' => 'admin1@example.com',
                'password' => $password,
                'role' => 'admin_perijinan',
                'department' => null,
                'npk' => null,
            ],
            [
                'name' => 'Admin Perijinan 2',
                'email' => 'admin2@example.com',
                'password' => $password,
                'role' => 'admin_perijinan',
                'department' => null,
                'npk' => null,
            ],
            // 3. Checker Lapangan
            [
                'name' => 'Checker Lapangan 1',
                'email' => 'checker1@example.com',
                'password' => $password,
                'role' => 'checker_lapangan',
                'department' => null,
                'npk' => null,
            ],
            [
                'name' => 'Checker Lapangan 2',
                'email' => 'checker2@example.com',
                'password' => $password,
                'role' => 'checker_lapangan',
                'department' => null,
                'npk' => null,
            ],
            // 4. AVP
            [
                'name' => 'AVP User 1',
                'email' => 'avp1@example.com',
                'password' => $password,
                'role' => 'avp',
                'department' => null,
                'npk' => null,
            ],
            [
                'name' => 'AVP User 2',
                'email' => 'avp2@example.com',
                'password' => $password,
                'role' => 'avp',
                'department' => null,
                'npk' => null,
            ],
            // 5. Viewers
            [
                'name' => 'Viewer User 1',
                'email' => 'viewer1@example.com',
                'password' => $password,
                'role' => 'viewer',
                'department' => 'Mining Operation',
                'npk' => 'PKT001',
                // security_code removed from here
            ],
            [
                'name' => 'Viewer User 2',
                'email' => 'viewer2@example.com',
                'password' => $password,
                'role' => 'viewer',
                'department' => 'Plant Operation',
                'npk' => 'PKT002',
                // security_code removed from here
            ],
            [
                'name' => 'Viewer User 3',
                'email' => 'viewer3@example.com',
                'password' => $password,
                'role' => 'viewer',
                'department' => 'External Contractor',
                'npk' => null,
                // security_code removed from here
            ],
        ];

        foreach ($users as $userData) {
            // Step 1: Check if user exists
            $user = User::where('email', $userData['email'])->first();

            if ($user) {
                // Only update allowed fields
                $user->update($userData);
            } else {
                // Create new user
                $user = User::create($userData);
            }

            // Step 2: Set security_code only if it is missing (and only for viewers)
            if ($user->role === 'viewer' && !$user->security_code) {
                // Use saveQuietly to bypass events if needed, but forceFill + save works if no 'updating' event blocks it.
                // The error was "Security Code cannot be modified". This means isDirty('security_code') was true.
                // But we are not setting security_code in $userData.
                // Maybe update() touches it? No.
                // Wait, if we use update(), it calls fill(). If security_code is not in $userData, it is not touched.
                // So isDirty should be false.
                
                // Let's ensure we are not accidentally setting it to null.
                // Ah, the previous code used updateOrCreate with the whole array.
                // If $userData doesn't have security_code, it shouldn't be dirty.
                
                // However, to be safe, let's just generate it if missing.
                $user->forceFill([
                    'security_code' => $this->generateSecurityCode()
                ])->saveQuietly();
            }
        }
    }

    private function generateSecurityCode()
    {
        do {
            $code = 'S-PKT-' . random_int(100000, 999999);
        } while (User::where('security_code', $code)->exists());

        return $code;
    }
}
