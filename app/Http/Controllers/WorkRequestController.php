<?php

namespace App\Http\Controllers;

use App\Models\WorkRequest;
use Illuminate\Http\Request;

class WorkRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.work-request.index');
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
    public function show(WorkRequest $workRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkRequest $workRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkRequest $workRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkRequest $workRequest)
    {
        //
    }
}
