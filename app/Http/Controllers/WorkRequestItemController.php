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
    public function store(Request $request, $id)
    {
        $request->validate([
            'item_desc_request' => 'required',
            'notes' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
        ]);

        // Simpan ke database
        WorkRequestItem::create([
            'work_request_id' => $id,
            'item_desc_request' => $request->item_desc_request,
            'notes' => $request->notes,
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

        // Kirim data ke view
        return view('pages.work-request.work-request-details.request.index', compact('workRequest', 'itemRequest'));
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
    public function destroy($id, $work_request_item_id)
    {

        $itemRequest = WorkRequestItem::where('work_request_id', $id)
            ->where('id', $work_request_item_id)
            ->firstOrFail();

        $itemRequest->delete();

        return redirect()->route('work_request.work_request_items.edit', ['id' => $id])->with('success', 'Data berhasil dihapus!');
    }
}
