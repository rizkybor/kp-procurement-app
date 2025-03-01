<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataFeed;

class DashboardController extends Controller
{
    public function index()
    {
        $dataFeed = new DataFeed();

        // dd(auth()->user()->getRoleNames());

        return view('pages/dashboard/dashboard', compact('dataFeed'));
    }

    public function  docs_pengadaan()
    {
        return view('pages/documents/index');
    }

    public function  docs_pengadaan_create()
    {
        return view('pages/documents/create');
    }

    public function  docs_pengadaan_edit()
    {
        return view('pages/documents/document-details/edit');
    }


    public function  docs_pengadaan_edit_request()
    {
        return view('pages/documents/document-details/request/index');
    }
    public function  docs_pengadaan_edit_rab()
    {
        return view('pages/documents/document-details/rab/index');
    }
}
