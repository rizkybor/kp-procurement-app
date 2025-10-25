<?php

namespace App\Imports;

use App\Models\WorkRequestItem;
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

    /** Normalisasi angka desimal berbagai format (1.234,56 / 1,234.56 / 1234.56 / 1234,56) */
    private function normalizeDecimal($value): ?float
    {
        if ($value === null || trim((string)$value) === '') {
            return null;
        }

        $s = trim((string)$value);

        // Jika Excel sudah parsing menjadi numeric, langsung kembalikan
        if (is_numeric($s)) {
            return (float)$s;
        }

        // Buang spasi
        $s = str_replace(' ', '', $s);

        // Kasus umum Indonesia: titik = ribuan, koma = desimal -> ganti titik (ribuan) hilang, koma -> titik
        // Contoh "1.234,56" -> "1234.56"
        if (preg_match('/^\d{1,3}(\.\d{3})+,\d+$/', $s)) {
            $s = str_replace('.', '', $s);
            $s = str_replace(',', '.', $s);
            return (float)$s;
        }

        // Kasus US: koma ribuan, titik desimal -> hapus koma ribuan
        // Contoh "1,234.56" -> "1234.56"
        if (preg_match('/^\d{1,3}(,\d{3})+\.\d+$/', $s)) {
            $s = str_replace(',', '', $s);
            return (float)$s;
        }

        // Jika hanya koma sebagai desimal -> ganti ke titik
        if (strpos($s, ',') !== false && strpos($s, '.') === false) {
            $s = str_replace(',', '.', $s);
        }

        // Hapus pemisah ribuan sisa yang bukan titik desimal terakhir
        // (fallback konservatif)
        $s = preg_replace('/(?<=\d)[^\d\.]/', '', $s);

        return is_numeric($s) ? (float)$s : null;
    }

    /** Hapus newline & trim */
    private function normalizeText($v): string
    {
        $t = (string)($v ?? '');
        $t = preg_replace("/\r\n|\r|\n/", ' ', $t);
        return trim($t);
    }

    public function model(array $row)
    {
        // Skip baris kosong total
        $isEmpty = fn($v) => !isset($v) || trim((string)$v) === '';
        if (
            $isEmpty($row['deskripsi'] ?? null) &&
            $isEmpty($row['jumlah'] ?? null) &&
            $isEmpty($row['satuan'] ?? null) &&
            $isEmpty($row['keterangan'] ?? null)
        ) {
            return null;
        }

        $qty = $this->normalizeDecimal($row['jumlah'] ?? null);

        return new WorkRequestItem([
            'work_request_id' => $this->workRequestId,
            'item_name'       => $this->normalizeText($row['deskripsi'] ?? ''),
            'quantity'        => $qty,                                   // desimal OK
            'unit'            => trim((string)($row['satuan'] ?? '')),
            'description'     => $this->normalizeText($row['keterangan'] ?? ''),
        ]);
    }

    public function rules(): array
    {
        return [
            '*.deskripsi'  => ['required','string'],
            '*.jumlah'     => ['required','numeric','min:0.0001'],
            '*.satuan'     => ['required','string','max:50'],
            '*.keterangan' => ['nullable','string'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.deskripsi.required' => 'Kolom deskripsi wajib diisi.',
            '*.jumlah.required'    => 'Kolom jumlah wajib diisi.',
            '*.jumlah.numeric'     => 'Jumlah harus angka (boleh desimal).',
            '*.jumlah.min'         => 'Jumlah harus lebih dari 0.',
            '*.satuan.required'    => 'Kolom satuan wajib diisi.',
        ];
    }
}