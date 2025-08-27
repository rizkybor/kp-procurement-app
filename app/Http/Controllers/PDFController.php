<?php

namespace App\Http\Controllers;

use App\Models\WorkRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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
}
