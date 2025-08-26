<?php

namespace App\Http\Controllers;

use App\Models\WorkRequest;
use App\Models\WorkRequestSpesification;
use App\Models\WorkRequestSpesificationFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Filesystem\FilesystemAdapter;

class WorkRequestSpesificationFileController extends Controller
{
    /**
     * Simpan banyak file spesification untuk 1 Work Request.
     * POST /work-request/{id}/spesification-files
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,zip,rar', 'max:10240'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $wr = WorkRequest::findOrFail($id);

            // Pastikan spesification record ada
            $spec = WorkRequestSpesification::firstOrCreate(
                ['work_request_id' => $wr->id],
                ['scope_of_work' => null, 'contract_type' => null, 'payment_procedures' => null]
            );

            // Simpan file ke storage/public/spesification-files
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/spesification-files', $fileName);
            $relativePath = 'spesification-files/' . $fileName;


            // Simpan metadata sederhana ke tabel
            WorkRequestSpesificationFile::create([
                'work_request_spesification_id' => $spec->id,
                'file_name'     => $fileName,
                'original_name' => $file->getClientOriginalName(),
                'extension'     => $file->getClientOriginalExtension(),
                'size'          => $file->getSize(),
                'uploaded_by'   => optional(auth()->user())->id,
                'description'          => $request->description,
                'path'          => $relativePath
            ]);

            return back()->with('success', 'File spesification berhasil diupload.');
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors(['file' => 'Upload gagal. ' . $e->getMessage()]);
        }
    }

    /**
     * Unduh file.
     * GET /work-request/spesification-files/{file}
     */
    public function download(WorkRequestSpesificationFile $file)
    {
        $path = storage_path('app/public/' . $file->path);

        if (!file_exists($path)) {
            return back()->with('error', 'File tidak ditemukan di storage.');
        }

        return response()->download($path, $file->original_name);
    }

    /**
     * Hapus file + berkas fisiknya.
     * DELETE /work-request/{workRequestId}/spesification-files/{file}
     */
    public function destroy($id, WorkRequestSpesificationFile $file)
    {
        // Pastikan file memang milik WorkRequest terkait
        abort_unless($file->spesification?->work_request_id == $id, 404);

        // Lokasi fisik file di server
        $path = storage_path('app/public/' . $file->path);

        // Hapus file fisik jika ada
        if ($file->path && file_exists($path)) {
            @unlink($path); // gunakan unlink untuk hapus fisik
        }

        // Hapus record dari database
        $file->delete();

        return back()->with('success', 'File berhasil dihapus.');
    }
}
