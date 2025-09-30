<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto">
        <div class="flex items-start justify-between gap-4 mb-6">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">
                Detail Vendor
            </h1>
            <div class="flex items-center gap-2">
                <a href="{{ route('vendors.edit', $vendor) }}"
                   class="px-3 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700">Edit</a>
                <a href="{{ route('vendors.page') }}"
                   class="px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm hover:bg-gray-200 dark:hover:bg-gray-600">Kembali</a>
            </div>
        </div>

        {{-- Info Perusahaan --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-6">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60">
                <h2 class="font-semibold text-gray-800 dark:text-gray-100">Informasi Perusahaan</h2>
            </header>
            <table class="w-full">
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <tr>
                        <td class="p-4 text-sm text-gray-500 dark:text-gray-400 w-56">Nama</td>
                        <td class="p-4 font-medium text-gray-800 dark:text-gray-100">{{ $vendor->name }}</td>
                    </tr>
                    <tr>
                        <td class="p-4 text-sm text-gray-500 dark:text-gray-400">Alamat</td>
                        <td class="p-4 font-medium text-gray-800 dark:text-gray-100">{{ $vendor->company_address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="p-4 text-sm text-gray-500 dark:text-gray-400">Tipe Bisnis</td>
                        <td class="p-4 font-medium text-gray-800 dark:text-gray-100">
                            {{-- fallback: value string di kolom + relasi opsional --}}
                            {{ $vendor->business_type ?? optional($vendor->businessType)->name ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="p-4 text-sm text-gray-500 dark:text-gray-400 align-top">Bidang Usaha</td>
                        <td class="p-4">
                            @php $fields = $vendor->business_fields ?? []; @endphp
                            @forelse($fields as $f)
                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 mr-2 mb-2">{{ $f }}</span>
                            @empty
                                <span class="text-gray-500 dark:text-gray-400">-</span>
                            @endforelse
                        </td>
                    </tr>
                    <tr>
                        <td class="p-4 text-sm text-gray-500 dark:text-gray-400">NPWP / Tax Number</td>
                        <td class="p-4 font-medium text-gray-800 dark:text-gray-100">{{ $vendor->tax_number ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- PIC --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-6">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60">
                <h2 class="font-semibold text-gray-800 dark:text-gray-100">PIC Perusahaan</h2>
            </header>
            <table class="w-full">
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <tr>
                        <td class="p-4 text-sm text-gray-500 dark:text-gray-400 w-56">Nama PIC</td>
                        <td class="p-4 font-medium text-gray-800 dark:text-gray-100">{{ $vendor->pic_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="p-4 text-sm text-gray-500 dark:text-gray-400">Jabatan PIC</td>
                        <td class="p-4 font-medium text-gray-800 dark:text-gray-100">{{ $vendor->pic_position ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Rekening Bank --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-6">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60">
                <h2 class="font-semibold text-gray-800 dark:text-gray-100">Rekening Bank</h2>
            </header>
            <table class="w-full">
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <tr>
                        <td class="p-4 text-sm text-gray-500 dark:text-gray-400 w-56">Nama Bank</td>
                        <td class="p-4 font-medium text-gray-800 dark:text-gray-100">{{ $vendor->bank_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="p-4 text-sm text-gray-500 dark:text-gray-400">No. Rekening</td>
                        <td class="p-4 font-medium text-gray-800 dark:text-gray-100">{{ $vendor->bank_number ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Dokumen Legalitas (download jika ada) --}}
        @php
            $fileMap = [
                'file_deed_of_company'     => 'Akta Perusahaan',
                'file_legalization_letter' => 'Pengesahan/Legalisasi',
                'file_nib'                 => 'NIB',
                'file_siujk'               => 'SIUJK',
                'file_tax_registration'    => 'NPWP/Tax Registration',
                'file_vat_registration'    => 'VAT Registration',
                'file_id_card'             => 'KTP',
                'file_vendor_statement'    => 'Surat Pernyataan Vendor',
                'file_integrity_pact'      => 'Pakta Integritas',
                'file_vendor_feasibility'  => 'Kelayakan Vendor',
                'file_interest_statement'  => 'Surat Minat',
            ];
        @endphp

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60">
                <h2 class="font-semibold text-gray-800 dark:text-gray-100">Dokumen Legal</h2>
            </header>
            <table class="w-full">
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($fileMap as $field => $label)
                        <tr>
                            <td class="p-4 text-sm text-gray-500 dark:text-gray-400 w-56">{{ $label }}</td>
                            <td class="p-4">
                                @if(!empty($vendor->{$field}))
                                    <a href="{{ route('vendors.download', [$vendor, $field]) }}"
                                       class="inline-flex items-center px-3 py-1.5 rounded-lg bg-green-600 text-white text-xs hover:bg-green-700">
                                        Download
                                    </a>
                                    <span class="ml-3 text-xs text-gray-500 dark:text-gray-400 break-all">
                                        {{ $vendor->{$field} }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                        Belum ada
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Footer tombol --}}
        <div class="mt-6 flex items-center gap-2">
            <a href="{{ route('vendors.edit', $vendor) }}"
               class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700">Edit</a>
            <a href="{{ route('vendors.page') }}"
               class="px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm hover:bg-gray-200 dark:hover:bg-gray-600">Kembali</a>
        </div>
    </div>
</x-app-layout>