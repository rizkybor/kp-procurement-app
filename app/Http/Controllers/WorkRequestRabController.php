<?php

namespace App\Http\Controllers;

use App\Models\WorkRequest;
use App\Models\WorkRequestItem;
use App\Models\WorkRequestRab;
use Illuminate\Http\Request;

class WorkRequestRabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkRequestRab $workRequestRab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data WorkRequest berdasarkan ID
        $workRequest = WorkRequest::findOrFail($id);
        $itemRequest = WorkRequestItem::where('work_request_id', $id)->get();

        // Kirim data ke view
        return view('pages.work-request.work-request-details.rab.index', compact('workRequest', 'itemRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkRequestRab $workRequestRab)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkRequestRab $workRequestRab)
    {
        //
    }
}
