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
    public function store(Request $request, $id)
    {
        $request->validate([
            'work_request_item_id' => 'required',
            'harga' => 'required',
        ]);

        $harga = floatval(str_replace(['.', ','], '', $request->harga));

        $workRequestItem = WorkRequestItem::findOrFail($request->work_request_item_id);
        $totalHarga = bcmul($harga, $workRequestItem->quantity, 2);

        WorkRequestRab::create([
            'work_request_id' => $workRequestItem->work_request_id,
            'work_request_item_id' => $request->work_request_item_id,
            'harga' => $harga,
            'total_harga' => $totalHarga,
        ]);

        return back()->with('success', 'Data berhasil disimpan!');
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
        $workRequest = WorkRequest::findOrFail($id);
        $itemRequest = WorkRequestItem::where('work_request_id', $id)->get();

        $rabRequest = WorkRequestRab::with('workRequestItem')
            ->where('work_request_id', $id)
            ->get();

        return view('pages.work-request.work-request-details.rab.index', compact('workRequest', 'itemRequest', 'rabRequest'));
    }

    public function update(Request $request, $id, $work_rab_id)
    {
        $request->validate([
            'work_request_item_id' => 'required|exists:work_request_items,id',
            'harga' => 'required|numeric',
        ]);

        $rab = WorkRequestRab::findOrFail($work_rab_id);


        $harga = floatval(str_replace(['.', ','], '', $request->harga));

        $workRequestItem = WorkRequestItem::findOrFail($request->work_request_item_id);
        $totalHarga = bcmul($harga, $workRequestItem->quantity, 2);

        $rab->update([
            'work_request_id' => $workRequestItem->work_request_id,
            'work_request_item_id' => $request->work_request_item_id,
            'harga' => $harga,
            'total_harga' => $totalHarga,
        ]);

        return redirect()->route('work_request.work_rabs.edit', ['id' => $id])
            ->with('success', 'Data RAB berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $work_rab_id)
    {
        $itemRequest = WorkRequestRab::where('work_request_id', $id)
            ->where('id', $work_rab_id)
            ->firstOrFail();

        $itemRequest->delete();

        return redirect()->route('work_request.work_rabs.edit', ['id' => $id])->with('success', 'Data berhasil dihapus!');
    }
}
