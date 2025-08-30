<?php

namespace App\Http\Controllers;

use App\Models\WorkRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
}
