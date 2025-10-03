<?php

namespace App\Http\Controllers;

use App\Models\DocumentApproval;
use App\Models\WorkRequest;
use App\Models\WorkRequestItem;
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
     * Store/assign harga untuk sebuah WorkRequestItem (tidak membuat entitas lain).
     * - Menerima: work_request_item_id, harga (bisa format rupiah)
     * - Menghitung total_harga = quantity * harga
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'work_request_item_id' => ['required', 'exists:work_request_items,id'],
            'harga' => ['required'],
        ]);

        // Normalizer angka rupiah -> numeric string
        $normalize = function ($v) {
            if (is_null($v)) return '0';
            $v = preg_replace('/[^\d,.\-]/', '', (string)$v);
            if (str_contains($v, ',') && str_contains($v, '.')) {
                $v = str_replace('.', '', $v);
                $v = str_replace(',', '.', $v);
            } else if (str_contains($v, ',') && !str_contains($v, '.')) {
                $v = str_replace(',', '.', $v);
            }
            return $v === '' ? '0' : $v;
        };

        $item = WorkRequestItem::where('work_request_id', $id)
            ->where('id', $request->work_request_item_id)
            ->firstOrFail();

        $harga = (string) $normalize($request->harga);
        $qty   = (string) ($item->quantity ?? 0);

        // total = qty * harga (2 desimal)
        $total = bcmul($qty, $harga, 2);

        $item->update([
            'harga'       => $harga,
            'total_harga' => $total,
        ]);

        return back()->with('success', 'Data berhasil disimpan!');
    }

    /**
     * Display the specified resource (RAB tab).
     * Menampilkan RAB berdasar WorkRequestItem dan total keseluruhannya.
     */
    public function show($id)
    {
        $workRequest = WorkRequest::findOrFail($id);

        // Semua item untuk WR ini
        $itemRequest = WorkRequestItem::where('work_request_id', $id)->get();

        // Total RAB sekarang dari item
        $totalRab = $itemRequest->sum('total_harga');

        $latestApprover = DocumentApproval::where('document_id', $id)
            ->where('status', '!=', '102')
            ->with('approver')
            ->latest('approved_at')
            ->first();

        return view('pages.work-request.work-request-details.rab.show', compact(
            'workRequest',
            'itemRequest',
            'totalRab',
            'latestApprover'
        ));
    }

    /**
     * Show the form for editing the specified resource (RAB tab).
     */
    public function edit($id)
    {
        $workRequest = WorkRequest::findOrFail($id);
        $itemRequest = WorkRequestItem::where('work_request_id', $id)->get();
        $totalRab = $itemRequest->sum('total_harga');

        $latestApprover = DocumentApproval::where('document_id', $id)
            ->where('status', '!=', '102')
            ->with('approver')
            ->latest('approved_at')
            ->first();

        return view('pages.work-request.work-request-details.rab.index', compact(
            'workRequest',
            'itemRequest',
            'totalRab',
            'latestApprover'
        ));
    }

    /**
     * Inline update quantity & harga untuk WorkRequestItem, total_harga otomatis.
     * Mendukung PATCH/PUT (AJAX/form).
     */
    public function update(Request $request, $id, $work_request_item_id)
    {
        $item = WorkRequestItem::where('work_request_id', $id)
            ->where('id', $work_request_item_id)
            ->firstOrFail();
            
        $validated = $request->validate([
            'quantity' => 'required|numeric|min:0',
            'harga'    => 'required|numeric|min:0',
        ]);

        $item->quantity = $validated['quantity'];
        $item->harga = $validated['harga'];
        $item->total_harga = $validated['quantity'] * $validated['harga'];
        $item->save();

        // Hitung ulang total semua item
        $totalRab = WorkRequestItem::where('work_request_id', $id)
            ->sum('total_harga');

        return response()->json([
            'success' => true,
            'totalRab' => $totalRab,
        ]);
    }

    /**
     * Hapus satu baris RAB = hapus WorkRequestItem terkait.
     */
    public function destroy($id, $work_rab_id)
    {
        $item = WorkRequestItem::where('work_request_id', $id)
            ->where('id', $work_rab_id)
            ->firstOrFail();

        $item->delete();

        return redirect()
            ->route('work_request.work_rabs.edit', ['id' => $id])
            ->with('success', 'Data berhasil dihapus!');
    }
}
