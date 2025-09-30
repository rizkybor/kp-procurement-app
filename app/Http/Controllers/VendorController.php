<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{
    /**
     * Daftar kolom file upload pada tabel vendors (versi English).
     */
    private array $fileFields = [
        'file_deed_of_company',
        'file_legalization_letter',
        'file_nib',
        'file_siujk',
        'file_tax_registration',
        'file_vat_registration',
        'file_id_card',
        'file_vendor_statement',
        'file_integrity_pact',
        'file_vendor_feasibility',
        'file_interest_statement',
    ];

    public function index(Request $request)
    {
        $q = Vendor::query();

        if ($search = $request->get('search')) {
            $q->where(function ($qq) use ($search) {
                $qq->where('name', 'like', "%{$search}%")
                    ->orWhere('business_type', 'like', "%{$search}%")
                    ->orWhere('company_address', 'like', "%{$search}%")
                    ->orWhere('tax_number', 'like', "%{$search}%")
                    ->orWhere('pic_name', 'like', "%{$search}%")
                    ->orWhere('pic_position', 'like', "%{$search}%")
                    // JSON search sederhana
                    ->orWhere('business_fields', 'like', "%{$search}%");
            });
        }

        return response()->json(
            $q->latest()->paginate($request->integer('per_page', 15))
        );
    }

    public function page(Request $request)
    {
        $q = Vendor::query();

        if ($search = $request->get('search')) {
            $q->where(function ($qq) use ($search) {
                $qq->where('name', 'like', "%{$search}%")
                    ->orWhere('business_type', 'like', "%{$search}%")
                    ->orWhere('company_address', 'like', "%{$search}%")
                    ->orWhere('tax_number', 'like', "%{$search}%")
                    ->orWhere('pic_name', 'like', "%{$search}%")
                    ->orWhere('pic_position', 'like', "%{$search}%")
                    ->orWhere('business_fields', 'like', "%{$search}%");
            });
        }

        $vendors = $q->latest()
            ->paginate($request->integer('per_page', 10))
            ->appends($request->only('search', 'per_page'));

        return view('pages.vendor.index', compact('vendors'));
    }

    // Contoh
    public function create()
    {
        $businessTypes = \App\Models\BusinessType::orderBy('name')->pluck('name');
        return view('pages.vendor.create', compact('businessTypes'));
    }
    public function edit(Vendor $vendor)
    {
        $businessTypes = \App\Models\BusinessType::orderBy('name')->pluck('name');
        return view('pages.vendor.edit', compact('vendor', 'businessTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // Text fields
            'name'             => ['required', 'string', 'max:255'],
            'business_type'    => ['nullable', 'string', 'max:255'], // referensi ke tabel business_types (by name)
            'bank_name'       => ['nullable', 'string', 'max:100'],
            'bank_number'       => ['nullable', 'string', 'max:100'],
            'tax_number'       => ['nullable', 'string', 'max:100'],
            'company_address'  => ['nullable', 'string'],
            'business_fields'  => ['nullable', 'array'],   // JSON array
            'business_fields.*' => ['nullable', 'string', 'max:255'],
            'pic_name'         => ['nullable', 'string', 'max:255'],
            'pic_position'     => ['nullable', 'string', 'max:255'],

            // File uploads (optional)
            'file_deed_of_company'      => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_legalization_letter'  => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_nib'                  => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_siujk'                => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_tax_registration'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_vat_registration'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_id_card'              => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_vendor_statement'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_integrity_pact'       => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_vendor_feasibility'   => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_interest_statement'   => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $this->handleUploads($request, $data);

        Vendor::create($data);

        return redirect()->route('vendors.page')
            ->with('success', 'Vendor berhasil ditambahkan.');
    }

    public function show(Vendor $vendor)
    {
    return view('pages.vendor.show', compact('vendor'));

    }

    public function update(Request $request, Vendor $vendor)
    {
        $data = $request->validate([
            'name'             => ['sometimes', 'required', 'string', 'max:255'],
            'business_type'    => ['nullable', 'string', 'max:255'],
            'bank_name'       => ['nullable', 'string', 'max:100'],
            'bank_number'       => ['nullable', 'string', 'max:100'],
            'tax_number'       => ['nullable', 'string', 'max:100'],
            'company_address'  => ['nullable', 'string'],
            'business_fields'  => ['nullable', 'array'],
            'business_fields.*' => ['nullable', 'string', 'max:255'],
            'pic_name'         => ['nullable', 'string', 'max:255'],
            'pic_position'     => ['nullable', 'string', 'max:255'],

            // File uploads (optional, replaceable)
            'file_deed_of_company'      => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_legalization_letter'  => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_nib'                  => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_siujk'                => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_tax_registration'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_vat_registration'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_id_card'              => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_vendor_statement'     => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_integrity_pact'       => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_vendor_feasibility'   => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_interest_statement'   => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $this->handleUploads($request, $data, $vendor);

        $vendor->update($data);

        // Redirect ke halaman detail vendor
        return redirect()->route('vendors.edit', $vendor->id)
            ->with('success', 'Vendor berhasil diperbarui.');
    }

    public function destroy(Vendor $vendor)
    {
        // Hapus file terkait (opsional)
        foreach ($this->fileFields as $field) {
            if (!empty($vendor->{$field}) && Storage::disk('public')->exists($vendor->{$field})) {
                Storage::disk('public')->delete($vendor->{$field});
            }
        }

        $vendor->delete();

        return redirect()->route('vendors.page')
            ->with('success', 'Vendor berhasil dihapus.');
    }

    /**
     * Simpan file upload dan isi $data[$field] dengan path.
     * Jika $existing diberikan (update), file lama dihapus saat diganti.
     */
    private function handleUploads(Request $request, array &$data, ?Vendor $existing = null): void
    {
        foreach ($this->fileFields as $field) {
            if ($request->hasFile($field)) {
                // Hapus file lama kalau ada
                if ($existing && !empty($existing->{$field}) && Storage::disk('public')->exists($existing->{$field})) {
                    Storage::disk('public')->delete($existing->{$field});
                }

                // Buat nama folder berdasarkan nama field
                $folder = "vendors/{$field}";

                // Ambil ekstensi file
                $originalName = $request->file($field)->getClientOriginalName();

                // Buat nama unik (misalnya pakai timestamp + uniqid)
                $filename = uniqid() . '_' .  date('Ymd') . '_' . $originalName;

                // Simpan file
                $path = $request->file($field)->storeAs($folder, $filename, 'public');

                // Simpan path ke DB
                $data[$field] = $path;
            }
        }
    }
    public function download(Vendor $vendor, string $field)
    {
        if (!in_array($field, $this->fileFields)) {
            abort(404, 'File field not valid');
        }

        $path = $vendor->{$field};

        if (!$path || !Storage::disk('public')->exists($path)) {
            abort(404, 'File not found');
        }

        return response()->file(storage_path('app/public/' . $path));
    }
}
