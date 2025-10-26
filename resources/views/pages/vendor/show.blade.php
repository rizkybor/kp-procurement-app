<x-app-layout>
  <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto">

    {{-- Header Page --}}
    <div class="flex items-start justify-between gap-4 mb-6">
      <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-extrabold tracking-tight">
        Detail Vendor
      </h1>
      <div class="flex items-center gap-2 shrink-0">
        <a href="{{ route('vendors.edit', $vendor) }}"
           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold shadow hover:bg-blue-700 active:scale-[0.99] transition">
          <!-- icon edit -->
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487l3.651 3.65M4.5 20.25l5.18-1.153a2 2 0 00.96-.543L20.513 8.68a2.121 2.121 0 000-3l-2.19-2.191a2.121 2.121 0 00-3 0L5.45 13.906a2 2 0 00-.543.96L3.75 20.25z"/>
          </svg>
          Edit
        </a>
        <a href="{{ route('vendors.page') }}"
           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-sm font-semibold shadow hover:bg-gray-200 dark:hover:bg-gray-600 active:scale-[0.99] transition">
          <!-- icon back -->
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
          </svg>
          Kembali
        </a>
      </div>
    </div>

    {{-- Info Perusahaan --}}
    <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl ring-1 ring-black/5 dark:ring-white/10 overflow-hidden mb-6">
      <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60 bg-gray-50/60 dark:bg-gray-900/20">
        <h2 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
          <span class="inline-flex h-5 w-5 items-center justify-center rounded-md bg-indigo-600 text-white text-[10px]">i</span>
          Informasi Perusahaan
        </h2>
      </header>
      <div class="overflow-x-auto">
        <table class="w-full">
          <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-900/30 transition">
              <td class="p-4 text-sm text-gray-500 dark:text-gray-400 w-56">Nama</td>
              <td class="p-4 font-medium text-gray-900 dark:text-gray-100">{{ $vendor->name }}</td>
            </tr>
            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-900/30 transition">
              <td class="p-4 text-sm text-gray-500 dark:text-gray-400">Alamat</td>
              <td class="p-4 font-medium text-gray-900 dark:text-gray-100">{{ $vendor->company_address ?? '-' }}</td>
            </tr>
            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-900/30 transition">
              <td class="p-4 text-sm text-gray-500 dark:text-gray-400">Tipe Bisnis</td>
              <td class="p-4 font-medium text-gray-900 dark:text-gray-100">
                {{ $vendor->business_type ?? (optional($vendor->businessType)->name ?? '-') }}
              </td>
            </tr>
            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-900/30 transition align-top">
              <td class="p-4 text-sm text-gray-500 dark:text-gray-400">Bidang Usaha</td>
              <td class="p-4">
                @php $fields = $vendor->business_fields ?? []; @endphp
                @forelse($fields as $f)
                  <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 ring-1 ring-black/5 dark:ring-white/10 mr-2 mb-2">
                    {{ $f }}
                  </span>
                @empty
                  <span class="text-gray-500 dark:text-gray-400">-</span>
                @endforelse
              </td>
            </tr>
            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-900/30 transition">
              <td class="p-4 text-sm text-gray-500 dark:text-gray-400">NPWP / Tax Number</td>
              <td class="p-4 font-medium text-gray-900 dark:text-gray-100">{{ $vendor->tax_number ?? '-' }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    {{-- PIC --}}
    <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl ring-1 ring-black/5 dark:ring-white/10 overflow-hidden mb-6">
      <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60 bg-gray-50/60 dark:bg-gray-900/20">
        <h2 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
          <span class="inline-flex h-5 w-5 items-center justify-center rounded-md bg-indigo-600 text-white text-[10px]">P</span>
          PIC Perusahaan
        </h2>
      </header>
      <div class="overflow-x-auto">
        <table class="w-full">
          <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-900/30 transition">
              <td class="p-4 text-sm text-gray-500 dark:text-gray-400 w-56">Nama PIC</td>
              <td class="p-4 font-medium text-gray-900 dark:text-gray-100">{{ $vendor->pic_name ?? '-' }}</td>
            </tr>
            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-900/30 transition">
              <td class="p-4 text-sm text-gray-500 dark:text-gray-400">Jabatan PIC</td>
              <td class="p-4 font-medium text-gray-900 dark:text-gray-100">{{ $vendor->pic_position ?? '-' }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    {{-- Rekening Bank --}}
    <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl ring-1 ring-black/5 dark:ring-white/10 overflow-hidden mb-6">
      <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60 bg-gray-50/60 dark:bg-gray-900/20">
        <h2 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
          <span class="inline-flex h-5 w-5 items-center justify-center rounded-md bg-indigo-600 text-white text-[10px]">B</span>
          Rekening Bank
        </h2>
      </header>
      <div class="overflow-x-auto">
        <table class="w-full">
          <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-900/30 transition">
              <td class="p-4 text-sm text-gray-500 dark:text-gray-400 w-56">Nama Bank</td>
              <td class="p-4 font-medium text-gray-900 dark:text-gray-100">{{ $vendor->bank_name ?? '-' }}</td>
            </tr>
            <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-900/30 transition">
              <td class="p-4 text-sm text-gray-500 dark:text-gray-400">No. Rekening</td>
              <td class="p-4 font-medium text-gray-900 dark:text-gray-100">{{ $vendor->bank_number ?? '-' }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    {{-- Dokumen Legalitas --}}
    @php
      $fileMap = [
        'file_deed_of_company' => 'Akta Perusahaan',
        'file_legalization_letter' => 'Pengesahan/Legalisasi',
        'file_nib' => 'NIB',
        'file_siujk' => 'SIUJK',
        'file_tax_registration' => 'NPWP/Tax Registration',
        'file_vat_registration' => 'VAT Registration',
        'file_id_card' => 'KTP',
        'file_vendor_statement' => 'Surat Pernyataan Vendor',
        'file_integrity_pact' => 'Pakta Integritas',
        'file_vendor_feasibility' => 'Kelayakan Vendor',
        'file_interest_statement' => 'Surat Minat',
      ];
    @endphp

    <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl ring-1 ring-black/5 dark:ring-white/10 overflow-hidden">
      <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60 bg-gray-50/60 dark:bg-gray-900/20">
        <h2 class="font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
          <span class="inline-flex h-5 w-5 items-center justify-center rounded-md bg-emerald-600 text-white text-[10px]">D</span>
          Dokumen Legal
        </h2>
      </header>
      <div class="overflow-x-auto">
        <table class="w-full">
          <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach ($fileMap as $field => $label)
              @php
                $fileName = $vendor->{$field} ?? '';
                $ext = $fileName ? strtoupper(pathinfo($fileName, PATHINFO_EXTENSION)) : null;
              @endphp
              <tr class="hover:bg-gray-50/60 dark:hover:bg-gray-900/30 transition">
                <td class="p-4 text-sm text-gray-500 dark:text-gray-400 w-56">{{ $label }}</td>
                <td class="p-4">
                  @if ($fileName)
                    <x-download-button
                      :href="route('vendors.download', [$vendor, $field])"
                      label="Download"
                      size="sm"
                      tone="emerald"
                      :download="true"
                      target="_blank" />
                    <span class="ml-3 text-xs text-gray-500 dark:text-gray-400 break-all align-middle">
                      {{ basename($fileName) }}
                    </span>
                    @if ($ext)
                      <span class="ml-2 inline-flex items-center rounded-md bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 px-2 py-0.5 text-[10px] font-medium align-middle">
                        jenis file : .{{ $ext }}
                      </span>
                    @endif
                  @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                      Belum ada
                    </span>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>

  </div>
</x-app-layout>