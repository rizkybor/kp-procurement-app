<?php

namespace App\Http\Controllers;

use App\Models\DocHistories;
use App\Models\DocumentApproval;
use App\Notifications\InvoiceApprovalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\Notification;
use App\Models\NotificationRecipient;
use App\Notifications\ApprovalNotification;

use Maatwebsite\Excel\Facades\Excel;

use App\Exports\WorkRequestExport;

use App\Models\User;
use App\Models\WorkRequest;
use App\Models\WorkRequestItem;


class WorkRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $workRequest = WorkRequest::all();
        $workRequest = WorkRequest::with('workRequestRab')->get();


        return view('pages.work-request.index', compact('workRequest'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $monthRoman = $this->convertToRoman(date('n'));
        $year = date('Y');

        // Ambil nomor terakhir
        $lastNumber = WorkRequest::max('request_number');
        preg_match('/^(\d{4})/', $lastNumber, $matches);
        $lastNumeric = $matches[1] ?? '0010';
        $nextNumber = $lastNumber ? (intval($lastNumeric) + 10) : 10;

        // Format nomor dokumen
        $numberFormat = sprintf("%04d.FP-KPU-%s-%s", $nextNumber, $monthRoman, $year);

        $today = now()->toDateString();

        return view('pages.work-request.create', compact('numberFormat', 'today'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'work_name_request' => 'required',
            'department' => 'required',
            'project_title' => 'required',
            'project_owner' => 'required',
            'procurement_type' => 'required',
            'contract_number' => 'required',
            'request_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:request_date',
            'pic' => 'required',
            'aanwijzing' => 'required',
            'time_period' => 'nullable',
        ]);

        $monthRoman = $this->convertToRoman(date('n'));
        $year = date('Y');

        // Ambil nomor terakhir
        $lastNumber = WorkRequest::max('request_number');
        preg_match('/^(\d{4})/', $lastNumber, $matches);
        $lastNumeric = $matches[1] ?? '0010';
        $nextNumber = $lastNumber ? (intval($lastNumeric) + 10) : 10;

        // Format nomor dokumen
        $numberFormat = sprintf("%04d.FP-KPU-%s-%s", $nextNumber, $monthRoman, $year);

        $input = $request->all();
        $input['created_by'] = auth()->id();
        $input['request_number'] = $numberFormat;
        $input['status'] = $request->status ?? 0;

        $workRequest = WorkRequest::create($input);

        return redirect()->route('work_request.work_request_items.edit', ['id' => $workRequest->id])
            ->with('success', 'Permintaan kerja berhasil diperbarui.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Ambil data WorkRequest berdasarkan ID
        $workRequest = WorkRequest::findOrFail($id);
        $itemRequest = WorkRequestItem::where('work_request_id', $id)->get();

        // Kirim data ke view
        return view('pages.work-request.work-request-details.request.show', compact('workRequest', 'itemRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkRequest $workRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $workRequest = WorkRequest::find($id);

        if (!$workRequest) {
            return back()->with('error', 'Work request tidak ditemukan.');
        }

        $validatedData = $request->validate([
            'work_name_request' => 'nullable',
            'department' => 'required',
            'project_title' => 'required',
            'project_owner' => 'required',
            'procurement_type' => 'required',
            'contract_number' => 'required',
            'request_date' => 'required|date',
            'deadline' => 'required|date|after_or_equal:request_date',
            'pic' => 'required',
            'aanwijzing' => 'required',
            'time_period' => 'nullable',
        ]);

        $workRequest->update($validatedData);

        return redirect()->route('work_request.work_request_items.edit', ['id' => $workRequest->id])
            ->with('success', 'Work request berhasil diperbarui.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $workRequest = WorkRequest::find($id);
        $workRequest->delete();

        return redirect()->route('work_request.index')->with('success', 'Data berhasil dihapus!');
    }

    private function convertToRoman($month)
    {
        $romans = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];
        return $romans[$month - 1];
    }

    public function export(Request $request)
    {
        $ids = $request->query('ids');

        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih untuk diexport.');
        }

        return Excel::download(new WorkRequestExport($ids), 'work_request_documents.xlsx');
    }

    /**
     * Proses Document with Approval Level
     */
    public function processApproval(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $document = WorkRequest::findOrFail($id);
            $user = Auth::user();
            $userRole = $user->role;
            $department = $user->department;
            $previousStatus = $document->status;
            $currentRole = optional($document->latestApproval)->approver_role ?? 'maker';
            $message = $request->input('messages');

            // 🔹 1️⃣ Validasi: Apakah dokumen sudah di tahap akhir approval?
            if ($document->last_reviewers === 'pajak') {
                return back()->with('info', "Dokumen ini sudah berada di tahap akhir approval.");
            }

            // 🔹 2️⃣ Cek apakah dokumen dalam status revisi
            $isRevised = $document->status === '102';

            // 🔹 3️⃣  Jika revisi, lewati validasi karena `userRole` dan `currentRole` pasti berbeda
            if (!$isRevised && (!$userRole || $userRole !== $currentRole)) {
                return back()->with('error', "Anda tidak memiliki izin untuk menyetujui dokumen ini.");
            }

            $nextRole = null;
            $nextApprovers = collect();
            if ($isRevised) {
                // 🔹 4️⃣ Ambil APPROVER TERAKHIR secara keseluruhan
                $lastApprover = DocumentApproval::where('document_id', $document->id)
                    ->where('document_type', WorkRequest::class)
                    ->latest('approved_at') // Urutkan berdasarkan waktu approval terbaru
                    ->first();

                if (!$lastApprover) {
                    return back()->with('error', "Gagal mengembalikan dokumen revisi: Approver sebelumnya tidak ditemukan.");
                }

                $nextRole = $lastApprover->approver_role;
                $nextApprovers = User::where('role', $nextRole)->get();
            } else {
                // 🔹 5️⃣ Jika bukan revisi, tentukan ROLE BERIKUTNYA seperti biasa
                $nextRole = $this->getNextApprovalRole($currentRole, $department, $isRevised);
                if (!$nextRole) {
                    return back()->with('info', "Dokumen ini sudah berada di tahap akhir approval.");
                }

                // 🔹 6️⃣ Ambil user dengan role berikutnya
                $nextApprovers = User::where('role', $nextRole)
                    ->when($nextRole === 'kadiv', function ($query) use ($department) {
                        return $query->whereRaw("LOWER(department) = ?", [strtolower($department)]);
                    })
                    ->get();
            }

            if ($nextApprovers->isEmpty()) {
                Log::warning("Approval gagal: Tidak ada user dengan role {$nextRole} untuk dokumen ID {$document->id}");
                return back()->with('error', "Tidak ada user dengan role {$nextRole}" .
                    ($nextRole === 'kadiv' ? " di departemen {$department}." : "."));
            }

            // 🔹 7️⃣ Ambil status dokumen berdasarkan nextRole
            $statusCode = array_search($nextRole, $this->approvalStatusMap());

            if ($statusCode === false) {
                Log::warning("Approval Status Map tidak mengenali role: {$nextRole}");
                $statusCode = 'unknown';
            }

            // 🔹 8️⃣ Simpan approval untuk user berikutnya
            foreach ($nextApprovers as $nextApprover) {
                DocumentApproval::create([
                    'document_id'    => $document->id,
                    'document_type'  => WorkRequest::class,
                    'approver_id'    => $nextApprover->id,
                    'approver_role'  => $nextRole,
                    'submitter_id'   => $document->created_by,
                    'submitter_role' => $userRole,
                    'status'         => (string) $statusCode,
                    'approved_at'    => now(),
                ]);
            }

            // 🔹 9️⃣ Perbarui status dokumen
            $document->update([
                'last_reviewers' => $nextRole,
                'status'         => (string) $statusCode,
            ]);

            // 🔹 🔟 Simpan ke History
            DocHistories::create([
                'document_id'     => $document->id,
                'performed_by'    => $user->id,
                'role'            => $userRole,
                'previous_status' => $previousStatus,
                'new_status'      => (string) $statusCode,
                'action'          => $isRevised ? 'Revised Approval' : 'Approved',
                'notes'           => $message ? "{$message}." : "Dokumen diproses oleh {$user->name}.",
            ]);

            // 🔹 🔟 Kirim Notifikasi
            $notification = Notification::create([
                'type'            => InvoiceApprovalNotification::class,
                'notifiable_type' => WorkRequest::class,
                'notifiable_id'   => $document->id,
                'messages'        => $message
                    ? "{$message}. Lihat detail: " . route('management-fee.show', $document->id)
                    : "Dokumen diproses oleh {$user->name}.",
                'sender_id'       => $user->id,
                'sender_role'     => $userRole,
                'read_at'         => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            // 🔹 🔟 Kirim notifikasi ke setiap user dengan role berikutnya
            foreach ($nextApprovers as $nextApprover) {
                NotificationRecipient::create([
                    'notification_id' => $notification->id,
                    'user_id'         => $nextApprover->id,
                    'read_at'         => null,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }

            DB::commit();

            return back()->with('success', "Dokumen telah " . ($isRevised ? "dikembalikan ke {$nextRole} sebagai revisi" : "disetujui dan diteruskan ke {$nextRole}."));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error saat approval dokumen [ID: {$id}]: " . $e->getMessage());
            return back()->with('error', "Terjadi kesalahan saat memproses approval.");
        }
    }

    /**
     * Fungsi untuk mendapatkan role berikutnya dalam flowchart.
     */
    private function getNextApprovalRole($currentRole, $department = null, $isRevised = false)
    {
        // Jika dokumen direvisi, kembalikan ke role sebelumnya
        if ($isRevised) {
            return $currentRole; // Kembali ke atasan yang meminta revisi
        }

        // Alur approval normal
        if ($currentRole === 'maker' && $department) {
            return 'kadiv';
        }

        $flow = [
            'kadiv'               => 'pembendaharaan',
            'pembendaharaan'      => 'manager_anggaran',
            'manager_anggaran'    => 'direktur_keuangan',
            'direktur_keuangan'   => 'pajak',
            'pajak'               => 'pembendaharaan'
        ];

        return $flow[$currentRole] ?? null;
    }

    /**
     * Mapping Status Approval dengan angka
     */
    private function approvalStatusMap()
    {
        return [
            '0'   => 'draft',
            '1'   => 'kadiv',
            '2'   => 'pembendaharaan',
            '3'   => 'manager_anggaran',
            '4'   => 'direktur_keuangan',
            '5'   => 'pajak',
            '6'   => 'done',
            '100' => 'finished', // status belum digunakan
            '101' => 'canceled', // status belum digunakan
            '102' => 'revised',
            '103'  => 'rejected',
        ];
    }

    /**
     * Untuk button revision
     */
    public function processRevision(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $document = WorkRequest::findOrFail($id);
            $user = Auth::user();
            $userRole = $user->role;
            $currentRole = $document->latestApproval->approver_role ?? 'maker';
            $message = $request->input('messages');

            // 🔹 1️⃣ Validasi: Pastikan user memiliki hak revisi
            if ($userRole !== $currentRole) {
                return back()->with('error', "Anda tidak memiliki izin untuk merevisi dokumen ini.");
            }

            // 🔹 2️⃣ Ambil Approver Terakhir yang Merevisi Sebagai Target Approver
            $lastReviser = DocumentApproval::where('document_id', $document->id)
                ->where('document_type', WorkRequest::class)
                ->where('status', '102') // Ambil approval yang terakhir kali merevisi
                ->latest('approved_at')
                ->first();

            $targetApproverId = $lastReviser->approver_id ?? $document->created_by;
            $targetApprover = User::find($targetApproverId);
            $targetApproverRole = $targetApprover->role ?? 'maker';



            // 🔹 4️⃣ Simpan revisi ke dalam log approval (Pastikan tidak ada duplikasi)
            DocumentApproval::updateOrCreate(
                [
                    'document_id'   => $document->id,
                    'document_type' => WorkRequest::class,
                    'approver_id'   => $user->id,
                ],
                [
                    'role'         => $userRole,
                    'status'       => $document->status,
                    'approved_at'  => now(),
                ]
            );

            // 🔹 3️⃣ Update status dokumen menjadi "Revisi Selesai (102)" dan set approver terakhir
            $document->update([
                'status'         => '102',
                'last_reviewers' => $userRole,
            ]);

            // 🔹 5️⃣ Simpan riwayat revisi di `ManfeeDocHistories`
            DocHistories::create([
                'document_id'     => $document->id,
                'performed_by'    => $user->id,
                'role'            => $userRole,
                'previous_status' => $document->status,
                'new_status'      => '102',
                'action'          => 'Revised',
                'notes'           => "Dokumen direvisi oleh {$user->name} dan dikembalikan ke {$targetApprover->name}.",
            ]);

            // 🔹 6️⃣ Kirim Notifikasi ke Approver yang Merevisi Sebelumnya
            if ($targetApprover) {
                $notification = Notification::create([
                    'type'            => ApprovalNotification::class,
                    'notifiable_type' => WorkRequest::class,
                    'notifiable_id'   => $document->id,
                    'messages'        =>  $message
                        ? "{$message}. Lihat detail: " . route('management-fee.show', $document->id)
                        : "Dokumen diproses oleh {$user->name}.",
                    'sender_id'       => $user->id,
                    'sender_role'     => $userRole,
                    'read_at'         => null,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);

                // 🔹 7️⃣ Tambahkan ke Notifikasi Recipient
                NotificationRecipient::create([
                    'notification_id' => $notification->id,
                    'user_id'         => $targetApprover->id,
                    'read_at'         => null,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }

            DB::commit();
            return back()->with('success', "Dokumen telah dikembalikan ke {$targetApprover->name} untuk pengecekan ulang.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error saat merevisi dokumen [ID: {$id}]: " . $e->getMessage());
            return back()->with('error', "Terjadi kesalahan saat mengembalikan dokumen untuk revisi.");
        }
    }
}
