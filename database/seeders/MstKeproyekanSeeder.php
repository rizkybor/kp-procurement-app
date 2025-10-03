<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MstKeproyekanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mst_keproyekan')->insert([
            ['name' => 'Internal'],
            ['name' => 'Keproyekan'],
        ]);
    }
}