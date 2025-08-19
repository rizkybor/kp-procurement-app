<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Notifications\ApprovalNotification;

use App\Models\User;
use App\Models\DocHistories;
use App\Models\DocumentApproval;
use App\Models\WorkRequest;
use App\Models\WorkRequestItem;
use App\Models\WorkRequestRab;
use App\Models\Notification;
use App\Models\NotificationRecipient;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WorkRequestExport;

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

        $rabRequest = WorkRequestRab::with('workRequestItem')
            ->where('work_request_id', $id)
            ->get();

        $totalRab = $rabRequest->sum('total_harga');

        $latestApprover = DocumentApproval::where('document_id', $id)
            ->where('status', '!=', '102') // Abaikan status revisi jika perlu
            ->with('approver')
            ->latest('approved_at')
            ->first();

        // Kirim data ke view
        return view('pages.work-request.work-request-details.request.show', compact('workRequest', 'itemRequest', 'totalRab', 'latestApprover'));
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

            // Jika dokumen sebelumnya direvisi (status 102), reset alur ke maker/manager
            if ($previousStatus == '102') {
                $currentRole = 'maker'; // Atau 'manager' tergantung alur awal
            }

            // Validasi dokumen final
            // if ($document->last_reviewers === 'fungsi_pengadaan') {
            //     return back()->with('info', "Dokumen ini sudah final.");
            // }

            // Tentukan next role
            $nextRole = $this->getNextApprovalRole($currentRole, $user->department, false, $document->total_rab);

            // Dapatkan status code
            $statusCode = array_search($nextRole, $this->approvalStatusMap());
            if ($statusCode === false) {
                $statusCode = '1'; // Default ke manager approval
            }

            // Jika status sama, cari status berikutnya
            if ($previousStatus == $statusCode) {
                $nextRole = $this->getNextApprovalRole($nextRole, $user->department, false, $document->total_rab);
                if ($nextRole) {
                    $statusCode = array_search($nextRole, $this->approvalStatusMap());
                }
            }

            // Mendapatkan name
            $approvalMap = $this->approvalStatusMap();
            $nextRoleName = $approvalMap[$statusCode] ?? 'unknown';

            $nextApprovers = User::where('role', $nextRole)
                ->when($nextRole === 'manager', function ($query) use ($department) {
                    return $query->whereRaw("LOWER(department) = ?", [strtolower($department)]);
                })
                ->get();

            // Simpan approval
            DocumentApproval::create([
                'document_id' => $document->id,
                'document_type' => WorkRequest::class,
                'approver_id' => $user->id,
                'approver_role' => $userRole,
                'submitter_id' => $document->created_by,
                'submitter_role' => 'maker',
                'status' => $statusCode,
                'approved_at' => now(),
            ]);

            // Update dokumen
            $document->update([
                'last_reviewers' => $nextRoleName,
                'status' => $statusCode,
            ]);

            // Simpan history
            DocHistories::create([
                'document_id' => $document->id,
                'performed_by' => $user->id,
                'role' => $userRole,
                'previous_status' => $previousStatus,
                'new_status' => $statusCode,
                'action' => 'Approved',
                'notes' => $request->messages ?? "Dokumen diapprove oleh " . ucfirst(str_replace('_', ' ', $userRole)),
            ]);

            // 🔹 🔟 Kirim Notifikasi
            $notification = Notification::create([
                'type' => ApprovalNotification::class,
                'notifiable_type' => WorkRequest::class,
                'notifiable_id' => $document->id,
                'messages' => $message
                    ? "{$message}. Lihat detail: " . route('work_request.work_request_items.show', $document->id)
                    : "Dokumen telah disetujui oleh {$user->name}. Lihat detail: " . route('work_request.work_request_items.show', $document->id),
                'sender_id' => $user->id,
                'sender_role' => $userRole,
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 🔹 🔟 Kirim notifikasi ke setiap user dengan role berikutnya
            foreach ($nextApprovers as $nextApprover) {
                NotificationRecipient::create([
                    'notification_id' => $notification->id,
                    'user_id' => $nextApprover->id,
                    'read_at' => null,
                ]);
            }

            DB::commit();
            return back()->with('success', "Dokumen berhasil diapprove dan dikirim ke {$nextRoleName}");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Approval error: " . $e->getMessage());
            return back()->with('error', "Gagal memproses approval");
        }
    }

    /**
     * Fungsi untuk mendapatkan role berikutnya dalam flowchart.
     */
    // private function getNextApprovalRole($currentRole, $department = null, $isRevised = false, $totalRab = 0)
    // {
    //     // Jika dokumen direvisi, kembalikan ke role awal (maker/manager)
    //     if ($isRevised || $currentRole === 'revised') {
    //         return 'maker'; // Atau 'manager' tergantung alur awal
    //     }

    //     // Alur untuk maker (selalu ke manager)
    //     if ($currentRole === 'maker') {
    //         return 'manager';
    //     }
    //     // Definisikan alur approval
    //     $highValueFlow = [
    //         'manager' => 'direktur_utama',
    //         'direktur_utama' => 'fungsi_pengadaan',
    //         'fungsi_pengadaan' => 'done' // Final step
    //     ];

    //     $normalFlow = [
    //         'manager' => 'direktur_keuangan',
    //         'direktur_keuangan' => 'fungsi_pengadaan',
    //         'fungsi_pengadaan' => 'done' // Final step
    //     ];

    //     // Pilih alur berdasarkan totalRab
    //     $selectedFlow = ($totalRab > 500000000) ? $highValueFlow : $normalFlow;

    //     // Pastikan current role ada dalam alur yang dipilih
    //     if (!array_key_exists($currentRole, $selectedFlow)) {
    //         return null;
    //     }

    //     return $selectedFlow[$currentRole];
    // }

    /**
     * Fungsi untuk mendapatkan role berikutnya single flow.
     */
    private function getNextApprovalRole($currentRole, $department = null, $isRevised = false, $totalRab = 0)
    {
        // Jika dokumen direvisi, kembalikan ke role awal (maker/manager)
        if ($isRevised || $currentRole === 'revised') {
            return 'maker'; // Atau 'manager' tergantung alur awal
        }

        // Alur untuk maker (selalu ke manager)
        if ($currentRole === 'maker') {
            return 'manager';
        }

        $singleFlow = [
            'manager' => 'direktur_keuangan',
            'direktur_keuangan' => 'fungsi_pengadaan',
            'fungsi_pengadaan' => 'done'
        ];

        // Pilih Flow Single
        $selectedFlow = $singleFlow;


        // Pastikan current role ada dalam alur yang dipilih
        if (!array_key_exists($currentRole, $selectedFlow)) {
            return null;
        }

        return $selectedFlow[$currentRole];
    }

    /**
     * Mapping Status Approval dengan angka
     */
    private function approvalStatusMap()
    {
        return [
            '0'   => 'draft',               // Draft status
            '1'   => 'manager',             // Manager approval
            '2'   => 'direktur_keuangan', // Finance approval
            '3'   => 'direktur_utama',      // Director approval (only for RAB > 500jt)
            '4'   => 'fungsi_pengadaan',    // Procurement final approval
            '5'   => 'done',                // Completed status
            '100' => 'finished',            // Fully completed (optional)
            '101' => 'canceled',            // Canceled status
            '102' => 'revised',             // Document in revision
            '103' => 'rejected'             // Rejected status
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
            $currentRole = optional($document->latestApproval)->approver_role ?? 'maker';
            $message = $request->input('messages');

            // // Validate user has revision rights
            // if ($userRole !== $currentRole) {
            //     return back()->with('error', "Anda tidak memiliki izin untuk merevisi dokumen ini.");
            // }

            // Find the previous approver to return the document to
            $previousApproval = DocumentApproval::where('document_id', $document->id)
                ->where('document_type', WorkRequest::class)
                ->where('approver_id', '!=', $user->id)
                ->orderBy('approved_at', 'desc')
                ->first();

            // Default to document creator if no previous approval found
            // $targetApproverId = $previousApproval->approver_id ?? $document->created_by;
            $targetApproverId = $document->created_by;
            $targetApprover = User::findOrFail($targetApproverId);

            // Create revision approval record
            DocumentApproval::create([
                'document_id' => $document->id,
                'document_type' => WorkRequest::class,
                'approver_id' => $user->id,
                'approver_role' => $userRole,
                'submitter_id' => $document->created_by,
                'submitter_role' => 'maker',
                'status' => '102', // Revised status
                'approved_at' => now(),
            ]);

            // Update document status
            $document->update([
                'status' => '102',
                'last_reviewers' => $userRole,
            ]);

            // Save to history
            DocHistories::create([
                'document_id' => $document->id,
                'performed_by' => $user->id,
                'role' => $userRole,
                'previous_status' => $document->status,
                'new_status' => '102',
                'action' => 'Revised',
                'notes' => $message ?: "Dokumen direvisi oleh {$user->name} dan dikembalikan ke {$targetApprover->name}",
            ]);

            // Send notification
            $notification = Notification::create([
                'type' => ApprovalNotification::class,
                'notifiable_type' => WorkRequest::class,
                'notifiable_id' => $document->id,
                'messages' => $message
                    ? "{$message}. Lihat detail: " . route('work_request.work_request_items.show', $document->id)
                    : "Dokumen diproses oleh {$user->name}.",
                'sender_id' => $user->id,
                'sender_role' => $userRole,
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            NotificationRecipient::create([
                'notification_id' => $notification->id,
                'user_id' => $targetApprover->id,
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return back()->with('success', "Dokumen berhasil dikembalikan ke {$targetApprover->name} untuk revisi.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Revision failed for document {$id}: " . $e->getMessage());
            return back()->with('error', "Gagal memproses revisi: " . $e->getMessage());
        }
    }

    public function rejected(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            // 'file' => 'required|file|mimes:pdf|max:10240',
        ]);

        $document = WorkRequest::findOrFail($id);
        $user = auth()->user(); // Ambil user yang sedang login
        $userRole = $user->role;
        $previousStatus = $document->status;

        // Ambil file dan nama untuk diupload
        // $file = $request->file('file');
        // $fileName = 'Pembatalan ' . $document->letter_subject;
        // $dropboxFolderName = '/rejected/';

        // Upload ke Dropbox
        // $dropboxController = new DropboxController();
        // $dropboxPath = $dropboxController->uploadAttachment($file, $fileName, $dropboxFolderName);

        // if (!$dropboxPath) {
        //     return back()->with('error', 'Gagal mengunggah file penolakan.');
        // }

        // Update dokumen
        $document->update([
            'reason_rejected' => $request->reason,
            'status'          => 103,
            // 'path_rejected'   => $dropboxPath,
        ]);

        // Simpan ke riwayat
        DocHistories::create([
            'document_id'     => $document->id,
            'performed_by'    => $user->id,
            'role'            => $userRole,
            'previous_status' => $previousStatus,
            'new_status'      => '103',
            'action'          => 'Rejected',
            'notes'           => "Dokumen dibatalkan oleh {$user->name} dengan alasan: {$request->reason}",
        ]);

        return redirect()->route('work_request.work_request_items.show', ['id' => $document->id])
            ->with('success', 'Work request berhasil diperbarui.');
    }
}
