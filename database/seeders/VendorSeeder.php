<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        // --- seed reference business types (for dropdown) ---
        DB::table('business_types')->upsert([
            ['id' => 1, 'name' => 'Individual', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Corporate',  'created_at' => now(), 'updated_at' => now()],
        ], ['id'], ['name', 'updated_at']);

        // --- example vendors (match english fields) ---
        $fixed = [
            [
                'name'             => 'PT Nusantara Teknik Abadi',
                'business_type'    => 'Corporate',
                'tax_number'       => '12.345.678.9-012.345',
                'company_address'  => 'Jl. Gatot Subroto No. 12, Jakarta',
                'business_fields'  => ['Material Procurement', 'Contractor'],
                'pic_name'         => 'Andi Pratama',
                'pic_position'     => 'Director',
            ],
            [
                'name'             => 'CV Mitra Karya Mandiri',
                'business_type'    => 'Corporate',
                'tax_number'       => '09.876.543.2-109.876',
                'company_address'  => 'Kompleks Ruko Harmoni Blok B-7, Bandung',
                'business_fields'  => ['Maintenance Service'],
                'pic_name'         => 'Siti Rahma',
                'pic_position'     => 'Operations Manager',
            ],
            [
                'name'             => 'PT Samudra Logistik',
                'business_type'    => 'Corporate',
                'tax_number'       => '01.234.567.8-901.234',
                'company_address'  => 'Jl. Perak Timur No. 88, Surabaya',
                'business_fields'  => ['Transportation', 'Logistics'],
                'pic_name'         => 'Budi Santoso',
                'pic_position'     => 'President Director',
            ],
        ];

        foreach ($fixed as $row) {
            Vendor::updateOrCreate(
                ['name' => $row['name']],
                $row
            );
        }

        // optional: add dummy via factory (ensure factory is updated to english fields)
        if (class_exists(\Database\Factories\VendorFactory::class)) {
            Vendor::factory()->count(25)->create();
        }
    }
}