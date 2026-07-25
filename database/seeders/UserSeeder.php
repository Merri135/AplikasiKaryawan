<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua data lama
        // User::truncate();
        User::query()->delete();


        // Buat data user default
        $users = [
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ],
            [
                'nama' => 'HRD',
                'email' => 'hr@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'hrd',
            ],
            [
                'nama' => 'Rianti',
                'email' => 'spv@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'supervisor',
            ],
            [
                'nama' => 'Ahmad Anang',
                'email' => 'karyawan@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'karyawan',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('✅ User default berhasil dibuat: admin, hrd, atasan, dan karyawan.');
    }
}
