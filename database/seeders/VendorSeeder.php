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

        // --- 10 fixed vendors ---
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
            [
                'name'             => 'CV Cahaya Elektrik',
                'business_type'    => 'Corporate',
                'tax_number'       => '45.678.901.2-345.678',
                'company_address'  => 'Jl. Ahmad Yani No. 45, Medan',
                'business_fields'  => ['Electrical Installation'],
                'pic_name'         => 'Teguh Saputra',
                'pic_position'     => 'Manager',
            ],
            [
                'name'             => 'PT Maju Jaya Konsultan',
                'business_type'    => 'Corporate',
                'tax_number'       => '98.765.432.1-234.567',
                'company_address'  => 'Jl. Diponegoro No. 10, Yogyakarta',
                'business_fields'  => ['Consulting', 'Engineering'],
                'pic_name'         => 'Rizky Hidayat',
                'pic_position'     => 'Consultant',
            ],
            [
                'name'             => 'CV Sentosa Abadi',
                'business_type'    => 'Corporate',
                'tax_number'       => '33.444.555.6-777.888',
                'company_address'  => 'Jl. Sudirman No. 99, Semarang',
                'business_fields'  => ['Construction'],
                'pic_name'         => 'Ayu Lestari',
                'pic_position'     => 'Project Manager',
            ],
            [
                'name'             => 'PT Prima Konstruksi',
                'business_type'    => 'Corporate',
                'tax_number'       => '11.222.333.4-555.666',
                'company_address'  => 'Jl. Basuki Rahmat No. 21, Malang',
                'business_fields'  => ['General Contractor'],
                'pic_name'         => 'Yudi Prakoso',
                'pic_position'     => 'Site Manager',
            ],
            [
                'name'             => 'CV Harapan Baru',
                'business_type'    => 'Corporate',
                'tax_number'       => '77.888.999.1-222.333',
                'company_address'  => 'Jl. Merdeka No. 56, Bogor',
                'business_fields'  => ['Supplier', 'Trading'],
                'pic_name'         => 'Dewi Sartika',
                'pic_position'     => 'Owner',
            ],
            [
                'name'             => 'PT Global Informatika',
                'business_type'    => 'Corporate',
                'tax_number'       => '55.666.777.8-999.000',
                'company_address'  => 'Jl. Cikini Raya No. 78, Jakarta',
                'business_fields'  => ['IT Solutions', 'Networking'],
                'pic_name'         => 'Fajar Nugroho',
                'pic_position'     => 'IT Director',
            ],
            [
                'name'             => 'CV Mandiri Sejahtera',
                'business_type'    => 'Corporate',
                'tax_number'       => '22.333.444.5-666.777',
                'company_address'  => 'Jl. Imam Bonjol No. 5, Denpasar',
                'business_fields'  => ['Interior Design'],
                'pic_name'         => 'Kadek Wijaya',
                'pic_position'     => 'Interior Designer',
            ],
        ];

        foreach ($fixed as $row) {
            Vendor::updateOrCreate(
                ['name' => $row['name']],
                $row
            );
        }
    }
}
