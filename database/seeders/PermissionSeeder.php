<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role
        $role_super_admin = Role::updateOrCreate(
            ['name' => 'super_admin'],
            ['name' => 'super_admin', 'guard_name' => 'web']
        );

        $role_maker = Role::updateOrCreate(
            ['name' => 'maker'],
            ['name' => 'maker', 'guard_name' => 'web']
        );

        $role_manager = Role::updateOrCreate( // ✅ tambahkan ini
            ['name' => 'manager'],
            ['name' => 'manager', 'guard_name' => 'web']
        );

        $role_fungsi_pengadaan = Role::updateOrCreate(
            ['name' => 'fungsi_pengadaan'],
            ['name' => 'fungsi_pengadaan', 'guard_name' => 'web']
        );

        $role_direktur_keuangan = Role::updateOrCreate(
            ['name' => 'direktur_keuangan'],
            ['name' => 'direktur_keuangan', 'guard_name' => 'web']
        );

        $role_direktur_utama = Role::updateOrCreate(
            ['name' => 'direktur_utama'],
            ['name' => 'direktur_utama', 'guard_name' => 'web']
        );

        // Permission
        $dashboard = Permission::updateOrCreate(
            ['name' => 'view_dashboard', 'guard_name' => 'web'],
            ['name' => 'view_dashboard', 'guard_name' => 'web']
        );

        // Assign Permission
        $role_maker->givePermissionTo($dashboard);
        $role_manager->givePermissionTo($dashboard); // ✅ tambahkan ini
        $role_fungsi_pengadaan->givePermissionTo($dashboard);
        $role_direktur_keuangan->givePermissionTo($dashboard);
        $role_direktur_utama->givePermissionTo($dashboard);

        // Assign User
        if ($user_super_admin = User::where('role', 'super_admin')->first()) {
            $user_super_admin->assignRole('super_admin');
        }

        if ($userMaker = User::where('role', 'maker')->first()) {
            $userMaker->assignRole('maker');
        }

        if ($user_manager = User::where('role', 'manager')->first()) { // ✅ tambahkan ini
            $user_manager->assignRole('manager');
        }

        if ($user_fungsi_pengadaan = User::where('role', 'fungsi_pengadaan')->first()) {
            $user_fungsi_pengadaan->assignRole('fungsi_pengadaan');
        }

        if ($user_direktur_keuangan = User::where('role', 'direktur_keuangan')->first()) {
            $user_direktur_keuangan->assignRole('direktur_keuangan');
        }

        if ($user_direktur_utama = User::where('role', 'direktur_utama')->first()) {
            $user_direktur_utama->assignRole('direktur_utama');
        }
    }
}