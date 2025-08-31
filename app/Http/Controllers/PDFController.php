<?php

namespace App\Http\Controllers;

use App\Models\WorkRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

class PDFController extends Controller
{
  /**
   * Generate and download PDF file.
   *
   * @return \Illuminate\Http\Response
   */
  public function generateRequest($id)
  {
    $workRequest = WorkRequest::with([
      'User',
      'workRequestItems',
      'workRequestRab',
      'workRequestSignatures',
      'workRequestSpesifications'
    ])->findOrFail($id);

    $data = [
      'workRequest' => $workRequest
    ];

    // Load Blade view dari folder templates
    $pdf = Pdf::loadView('templates.document-form-request', $data);

    // Download file PDF dengan nama document-letter.pdf
    // return $pdf->download('document-form-request.pdf');
    return $pdf->stream('document-form-request.pdf');
  }

  public function generateRab($id)
  {
    $workRequest = WorkRequest::with([
      'User',
      'workRequestItems',
      'workRequestRab'
    ])->findOrFail($id);

    $data = [
      'workRequest' => $workRequest
    ];

    // Load Blade view dari folder templates
    $pdf = Pdf::loadView('templates.document-rab', $data);

    // Download file PDF dengan nama document-letter.pdf
    // return $pdf->download('document-rab.pdf');
    return $pdf->stream('document-rab.pdf');
  }

  public function generateApplication($id)
  {
    $workRequest = WorkRequest::with([
      'User',
      'workRequestItems',
      'workRequestRab',
      'orderCommunications',
    ])->findOrFail($id);

    $data = [
      'workRequest' => $workRequest
    ];

    // Load Blade view dari folder templates
    $pdf = Pdf::loadView('templates.document-application', $data);

    return $pdf->stream('document-application.pdf');
  }

  public function generateNegotiation($id)
  {
    $workRequest = WorkRequest::with([
      'User',
      'workRequestItems',
      'workRequestRab',
      'orderCommunications',
    ])->findOrFail($id);

    $data = [
      'workRequest' => $workRequest
    ];

    // Load Blade view dari folder templates
    $pdf = Pdf::loadView('templates.document-negotiation', $data);

    return $pdf->stream('document-negotiation.pdf');
  }

  public function generateEvaluation($id)
  {
    // ambil template
    $templatePath = storage_path('app/templates/evaluasi-teknik-penawaran-mitra.xlsx');
    $spreadsheet = IOFactory::load($templatePath);

    // ambil sheet pertama
    $sheet = $spreadsheet->getActiveSheet();

    $workRequest = WorkRequest::with([
      'User',
      'workRequestItems',
      'workRequestRab',
      'orderCommunications',
      'workRequestSpesifications',
    ])->findOrFail($id);

    $sheet->setCellValue('D7', $workRequest->orderCommunications->first()->vendor->name);
    $sheet->setCellValue('C11', $workRequest->workRequestSpesifications->first()->contract_type);
    $sheet->setCellValue('C13', $workRequest->workRequestSpesifications->first()->work_duration);
    $sheet->setCellValue('C15', $workRequest->workRequestSpesifications->first()->payment_mechanism);

    // export hasil
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

    return response()->streamDownload(function () use ($writer) {
      $writer->save('php://output');
    }, 'evaluasi-teknik-penawaran-mitra.xlsx');
  }

  public function generateBeritaacara($id)
  {
    // ambil template
    $templatePath = storage_path('app/templates/berita-acara-klarifikasi-&-negoisasi-harga.xlsx');
    $spreadsheet = IOFactory::load($templatePath);

    // ambil sheet pertama
    $sheet = $spreadsheet->getActiveSheet();

    $workRequest = WorkRequest::with([
      'User',
      'workRequestItems',
      'workRequestRab',
      'orderCommunications.vendor',
      'workRequestSpesifications',
    ])->findOrFail($id);

    // tanggal
    $date = Carbon::parse($workRequest->orderCommunications->first()->date_beritaacaraklarifikasi)->locale('id');

    $hari = $date->translatedFormat('l'); // Senin
    $tanggal = $this->terbilang((int) $date->format('d')); // Tujuh Belas
    $bulan = $date->translatedFormat('F'); // Februari
    $tahun = $this->terbilang((int) $date->format('Y')); // Dua Ribu Dua Puluh Lima

    $kalimatTanggal = "Pada hari ini {$hari} tanggal {$tanggal} Bulan {$bulan} Tahun {$tahun}";
    $no = "No:{$workRequest->orderCommunications->first()->no_beritaacaraklarifikasi}";
    $teks = "Menyatakan telah melakukan Klarifikasi dan Negosiasi Harga Pekerjaan {$workRequest->work_name_request} antara PT KPU dengan {$workRequest->orderCommunications->first()->vendor->pic_name}/{$workRequest->orderCommunications->first()->vendor->name}\, dengan rincian harga (terlampir).";

    // isi sheet
    $sheet->setCellValue('B3', $no);
    $sheet->setCellValue('B5', $kalimatTanggal);
    $sheet->setCellValue('E14', $workRequest->orderCommunications->first()->vendor->pic_name);
    $sheet->setCellValue('E15', $workRequest->orderCommunications->first()->vendor->pic_position);
    $sheet->setCellValue('E16', $workRequest->orderCommunications->first()->vendor->name);
    $sheet->setCellValue('B21', $teks);
    $sheet->setCellValue('F37', $workRequest->orderCommunications->first()->vendor->pic_name);
    $sheet->setCellValue('F38', $workRequest->orderCommunications->first()->vendor->pic_position);

    // export hasil
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    return response()->streamDownload(function () use ($writer) {
      $writer->save('php://output');
    }, 'berita-acara-klarifikasi.xlsx');
  }

