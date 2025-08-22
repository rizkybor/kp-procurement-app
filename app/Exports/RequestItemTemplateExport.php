<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequestItemTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        // Pakai nama kolom sederhana & konsisten untuk import
        return ['deskripsi', 'jumlah', 'satuan', 'keterangan'];
    }

    public function array(): array
    {
        // Contoh baris agar user paham format
        return [
            ['Tabung Gas 50L', 10, 'unit', 'High pressure'],
            ['Regulator 1/2 inch', 5, 'pcs', 'Include seal'],
        ];
    }
}