<?php

namespace App\Exports;

use App\Models\WorkRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkRequestExport implements FromCollection, WithHeadings
{
  protected $ids;

  public function __construct($ids)
  {
    $this->ids = explode(',', $ids);
  }

  public function collection()
  {
    return WorkRequest::whereIn('id', $this->ids)
      ->with(['workRequestRab', 'user']) // Mengambil relasi yang diperlukan
      ->get()
      ->map(function ($workRequest) {
        return [
          'ID' => $workRequest->id,
          'Nomor' => $workRequest->request_number ?? '-',
          'Nama Pekerjaan' => $workRequest->work_name_request ?? '-',
          'Bagian/Divisi' => $workRequest->department ?? '-',
          'Judul Proyek' => $workRequest->project_title ?? '-',
          'Pemilik Proyek' => $workRequest->project_owner ?? '-',
          'Jenis Pengadaan' => $workRequest->procurement_type ?? '-',
          'Nomor Kontrak' => $workRequest->contract_number ?? '-',
          'Total RAB' => 'Rp ' . number_format($workRequest->total_rab, 2, ',', '.'),
          'Tanggal Permintaan' => $workRequest->request_date
            ? \Carbon\Carbon::parse($workRequest->request_date)->format('d-m-Y')
            : '-',
          'Tenggat' => $workRequest->deadline
            ? \Carbon\Carbon::parse($workRequest->deadline)->format('d-m-Y')
            : '-',
          'PIC' => $workRequest->pic ?? '-',
        ];
      });
  }

  public function headings(): array
  {
    return [
      'ID',
      'Nomor Permintaan',
      'Nama Pekerjaan',
      'Departemen',
      'Judul Proyek',
      'Pemilik Proyek',
      'Jenis Pengadaan',
      'Nomor Kontrak',
      'Total RAB',
      'Tanggal Permintaan',
      'Batas Waktu',
      'PIC',
      'Status',
      'Dibuat Pada'
    ];
  }
}
