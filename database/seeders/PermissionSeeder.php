<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            [
                'name' => 'super_admin',
            ],
            ['name' => 'super_admin']
        );

        $role_maker = Role::updateOrCreate(
            [
                'name' => 'maker',
            ],
            ['name' => 'maker']
        );

        $role_fungsi_pengadaan = Role::updateOrCreate(
            [
                'name' => 'fungsi_pengadaan',
            ],
            ['name' => 'fungsi_pengadaan']
        );

        $role_direktur_keuangan = Role::updateOrCreate(
            [
                'name' => 'direktur_keuangan',
            ],
            ['name' => 'direktur_keuangan']
        );

        $role_direktur_utama = Role::updateOrCreate(
            [
                'name' => 'direktur_utama',
            ],
            ['name' => 'direktur_utama']
        );


        // Permission

        $dashboard = Permission::updateOrCreate(
            [
                'name' => 'view_dashboard',
            ],
            ['name' => 'view_dashboard']
        );

        // Assign Permission

        $role_maker->givePermissionTo($dashboard);
        $role_fungsi_pengadaan->givePermissionTo($dashboard);
        $role_direktur_keuangan->givePermissionTo($dashboard);
        $role_direktur_utama->givePermissionTo($dashboard);


        // Assign User

        $user_super_admin = User::where('role', 'super_admin')->first();
        $user_super_admin->assignRole('super_admin');

        $userMaker = User::where('role', 'maker')->first();
        $userMaker->assignRole('maker');

        $user_fungsi_pengadaan = User::where('role', 'fungsi_pengadaan')->first();
        $user_fungsi_pengadaan->assignRole('fungsi_pengadaan');

        $user_direktur_keuangan = User::where('role', 'direktur_keuangan')->first();
        $user_direktur_keuangan->assignRole('direktur_keuangan');

        $user_direktur_utama = User::where('role', 'direktur_utama')->first();
        $user_direktur_utama->assignRole('direktur_utama');
    }
}
