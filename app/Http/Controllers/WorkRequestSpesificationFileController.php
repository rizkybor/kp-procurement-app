<?php

namespace App\Http\Controllers;

use App\Models\WorkRequest;
use App\Models\WorkRequestSpesification;
use App\Models\WorkRequestSpesificationFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WorkRequestSpesificationFileController extends Controller
{
    /**
     * Simpan banyak file spesification untuk 1 Work Request.
     * POST /work-request/{id}/spesification-files
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'files'   => ['required', 'array', 'min:1'],
            'files.*' => ['file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,zip,rar', 'max:10240'],
            'note'    => ['nullable', 'string', 'max:500'],
        ], [
            'files.required' => 'Pilih minimal satu file.',
            'files.*.mimes'  => 'Format file tidak didukung.',
            'files.*.max'    => 'Ukuran maksimum tiap file 10MB.',
        ]);

        $wr = WorkRequest::findOrFail($id);

        // Pastikan spesification record ada
        $spec = WorkRequestSpesification::firstOrCreate(
            ['work_request_id' => $wr->id],
            ['scope_of_work' => null, 'contract_type' => null, 'payment_procedures' => null]
        );

        $disk = 'public';                                   // sesuaikan dengan filesystems.php
        $basePath = "work-request/{$wr->id}/spesification"; // direktori penyimpanan

        foreach ($request->file('files') as $uploaded) {
            $original = $uploaded->getClientOriginalName();
            $ext      = strtolower($uploaded->getClientOriginalExtension());
            $size     = (int) $uploaded->getSize(); // bytes
            $stored   = Str::uuid()->toString() . '.' . $ext;

            // Simpan file
            $path = $uploaded->storeAs($basePath, $stored, $disk);

            // Catat metadata
            WorkRequestSpesificationFile::create([
                'work_request_spesification_id' => $spec->id,
                'file_name'     => $stored,
                'original_name' => $original,
                'extension'     => $ext,
                'size'          => $size,
                'path'          => $path,
                'uploaded_by'   => optional(auth()->user())->id,
                'note'          => $request->note,
            ]);
        }

        return back()->with('success', 'File spesification berhasil diupload.');
    }

    /**
     * Unduh file.
     * GET /work-request/spesification-files/{file}
     */
    public function download(WorkRequestSpesificationFile $file)
    {
        $disk = 'public';

        if (!Storage::disk($disk)->exists($file->path)) {
            return back()->with('error', 'File tidak ditemukan di storage.');
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $fs */
        $fs = Storage::disk($disk);

        return $fs->download($file->path, $file->original_name);
    }

    /**
     * Hapus file + berkas fisiknya.
     * DELETE /work-request/{workRequestId}/spesification-files/{file}
     */
    public function destroy($workRequestId, WorkRequestSpesificationFile $file)
    {
        // Pastikan file memang milik WR tsb
        if ((int) $file->spesification?->work_request_id !== (int) $workRequestId) {
            abort(404);
        }

        $disk = 'public';

        if ($file->path && Storage::disk($disk)->exists($file->path)) {
            Storage::disk($disk)->delete($file->path);
        }

        $file->delete();

        return back()->with('success', 'File berhasil dihapus.');
    }
}
