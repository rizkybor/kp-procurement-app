<?php

namespace Database\Seeders;

use App\Models\MstTypeProcurement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            DashboardTableSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            WorkRequestSeeder::class,
            MstKeproyekanSeeder::class,
            MstTypeProcurementSeeder::class,
        ]);
    }
}
