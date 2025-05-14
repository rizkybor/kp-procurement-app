<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;

class WorkRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get users with maker role
        $makerUsers = User::where('role', 'maker')->get();

        $departments = [
            'SDM',
            'Finance',
            'Pengadaan',
            'Keuangan',
            'Operasi',
            'Direksi'
        ];

        $workRequests = [];
        $nextNumber = 10;

        for ($i = 0; $i < 15; $i++) {
            $monthRoman = $this->convertToRoman(Carbon::now()->month);
            $year = Carbon::now()->year;

            $department = $departments[$i % count($departments)];

            // Find a maker user from the same department
            $createdBy = $makerUsers->firstWhere('department', $department) ?
                $makerUsers->firstWhere('department', $department)->id :
                $makerUsers->first()->id;

            $numberFormat = sprintf("%04d.FP-KPU-%s-%s", $nextNumber, $monthRoman, $year);

            $statusOptions = ['Draft', 'Submitted', 'Reviewed', 'Approved', 'Rejected', 'Revised'];
            $status = $statusOptions[array_rand($statusOptions)];

            $workRequests[] = [
                'created_by' => $createdBy,
                'work_name_request' => 'PROYEK ' . ($i + 1),
                'request_number' => $numberFormat,
                'department' => $department,
                'project_title' => 'Proyek ' . ($i + 1),
                'project_owner' => 'Owner ' . ($i + 1),
                'contract_number' => 'CN-2025-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'procurement_type' => ['Pengadaan Langsung', 'Tender', 'Penunjukan Langsung'][rand(0, 2)],
                'request_date' => Carbon::now()->subDays(rand(1, 30))->toDateString(),
                'deadline' => Carbon::now()->addDays(rand(60, 120))->toDateString(),
                'pic' => 'PIC ' . ($i + 1),
                'aanwijzing' => 'Aanwijzing akan dilakukan pada ' . Carbon::now()->addDays(rand(5, 15))->toDateString(),
                'time_period' => ($i % 3 + 1) . ' Bulan',
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30)),
                'status' => 0,
                'last_reviewers' => null,
            ];

            $nextNumber += 10;
        }

        DB::table('work_request')->insert($workRequests);
    }

    /**
     * Convert a number to its Roman numeral representation.
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
            'I' => 1
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
