<?php

namespace App\Http\Controllers;

use App\Models\DocumentApproval;
use App\Models\WorkRequest;
use App\Models\WorkRequestRab;
use App\Models\WorkRequestSpesification;
use App\Models\WorkRequestItem;
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
    $data = $request->validate([
        'contract_type'      => ['nullable','string','max:255'],
        'payment_mechanism'  => ['nullable','string','max:255'],
        'work_duration'      => ['nullable','string','max:255'],
    ]);

    $spec = \App\Models\WorkRequestSpesification::create([
        'work_request_id'   => $id,
        'contract_type'     => $data['contract_type']     ?? null,
        'payment_mechanism' => $data['payment_mechanism'] ?? null,
        'work_duration'     => $data['work_duration']     ?? null,
    ]);

    return response()->json([
        'message' => 'Created',
        'data' => $spec->only(['id','contract_type','payment_mechanism','work_duration']),
    ], 201);
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $workRequest = WorkRequest::findOrFail($id);
        $specRequest = WorkRequestSpesification::with('files')
            ->where('work_request_id', $id)
            ->first();

        // Semua item untuk WR ini
        $itemRequest = WorkRequestItem::where('work_request_id', $id)->get();

        // Total RAB sekarang dari item
        $totalRab = $itemRequest->sum('total_harga');

        $latestApprover = DocumentApproval::where('document_id', $id)
            ->where('status', '!=', '102') // Abaikan status revisi jika perlu
            ->with('approver')
            ->latest('approved_at')
            ->first();

        return view(
            'pages.work-request.work-request-details.spesification.show',
            compact('workRequest', 'specRequest', 'totalRab', 'latestApprover')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $workRequest = WorkRequest::findOrFail($id);
        $specRequest = WorkRequestSpesification::with('files')
            ->where('work_request_id', $id)
            ->first();

        $latestApprover = DocumentApproval::where('document_id', $id)
            ->where('status', '!=', '102') // Abaikan status revisi jika perlu
            ->with('approver')
            ->latest('approved_at')
            ->first();

        return view(
            'pages.work-request.work-request-details.spesification.index',
            compact('workRequest', 'specRequest', 'latestApprover')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $work_spesification_id)
{
    $spec = \App\Models\WorkRequestSpesification::where('work_request_id', $id)
        ->where('id', $work_spesification_id)
        ->firstOrFail();

    $data = $request->validate([
        'contract_type'      => ['nullable','string','max:255'],
        'payment_mechanism'  => ['nullable','string','max:255'],
        'work_duration'      => ['nullable','string','max:255'],
    ]);

    // hanya update key yang ada di request
    $spec->fill($data);
    $spec->save();

    return response()->json([
        'message' => 'Updated',
        'data' => $spec->only(['id','contract_type','payment_mechanism','work_duration']),
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $work_spesification_id)
    {
        $specRequest = WorkRequestSpesification::findOrFail($work_spesification_id);
        $specRequest->delete();

        return redirect()
            ->route('work_request.work_spesifications.edit', ['id' => $id])
            ->with('success', 'Data berhasil dihapus!');
    }
}
