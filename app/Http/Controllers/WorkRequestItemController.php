<?php

namespace App\Http\Controllers;

use App\Models\DocumentApproval;
use App\Models\WorkRequestItem;
use App\Models\WorkRequest;
use Illuminate\Http\Request;
use App\Models\MstKeproyekan;
use App\Models\MstTypeProcurement;

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
    public function store(Request $request, $id)
    {
        $request->validate([
            'item_name' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
        ]);

        // Simpan ke database
        WorkRequestItem::create([
            'work_request_id' => $id,
            'item_name' => $request->item_name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
        ]);

        return redirect()->route('work_request.work_request_items.edit', ['id' => $id])->with('success', 'Data berhasil disimpan!');
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
        $itemRequest = WorkRequestItem::where('work_request_id', $id)->get();

        $latestApprover = DocumentApproval::where('document_id', $id)
            ->where('status', '!=', '102') // Abaikan status revisi jika perlu
            ->with('approver')
            ->latest('approved_at')
            ->first();

               $keproyekanList = MstKeproyekan::all();
        $typeProcurementList = MstTypeProcurement::all();

        // Kirim data ke view
        return view('pages.work-request.work-request-details.request.index', compact('workRequest', 'keproyekanList', 'typeProcurementList', 'itemRequest', 'latestApprover'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $work_request_id, $work_request_item_id)
    {
        // Validasi input
        $request->validate([
            'item_name' => 'required',
            'description' => 'required',
            'quantity' => 'required|numeric',
            'unit' => 'required',
        ]);

        $docdetail = WorkRequestItem::where('work_request_id', $work_request_id)
            ->where('id', $work_request_item_id)
            ->firstOrFail();

        $docdetail->update([
            'item_name' => $request->item_name,
            'description' => $request->description,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
        ]);

        // Redirect ke halaman edit dengan work_request_id
        return redirect()->route('work_request.work_request_items.edit', ['id' => $work_request_id])
            ->with('success', 'Data berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $work_request_item_id)
    {

        $itemRequest = WorkRequestItem::where('work_request_id', $id)
            ->where('id', $work_request_item_id)
            ->firstOrFail();

        $itemRequest->delete();

        return redirect()->route('work_request.work_request_items.edit', ['id' => $id])->with('success', 'Data berhasil dihapus!');
    }
}
