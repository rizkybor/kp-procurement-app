<?php

namespace App\Http\Controllers;

use App\Models\WorkRequest;
use App\Models\WorkRequestSpesification;
use Illuminate\Http\Request;

class WorkRequestSpesificationController extends Controller
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
    public function store(Request $request, $id)
    {
        $request->validate([
            'scope_of_work' => 'required',
            'contract_type' => 'required',
            'safety_aspect' => 'required',
            'reporting' => 'required',
            'provider_requirements' => 'required',
            'payment_procedures' => 'required',
        ]);

        WorkRequestSpesification::create([
            'work_request_id' => $id,
            'scope_of_work' => $request->scope_of_work,
            'contract_type' => $request->contract_type,
            'safety_aspect' => $request->safety_aspect,
            'reporting' => $request->reporting,
            'provider_requirements' => $request->provider_requirements,
            'payment_procedures' => $request->payment_procedures,
        ]);

        return redirect()->route('work_request.work_spesifications.edit', ['id' => $id])->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkRequestSpesification $workRequestSpesification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $workRequest = WorkRequest::findOrFail($id);
        $specRequest = WorkRequestSpesification::where('work_request_id', $id)->get();

        return view('pages.work-request.work-request-details.spesification.index', compact('workRequest', 'specRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $work_request_id, $work_spesification_id)
    {
        $request->validate([
            'scope_of_work' => 'required',
            'contract_type' => 'required',
            'safety_aspect' => 'required',
            'reporting' => 'required',
            'provider_requirements' => 'required',
            'payment_procedures' => 'required',
        ]);

        $specRequest = WorkRequestSpesification::where('work_request_id', $work_request_id)
            ->where('id', $work_spesification_id)
            ->firstOrFail();

        $specRequest->update([
            'scope_of_work' => $request->scope_of_work,
            'contract_type' => $request->contract_type,
            'safety_aspect' => $request->safety_aspect,
            'reporting' => $request->reporting,
            'provider_requirements' => $request->provider_requirements,
            'payment_procedures' => $request->payment_procedures,
        ]);

        return redirect()->route('work_request.work_spesifications.edit', ['id' => $work_request_id])->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $work_spesification_id)
    {
        $specRequest = WorkRequestSpesification::findOrFail($work_spesification_id);

        $specRequest->delete();

        return redirect()->route('work_request.work_spesifications.edit', ['id' => $id])->with('success', 'Data berhasil dihapus!');
    }
}
