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
        dd('test');
        $request->validate([
            'files'   => ['required', 'array', 'min:1'],
            'files.*' => ['file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,zip,rar', 'max:10240'],
            'note'    => ['nullable', 'string', 'max:500'],
        ], [
            'files.required' => 'Pilih minimal satu file.',
            'files.*.mimes'  => 'Format file tidak didukung.',
            'files.*.max'    => 'Ukuran maksimum tiap file 10MB.',
        ]);

        $wr  = WorkRequest::findOrFail($id);

        // Pastikan spesification record ada
        $spec = WorkRequestSpesification::firstOrCreate(
            ['work_request_id' => $wr->id],
            ['scope_of_work' => null, 'contract_type' => null, 'payment_procedures' => null]
        );

        // Disk & folder tujuan (SELALU di storage/app/public/...)
        $disk = 'public'; // pastikan sudah php artisan storage:link jika ingin URL publik
        /** @var FilesystemAdapter $fs */
        $fs = Storage::disk($disk);

        // Struktur folder: public/spesification_files/YYYY/MM/DD
        $date   = now();
        $folder = sprintf('spesification_files/%s/%s/%s', $date->format('Y'), $date->format('m'), $date->format('d'));

        foreach ($request->file('files') as $uploaded) {
            $originalName = $uploaded->getClientOriginalName();
            $ext          = strtolower($uploaded->getClientOriginalExtension());
            $size         = (int) $uploaded->getSize(); // bytes

            // Nama file rapi + unik: 2025-08-23_WR-15_slug-50_{8char}.ext
            $base   = $this->buildBaseName($wr->id, pathinfo($originalName, PATHINFO_FILENAME));
            $suffix = substr(Str::uuid()->toString(), 0, 8);
            $storedName = "{$base}_{$suffix}.{$ext}";

            // Simpan file
            $path = $uploaded->storeAs($folder, $storedName, $disk); // hasil path: spesification_files/2025/08/23/....

            // Catat metadata
            WorkRequestSpesificationFile::create([
                'work_request_spesification_id' => $spec->id,
                'file_name'     => $storedName,
                'original_name' => $originalName,
                'extension'     => $ext,
                'size'          => $size,
                'path'          => $path, // contoh: spesification_files/2025/08/23/2025-08-23_WR-15_rab-pipeline_ab12cd34.pdf
                'uploaded_by'   => optional(auth()->user())->id,
                'note'          => $request->note,
            ]);
        }

        return back()->with('success', 'File spesification berhasil diupload.');
    }

    /**
     * Bangun base name yang rapi dari WR id + slug nama file.
     * Contoh output: "2025-08-23_WR-15_rab-pipeline"
     */
    private function buildBaseName(int|string $workRequestId, string $rawName): string
    {
        $slug = Str::slug($rawName, '-');
        if (strlen($slug) > 50) {
            $slug = substr($slug, 0, 50);
        }
        return now()->format('Y-m-d') . '_WR-' . $workRequestId . '_' . $slug;
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

        /** @var FilesystemAdapter $fs */
        $fs = Storage::disk($disk);
        return $fs->download($file->path, $file->original_name);
    }

    /**
     * Hapus file + berkas fisiknya.
     * DELETE /work-request/{workRequestId}/spesification-files/{file}
     */
    public function destroy($workRequestId, WorkRequestSpesificationFile $file)
    {
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