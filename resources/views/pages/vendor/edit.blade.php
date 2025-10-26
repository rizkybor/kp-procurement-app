<x-app-layout>
  <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <div class="md:grid md:grid-cols-3 md:gap-6">

      <!-- Sidebar -->
      <aside class="md:col-span-1">
        <div class="px-4 sm:px-0 sticky top-6">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Edit Vendor</h3>
          <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Ubah informasi vendor, detil PIC, atau re-upload dokumen. Pastikan data sesuai dokumen legal.
          </p>
        </div>
      </aside>

      <!-- Form -->
      <div class="mt-5 md:mt-0 md:col-span-2">
        <form method="POST" action="{{ route('vendors.update', $vendor) }}" enctype="multipart/form-data" class="space-y-6">
          @csrf
          @method('PUT')

          <!-- Card: Info Perusahaan -->
          <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl ring-1 ring-black/5 dark:ring-white/10">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60 bg-gray-50/60 dark:bg-gray-900/20">
              <h4 class="font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-md bg-indigo-600 text-white text-[10px]">i</span>
                Informasi Perusahaan
              </h4>
            </header>

            <div class="px-6 py-6">
              <div class="grid grid-cols-1 gap-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <x-label for="name">Nama Vendor <span class="text-red-500">*</span></x-label>
                    <x-input id="name" name="name" type="text"
                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 shadow-sm
                             focus:ring-indigo-500 focus:border-indigo-500"
                      value="{{ old('name', $vendor->name) }}" required />
                    <x-input-error for="name" class="mt-2" />
                  </div>

                  <div>
                    <x-label for="business_type">Tipe Bisnis/Usaha</x-label>
                    @if (!empty($businessTypes) && count($businessTypes))
                      <select id="business_type" name="business_type"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 shadow-sm
                               focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Pilih Tipe Bisnis/Usaha</option>
                        @foreach ($businessTypes as $bt)
                          <option value="{{ $bt }}" @selected(old('business_type', $vendor->business_type) === $bt)>{{ $bt }}</option>
                        @endforeach
                      </select>
                    @else
                      <x-input id="business_type" name="business_type" type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 shadow-sm
                               focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('business_type', $vendor->business_type) }}"
                        placeholder="Individual / Corporate" />
                    @endif
                    <x-input-error for="business_type" class="mt-2" />
                  </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div>
                    <x-label for="tax_number">Nomor Pajak</x-label>
                    <x-input id="tax_number" name="tax_number" type="text"
                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 shadow-sm
                             focus:ring-indigo-500 focus:border-indigo-500"
                      value="{{ old('tax_number', $vendor->tax_number) }}" />
                    <x-input-error for="tax_number" class="mt-2" />
                  </div>

                  <div>
                    <x-label for="company_address">Alamat Perusahaan</x-label>
                    <textarea id="company_address" name="company_address" rows="2"
                      class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 shadow-sm
                             focus:ring-indigo-500 focus:border-indigo-500">{{ old('company_address', $vendor->company_address) }}</textarea>
                    <x-input-error for="company_address" class="mt-2" />
                  </div>
                </div>

                <div>
                  <x-label for="business_fields">Jenis Usaha</x-label>
                  @php
                    $fields = old('business_fields', $vendor->business_fields ?? []);
                    $fieldsStr = is_array($fields) ? implode(', ', $fields) : (string) $fields;
                  @endphp
                  <input id="business_fields" name="business_fields[]"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 shadow-sm
                           focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ $fieldsStr }}" placeholder="contoh: Logistik, Konstruksi, Alat K3" />
                  <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pisahkan dengan koma. Tersimpan sebagai array.</p>
                </div>

              </div>
            </div>
          </section>

          <!-- Card: PIC -->
          <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl ring-1 ring-black/5 dark:ring-white/10">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60 bg-gray-50/60 dark:bg-gray-900/20">
              <h4 class="font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-md bg-indigo-600 text-white text-[10px]">P</span>
                PIC Perusahaan
              </h4>
            </header>

            <div class="px-6 py-6">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <x-label for="pic_name">Nama PIC</x-label>
                  <x-input id="pic_name" name="pic_name" type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 shadow-sm
                           focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ old('pic_name', $vendor->pic_name) }}" />
                  <x-input-error for="pic_name" class="mt-2" />
                </div>

                <div>
                  <x-label for="pic_position">Posisi PIC</x-label>
                  <x-input id="pic_position" name="pic_position" type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 shadow-sm
                           focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ old('pic_position', $vendor->pic_position) }}" />
                  <x-input-error for="pic_position" class="mt-2" />
                </div>
              </div>
            </div>
          </section>

          <!-- Card: Rekening Bank -->
          <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl ring-1 ring-black/5 dark:ring-white/10">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60 bg-gray-50/60 dark:bg-gray-900/20">
              <h4 class="font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-md bg-indigo-600 text-white text-[10px]">B</span>
                Rekening Bank
              </h4>
            </header>

            <div class="px-6 py-6">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <x-label for="bank_name">Nama Bank</x-label>
                  <x-input id="bank_name" name="bank_name" type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 shadow-sm
                           focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ old('bank_name', $vendor->bank_name) }}" />
                  <x-input-error for="bank_name" class="mt-2" />
                </div>
                <div>
                  <x-label for="bank_number">Nomor Rekening Bank</x-label>
                  <x-input id="bank_number" name="bank_number" type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 shadow-sm
                           focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ old('bank_number', $vendor->bank_number) }}" />
                  <x-input-error for="bank_number" class="mt-2" />
                </div>
              </div>
            </div>
          </section>

          <!-- Card: Dokumen -->
          <section class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl ring-1 ring-black/5 dark:ring-white/10">
            <header class="px-6 py-4 border-b border-gray-100 dark:border-gray-700/60 bg-gray-50/60 dark:bg-gray-900/20">
              <h4 class="font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                <span class="inline-flex h-5 w-5 items-center justify-center rounded-md bg-emerald-600 text-white text-[10px]">D</span>
                Kelengkapan Dokumen
              </h4>
            </header>

            <div class="px-6 py-6">
              <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">
                Unggah berkas hanya jika Anda ingin mengganti berkas yang sudah ada.
              </p>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @php
                  $docs = [
                    'file_deed_of_company' => 'Akta Perusahaan',
                    'file_legalization_letter' => 'SK Pengesahan',
                    'file_nib' => 'NIB',
                    'file_siujk' => 'SIUJK',
                    'file_tax_registration' => 'NPWP',
                    'file_vat_registration' => 'PKP',
                    'file_id_card' => 'KTP',
                    'file_vendor_statement' => 'Surat Pernyataan Vendor',
                    'file_integrity_pact' => 'Pakta Integritas',
                    'file_vendor_feasibility' => 'Uji Kelayakan Vendor',
                    'file_interest_statement' => 'Surat Pernyataan Minat',
                  ];
                @endphp

                @foreach ($docs as $field => $label)
                  <div class="space-y-1">
                    <x-label for="{{ $field }}">{{ $label }}</x-label>
                    <input id="{{ $field }}" name="{{ $field }}" type="file"
                      class="mt-1 block w-full rounded-md border border-dashed border-gray-300 dark:border-gray-600
                             bg-white dark:bg-gray-900 text-sm file:mr-3 file:py-2 file:px-3 file:rounded-md
                             file:border-0 file:bg-indigo-50 dark:file:bg-gray-800 file:text-indigo-700 dark:file:text-gray-200
                             hover:border-indigo-300 focus:border-indigo-500 focus:ring-indigo-500 transition" />
                    @if (!empty($vendor->{$field}))
                      <a href="{{ route('vendors.download', [$vendor->id, $field]) }}"
                         target="_blank"
                         class="inline-flex items-center text-xs text-blue-600 hover:text-blue-700 hover:underline">
                        Current file
                        <svg class="ml-1 h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"/>
                        </svg>
                      </a>
                    @endif
                    <x-input-error for="{{ $field }}" class="mt-1" />
                  </div>
                @endforeach
              </div>
            </div>
          </section>

          <!-- Footer Actions -->
          <div class="flex items-center justify-between">
            <a href="{{ route('vendors.page') }}"
              class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600
                     text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900
                     shadow-sm active:scale-[0.99] transition">
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
              </svg>
              Kembali
            </a>

            <x-button class="!bg-indigo-600 hover:!bg-indigo-700 active:!scale-[0.99]">
              Ubah Data Vendor
            </x-button>
          </div>

          <x-validation-errors class="mt-2" />
        </form>
      </div>
    </div>
  </div>
</x-app-layout>