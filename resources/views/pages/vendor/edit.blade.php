<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <!-- Sidebar -->
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Edit Vendor</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Ubah informasi vendor, detil PIC, atau re-upload dokumen.
                    </p>
                </div>
            </div>

            <!-- Form -->
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form method="POST" action="{{ route('vendors.update', $vendor) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="grid grid-cols-1 gap-y-6">

                            {{-- Company Info --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-label for="name">Nama Vendor <span class="text-red-500">*</span></x-label>
                                    <x-input id="name" name="name" type="text" class="mt-1 block w-full"
                                        value="{{ old('name', $vendor->name) }}" required />
                                    <x-input-error for="name" class="mt-2" />
                                </div>

                                <div>
                                    <x-label for="business_type">Tipe Bisnis/Usaha</x-label>
                                    @if (!empty($businessTypes) && count($businessTypes))
                                        <select id="business_type" name="business_type"
                                            class="mt-1 block w-full form-select rounded-md border-gray-300 shadow-sm">
                                            <option value="">Pilih Tipe Bisnis/Usaha</option>
                                            @foreach ($businessTypes as $bt)
                                                <option value="{{ $bt }}" @selected(old('business_type', $vendor->business_type) === $bt)>
                                                    {{ $bt }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <x-input id="business_type" name="business_type" type="text"
                                            class="mt-1 block w-full"
                                            value="{{ old('business_type', $vendor->business_type) }}"
                                            placeholder="Individual / Corporate" />
                                    @endif
                                    <x-input-error for="business_type" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-label for="tax_number">Nomor Pajak</x-label>
                                    <x-input id="tax_number" name="tax_number" type="text" class="mt-1 block w-full"
                                        value="{{ old('tax_number', $vendor->tax_number) }}" />
                                    <x-input-error for="tax_number" class="mt-2" />
                                </div>

                                <div>
                                    <x-label for="company_address">Alamat Perusahaan</x-label>
                                    <textarea id="company_address" name="company_address" rows="2"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-white dark:bg-gray-900">{{ old('company_address', $vendor->company_address) }}</textarea>
                                    <x-input-error for="company_address" class="mt-2" />
                                </div>
                            </div>

                            {{-- Business Fields (JSON array) --}}
                            <div>
                                <x-label for="business_fields">Jenis Usaha</x-label>
                                @php
                                    $fields = old('business_fields', $vendor->business_fields ?? []);
                                    $fieldsStr = is_array($fields) ? implode(', ', $fields) : (string) $fields;
                                @endphp
                                <input id="business_fields" name="business_fields[]"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                    value="{{ $fieldsStr }}" placeholder="contoh : Logistik atau lainnya">
                                <p class="text-xs text-gray-500 mt-1">Separate with comma. Will be saved as an array.
                                </p>
                            </div>

                            {{-- PIC --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-label for="pic_name">Nama PIC</x-label>
                                    <x-input id="pic_name" name="pic_name" type="text" class="mt-1 block w-full"
                                        value="{{ old('pic_name', $vendor->pic_name) }}" />
                                    <x-input-error for="pic_name" class="mt-2" />
                                </div>
                                <div>
                                    <x-label for="pic_position">Posisi PIC</x-label>
                                    <x-input id="pic_position" name="pic_position" type="text"
                                        class="mt-1 block w-full"
                                        value="{{ old('pic_position', $vendor->pic_position) }}" />
                                    <x-input-error for="pic_position" class="mt-2" />
                                </div>
                            </div>

                            {{-- Bank Account --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-label for="bank_name">Nama Bank</x-label>
                                    <x-input id="bank_name" name="bank_name" type="text" class="mt-1 block w-full"
                                        value="{{ old('bank_name', $vendor->bank_name) }}" />
                                    <x-input-error for="bank_name" class="mt-2" />
                                </div>
                                <div>
                                    <x-label for="bank_number">Nomer Rekening Bank</x-label>
                                    <x-input id="bank_number" name="bank_number" type="text"
                                        class="mt-1 block w-full"
                                        value="{{ old('bank_number', $vendor->bank_number) }}" />
                                    <x-input-error for="bank_number" class="mt-2" />
                                </div>
                            </div>

                            {{-- Documents (re-upload to replace) --}}
                            <div class="pt-2">
                                <h4 class="font-semibold text-gray-900 dark:text-gray-100 mb-2">Kelengkapan Dokumen</h4>
                                <p class="text-xs text-gray-500 mb-3">Unggah berkas hanya jika Anda ingin mengganti
                                    berkas yang sudah ada.</p>

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
                                            <input id="{{ $field }}" name="{{ $field }}"
                                                type="file" class="mt-1 block w-full">
                                            @if (!empty($vendor->{$field}))
                                                <a href="{{ route('vendors.download', [$vendor->id, $field]) }}"
                                                    target="_blank"
                                                    class="text-xs text-blue-600 hover:underline">Current file</a>
                                            @endif
                                            <x-input-error for="{{ $field }}" class="mt-1" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('vendors.page') }}"
                                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600">
                                Kembali
                            </a>
                            <x-button>Ubah Data Vendor</x-button>
                        </div>
                    </div>
                </form>

                <x-validation-errors class="mt-4" />
            </div>
        </div>
    </div>
</x-app-layout>
