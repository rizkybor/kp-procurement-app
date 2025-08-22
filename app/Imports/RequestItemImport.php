<?php

namespace App\Imports;

use App\Models\WorkRequestItem;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RequestItemImport implements ToModel, WithHeadingRow, WithValidation
{
    protected int $workRequestId;

    public function __construct(int $workRequestId)
    {
        $this->workRequestId = $workRequestId;
    }

    /**
     * @param array $row  // keys mengikuti headings: deskripsi, jumlah, satuan, keterangan
     */
    public function model(array $row)
    {
        // Skip baris kosong total
        if (
            empty($row['deskripsi']) &&
            empty($row['jumlah']) &&
            empty($row['satuan']) &&
            empty($row['keterangan'])
        ) {
            return null;
        }

        // Normalisasi
        $itemName = trim((string)($row['deskripsi'] ?? ''));
        $qty      = is_numeric($row['jumlah'] ?? null) ? (float)$row['jumlah'] : null;
        $unit     = trim((string)($row['satuan'] ?? ''));
        $desc     = trim((string)($row['keterangan'] ?? ''));

        return new WorkRequestItem([
            'work_request_id' => $this->workRequestId,
            'item_name'       => $itemName,
            'quantity'        => $qty,
            'unit'            => $unit,
            'description'     => $desc,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.deskripsi'  => ['required','string','max:255'],
            '*.jumlah'     => ['required','numeric','min:0.0001'],
            '*.satuan'     => ['required','string','max:50'],
            '*.keterangan' => ['nullable','string','max:500'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.deskripsi.required' => 'Kolom deskripsi wajib diisi.',
            '*.jumlah.required'    => 'Kolom jumlah wajib diisi.',
            '*.jumlah.numeric'     => 'Jumlah harus angka.',
            '*.jumlah.min'         => 'Jumlah harus lebih dari 0.',
            '*.satuan.required'    => 'Kolom satuan wajib diisi.',
        ];
    }
}