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
}
