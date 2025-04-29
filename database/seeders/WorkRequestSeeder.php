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
        // Penyesuaian: user_id 1 untuk SDM & HR, user_id 2 untuk Finance & lainnya
        $userSdm = 1;
        $userFinance = 2;

        $departments = [
            'HR Department',          // SDM → user 1
            'Finance Department',     // Finance → user 2
            'IT Department',          // Finance → user 2
            'Marketing Department',   // Finance → user 2
            'Sales Department',       // Finance → user 2
            'Inventory Department',   // Finance → user 2
            'Logistics Department',   // Finance → user 2
        ];

        $workRequests = [];
        $nextNumber = 10;

        for ($i = 0; $i < 15; $i++) {
            $monthRoman = $this->convertToRoman(Carbon::now()->month);
            $year = Carbon::now()->year;

            $department = $departments[$i % count($departments)];

            // Tetapkan user berdasarkan departemen
            $createdBy = str_contains(strtolower($department), 'hr') ? $userSdm : $userFinance;

            $numberFormat = sprintf("%04d.FP-KPU-%s-%s", $nextNumber, $monthRoman, $year);

            $workRequests[] = [
                'created_by' => $createdBy,
                'work_name_request' => 'Pekerjaan ' . ($i + 1),
                'request_number' => $numberFormat,
                'department' => $department,
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
                'status'         => 0,
                'last_reviewers' => null,
            ];

            $nextNumber += 10;
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
