<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WorkRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [1, 2]; // Assuming users with ID 1 and 2 exist
        $departments = [
            'IT Department',
            'Marketing Department',
            'Finance Department',
            'HR Department',
            'Sales Department',
            'Inventory Department',
            'Logistics Department',
        ];

        $workRequests = [];
        $nextNumber = 10; // Start with the first number

        for ($i = 0; $i < 15; $i++) {
            $monthRoman = $this->convertToRoman(Carbon::now()->month);
            $year = Carbon::now()->year;

            // Format nomor dokumen
            $numberFormat = sprintf("%04d.FP-KPU-%s-%s", $nextNumber, $monthRoman, $year);

            $workRequests[] = [
                'created_by' => $users[$i % count($users)],
                'work_name_request' => 'Pekerjaan ' . ($i + 1),
                'request_number' => $numberFormat,
                'department' => $departments[$i % count($departments)],
                'project_title' => 'Proyek ' . ($i + 1),
                'project_owner' => 'Owner ' . ($i + 1),
                'contract_number' => 'CN-2025-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'procurement_type' => 'Pengadaan Langsung',
                'request_date' => Carbon::now()->addDays($i)->toDateString(),
                'deadline' => Carbon::now()->addDays($i + 90)->toDateString(),
                'pic' => 'PIC ' . ($i + 1),
                'aanwijzing' => 'Aanwijzing akan dilakukan pada ' . Carbon::now()->addDays($i + 5)->toDateString(),
                'time_period' => ($i + 1) . ' Bulan',
                'created_at' => Carbon::now()->addDays($i),
                'updated_at' => Carbon::now()->addDays($i),
            ];

            $nextNumber += 10; // Increment by 10 for the next record
        }

        DB::table('work_request')->insert($workRequests);
    }

    /**
     * Convert a number to its Roman numeral representation.
     *
     * @param int $num
     * @return string
     */
    private function convertToRoman($num)
    {
        $map = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1,
        ];
        $returnValue = '';
        while ($num > 0) {
            foreach ($map as $roman => $value) {
                if ($num >= $value) {
                    $num -= $value;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}
