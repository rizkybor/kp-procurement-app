<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // ✅ Buat akun Super Admin saja
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('@wasd123!'),
            'nip' => rand(10000000, 99999999),
            'department' => null,
            'position' => 'Super Admin',
            'role' => 'super_admin',
            'employee_status' => 'permanent',
            'gender' => 'male',
            'identity_number' => rand(100000000, 999999999),
            'signature' => null,
        ]);

        /*
        // 🔒 User lain dinonaktifkan sementara
        $users = [
            ['name' => 'Maker Sdm', 'email' => 'maker1@example.com', 'role' => 'maker', 'department' => 'SDM'],
            ['name' => 'Maker Operasi', 'email' => 'maker2@example.com', 'role' => 'maker', 'department' => 'Operasi'],
            ['name' => 'Manager Sdm', 'email' => 'manager1@example.com', 'role' => 'manager', 'department' => 'SDM'],
            ['name' => 'Manager Operasi', 'email' => 'manager2@example.com', 'role' => 'manager', 'department' => 'Operasi'],
            ['name' => 'Direktur Keuangan User', 'email' => 'direktur_keuangan@example.com', 'role' => 'direktur_keuangan', 'department' => 'Keuangan'],
            ['name' => 'Direktur Utama User', 'email' => 'direktur_utama@example.com', 'role' => 'direktur_utama', 'department' => 'Direksi'],
            ['name' => 'Fungsi Pengadaan User', 'email' => 'fungsi_pengadaan@example.com', 'role' => 'fungsi_pengadaan', 'department' => 'Pengadaan'],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('P@ssw0rd'),
                'nip' => rand(10000000, 99999999),
                'department' => $user['department'],
                'position' => ucfirst(str_replace('_', ' ', $user['role'])),
                'role' => $user['role'],
                'employee_status' => 'permanent',
                'gender' => 'male',
                'identity_number' => rand(100000000, 999999999),
                'signature' => null,
            ]);
        }
        */
    }
}