  private function terbilang($angka)
  {
    $angka = abs($angka);
    $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
    $temp = "";

    if ($angka < 12) {
      $temp = " " . $huruf[$angka];
    } else if ($angka < 20) {
      $temp = $this->terbilang($angka - 10) . " Belas";
    } else if ($angka < 100) {
      $temp = $this->terbilang(intval($angka / 10)) . " Puluh " . $this->terbilang($angka % 10);
    } else if ($angka < 200) {
      $temp = " Seratus " . $this->terbilang($angka - 100);
    } else if ($angka < 1000) {
      $temp = $this->terbilang(intval($angka / 100)) . " Ratus " . $this->terbilang($angka % 100);
    } else if ($angka < 2000) {
      $temp = " Seribu " . $this->terbilang($angka - 1000);
    } else if ($angka < 1000000) {
      $temp = $this->terbilang(intval($angka / 1000)) . " Ribu " . $this->terbilang($angka % 1000);
    } else if ($angka < 1000000000) {
      $temp = $this->terbilang(intval($angka / 1000000)) . " Juta " . $this->terbilang($angka % 1000000);
    }

    return trim(preg_replace('/\s+/', ' ', $temp)); // rapikan spasi double
  }

  public function generateLampiranBeritaacara($id)
  {
    // ambil template
    $templatePath = storage_path('app/templates/lampiran-berita-acara-klarifikasi-&-negoisasi-harga.xlsx');
    $spreadsheet = IOFactory::load($templatePath);
    $sheet = $spreadsheet->getActiveSheet();

    // Buat style dengan font Arial MT normal (ukuran 9, tidak bold)
    $arialMTStyle = [
      'font' => [
        'name' => 'Arial MT',
        'size' => 9,
        'bold' => false
      ]
    ];

    // Style untuk TTD (bold dan ukuran 10)
    $ttdStyle = [
      'font' => [
        'name' => 'Arial MT',
        'size' => 10,
        'bold' => true
      ]
    ];

    // Style untuk baris JUMLAH (background kuning, bold, rata tengah)
    $jumlahStyle = [
      'font' => [
        'name' => 'Arial MT',
        'size' => 9,
        'bold' => true
      ],
      'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => [
          'argb' => 'FFFFFF00' // Kuning
        ]
      ],
      'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
      ]
    ];

    // Style untuk angka total (bold)
    $totalBoldStyle = [
      'font' => [
        'name' => 'Arial MT',
        'size' => 9,
        'bold' => true
      ],
      'numberFormat' => [
        'formatCode' => '"Rp"#,##0.00_-'
      ]
    ];

    // Style untuk border (garis)
    $borderStyle = [
      'borders' => [
        'allBorders' => [
          'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
          'color' => ['argb' => 'FF000000'],
        ],
      ],
    ];

    $workRequest = WorkRequest::with(['workRequestItems'])->findOrFail($id);

    // data contoh
    $data = $workRequest->workRequestItems->map(function ($item) {
      return [
        'desc'  => $item->item_name,
        'qty'   => $item->quantity,
        'unit'  => $item->unit,
        'harga' => $item->harga,
      ];
    });

    $title = "{$workRequest->orderCommunications->first()->vendor->pic_name}/{$workRequest->orderCommunications->first()->vendor->name}";

    $sheet->setCellValue('I7', $title);

    // baris awal data
    $startRow = 11;

    // isi data ke dalam sheet
    $currentRow = $startRow;
    $totalHarga = 0;

    foreach ($data as $index => $item) {
      $sheet->setCellValue('A' . $currentRow, $index + 1);
      $sheet->setCellValue('B' . $currentRow, $item['desc']);
      $sheet->setCellValue('M' . $currentRow, $item['qty']);
      $sheet->setCellValue('N' . $currentRow, $item['unit']);
      $sheet->setCellValue('O' . $currentRow, $item['harga']);

      // Hitung total per item
      $itemTotal = $item['qty'] * $item['harga'];
      $sheet->setCellValue('P' . $currentRow, $itemTotal);

      $totalHarga += $itemTotal;

      // Terapkan font Arial MT untuk setiap baris data (ukuran 9, tidak bold)
      $sheet->getStyle('A' . $currentRow . ':R' . $currentRow)->applyFromArray($arialMTStyle);

      $currentRow++;
    }

    // Isi total harga
    $jumlahRow = $currentRow;
    $sheet->setCellValue('B' . $jumlahRow, 'JUMLAH');
    $sheet->setCellValue('P' . $jumlahRow, $totalHarga);

    // Terapkan style untuk baris JUMLAH (background kuning, bold, rata tengah)
    $sheet->getStyle('B' . $jumlahRow . ':R' . $jumlahRow)->applyFromArray($jumlahStyle);

    // Terapkan style khusus untuk angka total (bold dengan format mata uang)
    $sheet->getStyle('P' . $jumlahRow)->applyFromArray($totalBoldStyle);

    // TERAPKAN BORDER UNTUK SELURUH TABEL (dari startRow sampai jumlahRow, kolom A sampai R)
    $tableRange = 'A' . $startRow . ':R' . $jumlahRow;
    $sheet->getStyle($tableRange)->applyFromArray($borderStyle);

    // TTD
    $ttdRow1 = $currentRow + 3;
    $ttdRow2 = $currentRow + 6;
    $ttdRow3 = $currentRow + 7;

    $sheet->setCellValue('B' . $ttdRow1, 'PIHAK PERTAMA');
    $sheet->setCellValue('B' . $ttdRow2, 'Sutaryo');
    $sheet->setCellValue('B' . $ttdRow3, 'Direktur Keuangan dan Administrasi');

    $sheet->setCellValue('O' . $ttdRow1, 'PIHAK KEDUA');
    $sheet->setCellValue('O' . $ttdRow2, $workRequest->orderCommunications->first()->vendor->pic_name);
    $sheet->setCellValue('O' . $ttdRow3, $workRequest->orderCommunications->first()->vendor->pic_position);

    // Terapkan font untuk baris TTD (bold dan ukuran 10)
    $sheet->getStyle('B' . $ttdRow1)->applyFromArray($ttdStyle);
    $sheet->getStyle('B' . $ttdRow2)->applyFromArray($ttdStyle);
    $sheet->getStyle('B' . $ttdRow3)->applyFromArray($ttdStyle);

    $sheet->getStyle('O' . $ttdRow1)->applyFromArray($ttdStyle);
    $sheet->getStyle('O' . $ttdRow2)->applyFromArray($ttdStyle);
    $sheet->getStyle('O' . $ttdRow3)->applyFromArray($ttdStyle);

    // Format mata uang untuk kolom harga dan total (ukuran 9, tidak bold)
    $currencyStyle = [
      'numberFormat' => [
        'formatCode' => '"Rp"#,##0.00_-'
      ],
      'font' => [
        'name' => 'Arial MT',
        'size' => 9,
        'bold' => false
      ]
    ];

    // Terapkan format untuk kolom O (harga satuan) dan P (total harga)
    $lastDataRow = $currentRow - 1;
    $sheet->getStyle('O' . $startRow . ':P' . $lastDataRow)->applyFromArray($currencyStyle);

    // export hasil
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    return response()->streamDownload(function () use ($writer) {
      $writer->save('php://output');
    }, 'lampiran-berita-acara-klarifikasi.xlsx');
  }

  public function generateSuratPenunjukan($id)
  {
    // ambil template
    $templatePath = storage_path('app/templates/surat-penunjukan-penyedia-barangjasa.xlsx');
    $spreadsheet = IOFactory::load($templatePath);

    // ambil sheet pertama
    $sheet = $spreadsheet->getActiveSheet();

    $workRequest = WorkRequest::with([
      'User',
      'workRequestItems',
      'workRequestRab',
      'orderCommunications',
      'workRequestSpesifications',
    ])->findOrFail($id);


    $date = "Jakarta, " . Carbon::parse($workRequest->orderCommunications->first()->date_suratpenunjukan)
      ->translatedFormat('d F Y');
    $teks = "Dengan ini kami menunjuk Perusahaan saudara sebagai Penyedia Jasa untuk melaksanakan {$workRequest->work_name_request}, dengan ketentuan sebagai berikut :";

    $sheet->setCellValue('E12', $workRequest->orderCommunications->first()->no_suratpenunjukan);
    $sheet->setCellValue('K12', $date);
    $sheet->setCellValue('A17', $workRequest->orderCommunications->first()->vendor->pic_name);
    $sheet->setCellValue('A18', $workRequest->orderCommunications->first()->vendor->name);
    $sheet->setCellValue('A19', $workRequest->orderCommunications->first()->vendor->company_address);
    $sheet->setCellValue('A26', $teks);
    $sheet->setCellValue('G34', $workRequest->work_name_request);
    $sheet->setCellValue('G36', $workRequest->orderCommunications->first()->nilaikontrak_suratpenunjukan);

    // export hasil
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

    return response()->streamDownload(function () use ($writer) {
      $writer->save('php://output');
    }, 'surat-penunjukan-penyedia-barangjasa.xlsx');;
  }
}
