<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Maker User', 'email' => 'maker@example.com', 'role' => 'maker'],
            ['name' => 'Fungsi Pengadaan User', 'email' => 'fungsi_pengadaan@example.com', 'role' => 'fungsi_pengadaan'],
            ['name' => 'Direktur Keuangan User', 'email' => 'direktur_keuangan@example.com', 'role' => 'direktur_keuangan'],
            ['name' => 'Direktur Utama User', 'email' => 'direktur_utama@example.com', 'role' => 'direktur_utama'],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => Hash::make('P@ssw0rd'),
                'nip' => rand(10000000, 99999999),
                'department' => 'Finance',
                'position' => ucfirst(str_replace('_', ' ', $user['role'])),
                'role' => $user['role'],
                'employee_status' => 'permanent',
                'gender' => 'male',
                'identity_number' => rand(100000000, 999999999),
                'signature' => null,
            ]);
        }
    }
}
