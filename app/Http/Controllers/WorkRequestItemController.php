<?php

namespace App\Http\Controllers;

use App\Models\WorkRequestItem;
use App\Models\WorkRequest;
use Illuminate\Http\Request;

class WorkRequestItemController extends Controller
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
    public function show(WorkRequestItem $workRequestItem)
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

        // Kirim data ke view
        return view('pages.work-request.work-request-details.request.index', compact('workRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkRequestItem $workRequestItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkRequestItem $workRequestItem)
    {
        //
    }
}
