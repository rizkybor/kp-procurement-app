<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
  /**
   * Generate and download PDF file.
   *
   * @return \Illuminate\Http\Response
   */
  public function generateRequest()
  {
    $data = [
      'title' => 'Contoh PDF',
      'content' => 'Ini adalah contoh PDF dalam Laravel 10.'
    ];

    // Load Blade view dari folder templates
    $pdf = Pdf::loadView('templates.document-form-request', $data);

    // Download file PDF dengan nama document-letter.pdf
    // return $pdf->download('document-form-request.pdf');
    return $pdf->stream('document-form-request.pdf');
  }

  public function generateRab()
  {
    $data = [
      'title' => 'Contoh PDF',
      'content' => 'Ini adalah contoh PDF dalam Laravel 10.'
    ];

    // Load Blade view dari folder templates
    $pdf = Pdf::loadView('templates.document-rab', $data);

    // Download file PDF dengan nama document-letter.pdf
    // return $pdf->download('document-rab.pdf');
    return $pdf->stream('document-rab.pdf');
  }
}
