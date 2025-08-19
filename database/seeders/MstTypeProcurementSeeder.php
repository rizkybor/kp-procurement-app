<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MstTypeProcurementSeeder extends Seeder
{
    public function run(): void
    {
          DB::table('mst_type_procurement')->insert([
            ['name' => 'Barang'],
            ['name' => 'Jasa'],
            ['name' => 'Barang & Jasa'],
        ]);
    }
}
