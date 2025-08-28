<?php

namespace App\Http\Controllers;

use App\Models\WorkRequest;
use Illuminate\Http\Request;

class WorkRequestVendorController extends Controller
{
    // List vendor yang terkait dengan WR tertentu
    public function index(WorkRequest $workRequest)
    {
        return response()->json(
            $workRequest->vendors()->orderBy('vendors.nama_perusahaan')->get()
        );
    }

    // Tambah relasi (attach) satu/lebih vendor ke WR
    public function attach(Request $request, WorkRequest $workRequest)
    {
        $data = $request->validate([
            'vendor_ids' => ['required','array','min:1'],
            'vendor_ids.*' => ['integer','exists:vendors,id'],
        ]);

        $workRequest->vendors()->syncWithoutDetaching($data['vendor_ids']);

        return response()->json([
            'message' => 'Vendors attached',
            'vendors' => $workRequest->vendors()->get(),
        ]);
    }

    // Hapus relasi (detach) satu/lebih vendor dari WR
    public function detach(Request $request, WorkRequest $workRequest)
    {
        $data = $request->validate([
            'vendor_ids' => ['required','array','min:1'],
            'vendor_ids.*' => ['integer','exists:vendors,id'],
        ]);

        $workRequest->vendors()->detach($data['vendor_ids']);

        return response()->json([
            'message' => 'Vendors detached',
            'vendors' => $workRequest->vendors()->get(),
        ]);
    }

    // Sinkron relasi (replace semua vendors milik WR)
    public function sync(Request $request, WorkRequest $workRequest)
    {
        $data = $request->validate([
            'vendor_ids' => ['required','array'],
            'vendor_ids.*' => ['integer','exists:vendors,id'],
        ]);

        $workRequest->vendors()->sync($data['vendor_ids']);

        return response()->json([
            'message' => 'Vendors synced',
            'vendors' => $workRequest->vendors()->get(),
        ]);
    }
}