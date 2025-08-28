<?php

namespace App\Http\Controllers;

use App\Models\OrderCommunication;
use App\Models\WorkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderCommunicationController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        // Dapatkan work request berdasarkan ID
        $workRequests = WorkRequest::findOrFail($id);

        // Cari atau buat data OrderCommunication dengan nilai default
        $orderCommunication = OrderCommunication::firstOrCreate(
            ['work_request_id' => $id],
            [
                'work_request_id' => $id,
                'company_name' => '-',
                'company_address' => '-',
                'company_goal' => '-',
                'no_applicationletter' => $this->generateDocumentNumber('application', $id),
                'no_evaluationletter' => $this->generateDocumentNumber('evaluation', $id),
                'no_negotiationletter' => $this->generateDocumentNumber('negotiation', workRequestId: $id),
                'no_beritaacaraklarifikasi' => $this->generateDocumentNumber('beritaacara', $id),
                'no_suratpenunjukan' => $this->generateDocumentNumber('suratpenunjukan', $id),
            ]
        );

        // Jika record sudah ada tetapi nomor dokumen masih kosong, generate nomor
        if ($orderCommunication->wasRecentlyCreated === false) {
            if (empty($orderCommunication->no_applicationletter)) {
                $orderCommunication->no_applicationletter = $this->generateDocumentNumber('application', $id);
            }
            if (empty($orderCommunication->no_evaluationletter)) {
                $orderCommunication->no_evaluationletter = $this->generateDocumentNumber('evaluation', $id);
            }
            if (empty($orderCommunication->no_negotiationletter)) {
                $orderCommunication->no_negotiationletter = $this->generateDocumentNumber('negotiation', $id);
            }

            // Simpan jika ada perubahan
            if ($orderCommunication->isDirty()) {
                $orderCommunication->save();
            }
        }

        // Data dummy vendor
        $vendors = [
            [
                'id' => '1',
                'name' => 'PT. Vendor Contoh 1',
                'address' => 'Jl. Contoh Alamat No. 123',
                'type' => 'Penyedia Barang'
            ],
            [
                'id' => '2',
                'name' => 'CV. Mitra Jaya',
                'address' => 'Jl. Raya Bogor No. 45',
                'type' => 'Penyedia Jasa'
            ],
            [
                'id' => '3',
                'name' => 'PT. Sumber Rejeki',
                'address' => 'Jl. Gatot Subroto No. 78',
                'type' => 'Penyedia Barang & Jasa'
            ],
            [
                'id' => '4',
                'name' => 'PT. Teknologi Maju',
                'address' => 'Jl. Sudirman No. 10',
                'type' => 'Penyedia Jasa IT'
            ],
            [
                'id' => '5',
                'name' => 'UD. Jaya Abadi',
                'address' => 'Jl. Pasar Minggu No. 25',
                'type' => 'Penyedia Barang'
            ]
        ];

        return view(
            'pages.work-request.work-request-details.order-communication.index',
            compact('workRequests', 'vendors', 'orderCommunication')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'work_request_id' => 'required|exists:work_requests,id',
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string',
            'company_goal' => 'nullable|string|max:255',
        ]);

        // Berikan nilai default jika kosong
        $defaultValues = [
            'company_name' => '-',
            'company_address' => '-',
            'company_goal' => '-'
        ];

        $validated = array_merge($defaultValues, $validated);

        // Cari atau buat data OrderCommunication
        $orderCommunication = OrderCommunication::firstOrCreate(
            ['work_request_id' => $validated['work_request_id']],
            $validated
        );

        // Jika sudah ada, update data
        if ($orderCommunication->exists) {
            $orderCommunication->update($validated);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $orderCommunication
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $orderCommunication = OrderCommunication::findOrFail($id);

        $field = $request->field;
        $value = $request->value;

        // Validasi field
        $validFields = [
            'company_name',
            'company_address',
            'company_goal',
            'date_applicationletter',
            'no_applicationletter',
            'date_offerletter',
            'no_offerletter',
            'date_evaluationletter',
            'no_evaluationletter',
            'date_negotiationletter',
            'no_negotiationletter',
            'date_beritaacaraklarifikasi',
            'date_suratpenunjukan',
            'no_bentukperikatan',
            'date_bentukperikatan',
            'no_bap',
            'date_bap',
            'no_bast',
            'date_bast'

        ];

        if (in_array($field, $validFields)) {
            $orderCommunication->$field = $value;
            $orderCommunication->save();

            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan']);
        }

        return response()->json(['success' => false, 'message' => 'Field tidak valid']);
    }

    /**
     * Upload file
     */
    public function upload(Request $request, $id)
    {
        $orderCommunication = OrderCommunication::findOrFail($id);
        $field = $request->field;

        $validFileFields = [
            'file_offerletter' => 'offer_letters',
            'file_beritaacaraklarifikasi' => 'klarifikasi',
            'file_bentukperikatan' => 'perikatan',
            'file_bap' => 'bap',
            'file_bast' => 'bast'
        ];

        if (!array_key_exists($field, $validFileFields)) {
            return response()->json(['success' => false, 'message' => 'Field file tidak valid']);
        }

        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        // Dapatkan folder berdasarkan field
        $folder = $validFileFields[$field];

        // Hapus file lama jika ada
        if ($orderCommunication->$field) {
            Storage::delete('public/orcom_files/' . $folder . '/' . $orderCommunication->$field);
        }

        // Simpan file baru di folder yang sesuai
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('public/orcom_files/' . $folder, $fileName);

        $orderCommunication->$field = $fileName;
        $orderCommunication->save();

        return response()->json([
            'success' => true,
            'message' => 'File berhasil diupload',
            'file_name' => $fileName
        ]);
    }

    /**
     * Delete file
     */
    public function deleteFile(Request $request, $id)
    {
        $orderCommunication = OrderCommunication::findOrFail($id);
        $field = $request->field;

        $validFileFields = [
            'file_offerletter' => 'offer_letters',
            'file_beritaacaraklarifikasi' => 'klarifikasi',
            'file_bentukperikatan' => 'perikatan',
            'file_bap' => 'bap',
            'file_bast' => 'bast'
        ];

        if (!array_key_exists($field, $validFileFields)) {
            return response()->json(['success' => false, 'message' => 'Field file tidak valid']);
        }

        // Dapatkan folder berdasarkan field
        $folder = $validFileFields[$field];

        // Hapus file dari storage
        if ($orderCommunication->$field) {
            Storage::delete('public/orcom_files/' . $folder . '/' . $orderCommunication->$field);
            $orderCommunication->$field = null;
            $orderCommunication->save();
        }

        return response()->json(['success' => true, 'message' => 'File berhasil dihapus']);
    }

    /**
     * View file
     */
    public function viewFile($id, $field)
    {
        $orderCommunication = OrderCommunication::findOrFail($id);

        $validFileFields = [
            'file_offerletter' => 'offer_letters',
            'file_beritaacaraklarifikasi' => 'klarifikasi',
            'file_bentukperikatan' => 'perikatan',
            'file_bap' => 'bap',
            'file_bast' => 'bast'
        ];

        if (!array_key_exists($field, $validFileFields) || !$orderCommunication->$field) {
            abort(404);
        }

        // Dapatkan folder berdasarkan field
        $folder = $validFileFields[$field];
        $filePath = storage_path('app/public/orcom_files/' . $folder . '/' . $orderCommunication->$field);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->file($filePath);
    }


    /**
     * Update vendor info
     */
    public function updateVendorInfo(Request $request, $id)
    {
        $orderCommunication = OrderCommunication::findOrFail($id);

        $orderCommunication->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_goal' => $request->company_goal,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Informasi vendor berhasil diperbarui'
        ]);
    }

    /**
     * Konversi angka ke angka Romawi
     */
    private function toRoman($number)
    {
        $map = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        ];

        $result = '';
        foreach ($map as $roman => $value) {
            $matches = intval($number / $value);
            $result .= str_repeat($roman, $matches);
            $number %= $value;
        }

        return $result;
    }

    /**
     * Generate nomor dokumen otomatis
     */
    private function generateDocumentNumber($type, $workRequestId)
    {
        // Ambil data WorkRequest
        $workRequest = WorkRequest::findOrFail($workRequestId);

        // Ambil 4 digit pertama dari request_number
        $requestNumber = substr($workRequest->request_number, 0, 4);

        // Pastikan hanya angka yang diambil (jika ada karakter non-digit)
        $requestNumber = preg_replace('/[^0-9]/', '', $requestNumber);

        // Jika kurang dari 4 digit, pad dengan leading zeros
        $formattedNumber = str_pad($requestNumber, 4, '0', STR_PAD_LEFT);

        // Ambil tahun sekarang
        $currentYear = date('Y');

        // Bulan Romawi
        $romanMonth = $this->toRoman(date('n'));

        // Tentukan format berdasarkan jenis dokumen
        switch ($type) {
            case 'application':
                return "{$formattedNumber}/SPPH/GA/KPU/{$romanMonth}/{$currentYear}";

            case 'evaluation':
                return "{$formattedNumber}/ET/GA/KPU/{$romanMonth}/{$currentYear}";

            case 'negotiation':
                return "{$formattedNumber}/UND-KNH/GA/KPU/{$romanMonth}/{$currentYear}";

            case 'beritaacara':
                return "{$formattedNumber}.BAKN/KPU/{$romanMonth}/{$currentYear}";

            case 'suratpenunjukan':
                return "{$formattedNumber}.PPBJ/KPU/{$romanMonth}/{$currentYear}";

            default:
                return "{$formattedNumber}/DOC/GA/KPU/{$romanMonth}/{$currentYear}";
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderCommunication $orderCommunication)
    {
        //
    }
}
