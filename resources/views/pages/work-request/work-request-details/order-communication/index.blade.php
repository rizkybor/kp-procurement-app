<x-app-layout>
    <div x-data="{ isEdit: {{ $isEdit ? 'true' : 'false' }}, openModal: false }" x-cloak>

        <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <!-- Left: Title -->
                <h1 class="text-xl md:text-2xl text-gray-800 dark:text-gray-100 font-bold">
                    ORCOM (Order Communication)
                </h1>

                <div class="flex space-x-2">
                    <!-- Tombol Download All Files -->
                    <a href="{{ route('work_request.download-all-files', $workRequests->id) }}">
                        <x-button.button-action color="green" icon="download">
                            Download Semua File
                        </x-button.button-action>
                    </a>

                    <x-button.button-action color="blue" type="button"
                        onclick="window.location='{{ route('work_request.work_request_items.show', $workRequests->id) }}'">
                        Kembali
                    </x-button.button-action>

                    @if (!in_array($workRequests->status, [100]))
                        <!-- Tombol untuk membuka modal -->
                        <button type="button"
                            class="px-3 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white flex items-center gap-2 transition"
                            @click="openModal = true">
                            <i class="fa-solid fa-check"></i>
                            Ubah status menjadi selesai
                        </button>
                    @endif

                    <!-- Modal Konfirmasi (hapus x-data di sini) -->
                    <div x-show="openModal" x-transition.opacity @keydown.escape.window="openModal = false"
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-cloak>
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg max-w-md w-full p-6 relative"
                            x-transition.scale @click.outside="openModal = false">
                            <!-- Tombol close -->
                            <button
                                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                @click="openModal = false">
                                <i class="fa-solid fa-xmark text-lg"></i>
                            </button>

                            <!-- Header -->
                            <div class="text-center mb-4">
                                <div class="flex justify-center mb-3">
                                    <div
                                        class="w-14 h-14 bg-blue-100 dark:bg-blue-900 flex items-center justify-center rounded-full">
                                        <i
                                            class="fa-solid fa-circle-check text-blue-600 dark:text-blue-300 text-3xl"></i>
                                    </div>
                                </div>
                                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                    Konfirmasi Penyelesaian Dokumen
                                </h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                    Apakah Anda yakin ingin menandai dokumen ini sebagai
                                    <span class="font-semibold text-blue-600">selesai</span>? Tindakan ini akan mengubah
                                    status
                                    menjadi <b>Finished</b> dan mengirim notifikasi ke maker.
                                </p>
                            </div>

                            <!-- Tombol aksi -->
                            <div class="flex justify-center gap-3 mt-6">
                                <button type="button" @click="openModal = false"
                                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 transition">
                                    Batal
                                </button>

                                <form action="{{ route('work_request.markFinished', $workRequests->id) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition flex items-center gap-1"
                                        @click="openModal = false">
                                        <i class="fa-solid fa-check"></i> Ya, Selesai
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="grid grid-cols-12 gap-6">
                <!-- Card (Customers) -->
                <div class="col-span-full xl:col-span-12 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
                    <!-- Header -->
                    <header
                        class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between flex-wrap gap-2">
                        <div>
                            <h2 class="font-semibold dark:text-gray-100 py-1">
                                ORCOM (Order Communication)
                            </h2>
                            <h2 class="font-semibold dark:text-gray-100 py-1">
                                {{ $workRequests->work_name_request }}
                            </h2>
                        </div>

                        @if (!in_array($workRequests->status, [100]))
                            <a href="{{ $isEdit ? request()->url() : request()->fullUrlWithQuery(['mode' => 'edit']) }}"
                                class="px-3 py-2 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600 transition-colors">
                                {{ $isEdit ? 'Selesai Edit' : 'Edit Orcom' }}
                            </a>
                        @endif
                    </header>

                    <!-- Content -->
                    <div class="px-5 py-4 border-gray-100 dark:border-gray-700/60">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-3 mb-8">
                            <h2 class="font-semibold dark:text-gray-100 py-1 mb-4 sm:mb-0">
                                Pilih Mitra / Vendor :
                            </h2>

                            <!-- Dropdown Vendor -->
                            <div class="relative w-full sm:w-64">
                                <input type="text" id="vendorInput" placeholder="Ketik/Cari Vendor..."
                                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md 
                                bg-white dark:bg-gray-800 text-sm text-gray-800 dark:text-gray-200 
                                focus:outline-none focus:ring focus:ring-blue-300 dark:focus:ring-blue-700 transition-all"
                                    oninput="filterVendorDropdown()" onclick="toggleVendorDropdown()" autocomplete="off"
                                    value="{{ $orderCommunication->vendor ? $orderCommunication->vendor->name : '' }}" />

                                <input type="hidden" id="vendor_id" name="vendor_id"
                                    value="{{ $orderCommunication->vendor_id ?? '' }}" />

                                <ul id="vendorDropdown"
                                    class="absolute z-10 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 
                    rounded-md mt-1 max-h-60 overflow-auto shadow-md hidden transition-all">
                                    <!-- Daftar vendor -->
                                    @foreach ($vendors as $vendor)
                                        <li class="px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-all"
                                            onclick="selectVendor('{{ $vendor->id }}', '{{ $vendor->name }}', '{{ $vendor->company_address ?? '' }}', '{{ $vendor->business_type ?? '' }}')">
                                            <div class="font-semibold text-gray-800 dark:text-gray-200">
                                                {{ $vendor->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $vendor->company_address ?? '' }}
                                            </div>
                                            <div class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                                                {{ $vendor->business_type ?? '' }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Di bagian vendor display -->
                        <div class="space-y-2">
                            <div class="flex">
                                <span class="font-semibold dark:text-gray-100 w-40">Nama Perusahaan</span>
                                <span class="text-gray-600 dark:text-gray-400">: <span id="vendorNameDisplay"
                                        name="company_name">{{ $orderCommunication->vendor->name ?? '-' }}</span></span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold dark:text-gray-100 w-40">Alamat Perusahaan</span>
                                <span class="text-gray-600 dark:text-gray-400">: <span id="vendorAddress"
                                        name="company_address">{{ $orderCommunication->vendor->company_address ?? '-' }}</span></span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold dark:text-gray-100 w-40">Tujuan Perusahaan</span>
                                <span class="text-gray-600 dark:text-gray-400">: <span id="vendorPurpose"
                                        name="company_goal">{{ $orderCommunication->vendor->business_type ?? '-' }}</span></span>
                            </div>
                        </div>

                    </div>

                    <!-- Tabel -->
                    <div class="p-2">
                        <div class="overflow-x-auto bg-white dark:bg-gray-700 rounded-lg">
                            <!-- Table -->
                            <table class="min-w-full text-left text-sm whitespace-nowrap">
                                <!-- Table head -->
                                <thead class="tracking-wider border-b-2 dark:border-neutral-600 border-t">
                                    <tr>
                                        <th scope="col"
                                            class="px-3 py-3 border-x dark:border-neutral-600 w-12 text-center">
                                            No
                                        </th>
                                        <th scope="col" class="px-3 py-3 border-x dark:border-neutral-600 w-24">
                                            Tanggal
                                        </th>
                                        <th scope="col" class="px-3 py-3 border-x dark:border-neutral-600 w-32">
                                            No Document
                                        </th>
                                        <th scope="col" class="px-3 py-3 border-x dark:border-neutral-600 w-32">
                                            Uraian
                                        </th>
                                        <th scope="col" class="px-3 py-3 border-x dark:border-neutral-600 w-40">
                                            Dari
                                        </th>
                                        <th scope="col" class="px-3 py-3 border-x dark:border-neutral-600 w-40">
                                            Kepada
                                        </th>
                                        <th scope="col"
                                            class="px-3 py-3 border-x dark:border-neutral-600 w-32 text-right">
                                            Action
                                        </th>
                                    </tr>
                                </thead>

                                <!-- Table body -->
                                <tbody>
                                    <tr
                                        class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">1</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            <span class="flex justify-center items-center h-full">
                                                {{ \Carbon\Carbon::parse($workRequests->created_at)->format('m/d/Y') }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{ $workRequests->request_number }}</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Formulir Permintaan
                                            Pengadaan
                                            Barang Jasa</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{ $workRequests->user->department }}</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                            <div class="flex justify-end">
                                                <a
                                                    href="{{ route('work_request.print-form-request', $workRequests->id) }}">
                                                    <x-button.button-action color="blue" icon="print">
                                                        Download
                                                    </x-button.button-action>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr
                                        class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">2</td>
                                        {{-- <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="date" name="date_applicationletter"
                                            value="{{ $orderCommunication->date_applicationletter }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                            onchange="updateField('date_applicationletter', this.value)">
                                    </td> --}}

                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{-- EDIT MODE --}}
                                            <input x-show="isEdit" type="date" name="date_applicationletter"
                                                value="{{ $orderCommunication->date_applicationletter ? \Carbon\Carbon::parse($orderCommunication->date_applicationletter)->toDateString() : '' }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_applicationletter', this.value)">

                                            {{-- VIEW MODE --}}
                                            <span x-show="!isEdit" class="flex justify-center items-center h-full">
                                                {{ $orderCommunication->date_applicationletter
                                                    ? \Carbon\Carbon::parse($orderCommunication->date_applicationletter)->format('m/d/Y')
                                                    : '-' }}
                                            </span>
                                        </td>

                                        <td class="px-3 py-4 border-x dark:border-neutral-600"
                                            name="no_applicationletter">
                                            {{ $orderCommunication->no_applicationletter ?? '-' }}
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Surat Permohonan
                                            Permintaan
                                            Harga</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                            {{ $orderCommunication->company_name ?? ($orderCommunication->vendor->name ?? 'Otomatis Nama Vendor') }}
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                            <div class="flex justify-end">
                                                <a
                                                    href="{{ route('work_request.print-application', $workRequests->id) }}">
                                                    <x-button.button-action color="blue" icon="print">
                                                        Download
                                                    </x-button.button-action>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>

                                    <tr
                                        class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">3</td>
                                        {{-- <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            <input type="date" name="date_offerletter"
                                                value="{{ $orderCommunication->date_offerletter }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_offerletter', this.value)">
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            <input type="text" name="no_offerletter" placeholder="Isi data..."
                                                value="{{ $orderCommunication->no_offerletter }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('no_offerletter', this.value)">
                                        </td> --}}
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{-- EDIT MODE --}}
                                            <input x-show="isEdit" type="date" name="date_offerletter"
                                                value="{{ $orderCommunication->date_offerletter ? \Carbon\Carbon::parse($orderCommunication->date_offerletter)->toDateString() : '' }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_offerletter', this.value)">

                                            {{-- VIEW MODE --}}
                                            <span x-show="!isEdit" class="flex justify-center items-center h-full">
                                                {{ $orderCommunication->date_offerletter
                                                    ? \Carbon\Carbon::parse($orderCommunication->date_offerletter)->format('m/d/Y')
                                                    : '-' }}
                                            </span>
                                        </td>

                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{-- EDIT MODE --}}
                                            <input x-show="isEdit" type="text" name="no_offerletter"
                                                placeholder="Isi data..."
                                                value="{{ $orderCommunication->no_offerletter ?? '' }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('no_offerletter', this.value)">

                                            {{-- VIEW MODE --}}
                                            <span x-show="!isEdit" class="flex justify-center items-center h-full">
                                                {{ $orderCommunication->no_offerletter ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Surat Penawaran Harga
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                            {{ $orderCommunication->company_name ?? ($orderCommunication->vendor->name ?? 'Otomatis Nama Vendor') }}
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                            <div class="flex justify-end" id="file_offerletter_container">
                                                @if ($orderCommunication->file_offerletter)
                                                    <x-button.button-action color="yellow" icon="eye"
                                                        onclick="viewFile('file_offerletter')">
                                                        Lihat
                                                    </x-button.button-action>
                                                    <x-button.button-action color="red" icon="trash"
                                                        class="ml-2" onclick="deleteFile('file_offerletter')">
                                                        Hapus
                                                    </x-button.button-action>
                                                @else
                                                    <x-button.button-action color="teal" icon="upload"
                                                        onclick="uploadFile('file_offerletter')">
                                                        Upload
                                                    </x-button.button-action>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <tr
                                        class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">4</td>
                                        {{-- <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            <input type="date" name="date_evaluationletter"
                                                value="{{ $orderCommunication->date_evaluationletter }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_evaluationletter', this.value)">
                                        </td> --}}
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{-- EDIT MODE --}}
                                            <input x-show="isEdit" type="date" name="date_evaluationletter"
                                                value="{{ $orderCommunication->date_evaluationletter ? \Carbon\Carbon::parse($orderCommunication->date_evaluationletter)->toDateString() : '' }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_evaluationletter', this.value)">

                                            {{-- VIEW MODE --}}
                                            <span x-show="!isEdit" class="flex justify-center items-center h-full">
                                                {{ $orderCommunication->date_evaluationletter
                                                    ? \Carbon\Carbon::parse($orderCommunication->date_evaluationletter)->format('m/d/Y')
                                                    : '-' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600"
                                            name="no_evaluationletter">
                                            {{ $orderCommunication->no_evaluationletter ?? '-' }}</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Evaluasi Teknis
                                            Penawaran
                                            Mitra</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{ $workRequests->user->department }}</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                            <div class="flex justify-end space-x-2"
                                                id="file_evaluationletter_container">
                                                @if ($orderCommunication->file_evaluationletter)
                                                    <x-button.button-action color="yellow" icon="eye"
                                                        onclick="viewFile('file_evaluationletter')">
                                                        Lihat
                                                    </x-button.button-action>
                                                    <x-button.button-action color="red" icon="trash"
                                                        class="ml-2" onclick="deleteFile('file_evaluationletter')">
                                                        Hapus
                                                    </x-button.button-action>
                                                @else
                                                    <x-button.button-action color="teal" icon="upload"
                                                        onclick="uploadFile('file_evaluationletter')">
                                                        Upload
                                                    </x-button.button-action>
                                                    <a
                                                        href="{{ route('work_request.print-evaluation', $workRequests->id) }}">
                                                        <x-button.button-action color="blue" icon="print">
                                                            Download
                                                        </x-button.button-action>
                                                    </a>
                                                @endif

                                            </div>

                                        </td>
                                    </tr>

                                    <tr
                                        class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">5</td>
                                        {{-- <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            <input type="date" name="date_negotiationletter"
                                                value="{{ $orderCommunication->date_negotiationletter }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_negotiationletter', this.value)">
                                        </td> --}}
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{-- EDIT MODE --}}
                                            <input x-show="isEdit" type="text" name="no_negotiationletter"
                                                placeholder="Isi data..."
                                                value="{{ $orderCommunication->no_negotiationletter ?? '' }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('no_negotiationletter', this.value)">

                                            {{-- VIEW MODE --}}
                                            <span x-show="!isEdit" class="flex justify-center items-center h-full">
                                                {{ $orderCommunication->no_negotiationletter ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600"
                                            name="no_negotiationletter">
                                            {{ $orderCommunication->no_negotiationletter ?? '-' }}</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Surat undangan
                                            klarifikasi
                                            dan negoisasi harga</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                            {{ $orderCommunication->company_name ?? ($orderCommunication->vendor->name ?? 'Otomatis Nama Vendor') }}
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                            <div class="flex justify-end">
                                                <a
                                                    href="{{ route('work_request.print-negotiation', $workRequests->id) }}">
                                                    <x-button.button-action color="blue" icon="print">
                                                        Download
                                                    </x-button.button-action>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr
                                        class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">6</td>
                                        {{-- <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            <input type="date" name="date_beritaacaraklarifikasi"
                                                value="{{ $orderCommunication->date_beritaacaraklarifikasi }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_beritaacaraklarifikasi', this.value)">
                                        </td> --}}
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{-- EDIT MODE --}}
                                            <input x-show="isEdit" type="date" name="date_beritaacaraklarifikasi"
                                                value="{{ $orderCommunication->date_beritaacaraklarifikasi ? \Carbon\Carbon::parse($orderCommunication->date_beritaacaraklarifikasi)->toDateString() : '' }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_beritaacaraklarifikasi', this.value)">

                                            {{-- VIEW MODE --}}
                                            <span x-show="!isEdit" class="flex justify-center items-center h-full">
                                                {{ $orderCommunication->date_beritaacaraklarifikasi
                                                    ? \Carbon\Carbon::parse($orderCommunication->date_beritaacaraklarifikasi)->format('m/d/Y')
                                                    : '-' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600"
                                            name="no_beritaacaraklarifikasi">
                                            {{ $orderCommunication->no_beritaacaraklarifikasi ?? '-' }}
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Berita Acara Klarifikasi
                                            &
                                            Negoisasi Harga</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                            {{ $orderCommunication->company_name ?? ($orderCommunication->vendor->name ?? 'Otomatis Nama Vendor') }}
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                            <div class="flex justify-end space-x-2"
                                                id="file_beritaacaraklarifikasi_container">
                                                @if ($orderCommunication->file_beritaacaraklarifikasi)
                                                    <x-button.button-action color="yellow" icon="eye"
                                                        onclick="viewFile('file_beritaacaraklarifikasi')">
                                                        Lihat
                                                    </x-button.button-action>
                                                    <x-button.button-action color="red" icon="trash"
                                                        class="ml-2"
                                                        onclick="deleteFile('file_beritaacaraklarifikasi')">
                                                        Hapus
                                                    </x-button.button-action>
                                                @else
                                                    <x-button.button-action color="teal" icon="upload"
                                                        onclick="uploadFile('file_beritaacaraklarifikasi')">
                                                        Upload
                                                    </x-button.button-action>
                                                    <a
                                                        href="{{ route('work_request.print-beritaacaraklarifikasi', $workRequests->id) }}">
                                                        <x-button.button-action color="blue" icon="print">
                                                            Download
                                                        </x-button.button-action>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <tr
                                        class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">7</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{-- <input type="date" name="date_beritaacaraklarifikasi"
                                            value="{{ $orderCommunication->date_beritaacaraklarifikasi }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                            onchange="updateField('date_beritaacaraklarifikasi', this.value)"> --}}
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600"
                                            name="no_beritaacaraklarifikasi">
                                            {{ $orderCommunication->no_beritaacaraklarifikasi ?? '-' }}
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Lampiran Berita Acara
                                            Klarifikasi &
                                            Negoisasi Harga</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                            {{ $orderCommunication->company_name ?? ($orderCommunication->vendor->name ?? 'Otomatis Nama Vendor') }}
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                            <div class="flex justify-end space-x-2"
                                                id="file_lampiranberitaacaraklarifikasi_container">
                                                @if ($orderCommunication->file_lampiranberitaacaraklarifikasi)
                                                    <x-button.button-action color="yellow" icon="eye"
                                                        onclick="viewFile('file_lampiranberitaacaraklarifikasi')">
                                                        Lihat
                                                    </x-button.button-action>
                                                    <x-button.button-action color="red" icon="trash"
                                                        class="ml-2"
                                                        onclick="deleteFile('file_lampiranberitaacaraklarifikasi')">
                                                        Hapus
                                                    </x-button.button-action>
                                                @else
                                                    <x-button.button-action color="teal" icon="upload"
                                                        onclick="uploadFile('file_lampiranberitaacaraklarifikasi')">
                                                        Upload
                                                    </x-button.button-action>
                                                    <a
                                                        href="{{ route('work_request.print-lampiranberitaacaraklarifikasi', $workRequests->id) }}">
                                                        <x-button.button-action color="blue" icon="print">
                                                            Download
                                                        </x-button.button-action>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <tr
                                        class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">8</td>
                                        {{-- <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            <input type="date" name="date_suratpenunjukan"
                                                value="{{ $orderCommunication->date_suratpenunjukan }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_suratpenunjukan', this.value)">
                                        </td> --}}
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{-- EDIT MODE --}}
                                            <input x-show="isEdit" type="date" name="date_suratpenunjukan"
                                                value="{{ $orderCommunication->date_suratpenunjukan ? \Carbon\Carbon::parse($orderCommunication->date_suratpenunjukan)->toDateString() : '' }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_suratpenunjukan', this.value)">

                                            {{-- VIEW MODE --}}
                                            <span x-show="!isEdit" class="flex justify-center items-center h-full">
                                                {{ $orderCommunication->date_suratpenunjukan
                                                    ? \Carbon\Carbon::parse($orderCommunication->date_suratpenunjukan)->format('m/d/Y')
                                                    : '-' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600"
                                            name="no_suratpenunjukan">
                                            {{ $orderCommunication->no_suratpenunjukan ?? '-' }}</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Surat Penunjukan
                                            Penyedia
                                            Barang/Jasa</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                            {{ $orderCommunication->company_name ?? ($orderCommunication->vendor->name ?? 'Otomatis Nama Vendor') }}
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                            <div class="flex justify-end space-x-2"
                                                id="file_suratpenunjukan_container">
                                                @if ($orderCommunication->file_suratpenunjukan)
                                                    <a
                                                        href="{{ route('work_request.print-suratpenunjukan', $workRequests->id) }}">
                                                        <x-button.button-action color="yellow" icon="eye">
                                                            Lihat
                                                        </x-button.button-action>
                                                    </a>
                                                    <x-button.button-action color="red" icon="trash"
                                                        class="ml-2" onclick="deleteFile('file_suratpenunjukan')">
                                                        Hapus
                                                    </x-button.button-action>
                                                @else
                                                    <x-button.button-action color="teal" icon="upload"
                                                        onclick="uploadFile('file_suratpenunjukan')">
                                                        Upload
                                                    </x-button.button-action>
                                                    <a
                                                        href="{{ route('work_request.print-suratpenunjukan', $workRequests->id) }}">
                                                        <x-button.button-action color="blue" icon="print">
                                                            Download
                                                        </x-button.button-action>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <tr
                                        class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">9</td>
                                        {{-- <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            <input type="date" name="date_bentukperikatan"
                                                value="{{ $orderCommunication->date_bentukperikatan }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_bentukperikatan', this.value)">
                                        </td> --}}
                                        {{-- <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            <input type="text" name="no_bentukperikatan" placeholder="Isi data..."
                                                value="{{ $orderCommunication->no_bentukperikatan }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('no_bentukperikatan', this.value)">
                                        </td> --}}
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{-- EDIT MODE --}}
                                            <input x-show="isEdit" type="date" name="date_bentukperikatan"
                                                value="{{ $orderCommunication->date_bentukperikatan ? \Carbon\Carbon::parse($orderCommunication->date_bentukperikatan)->toDateString() : '' }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_bentukperikatan', this.value)">

                                            {{-- VIEW MODE --}}
                                            <span x-show="!isEdit" class="flex justify-center items-center h-full">
                                                {{ $orderCommunication->date_bentukperikatan
                                                    ? \Carbon\Carbon::parse($orderCommunication->date_bentukperikatan)->format('m/d/Y')
                                                    : '-' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{-- EDIT MODE --}}
                                            <input x-show="isEdit" type="text" name="no_bentukperikatan"
                                                placeholder="Isi data..."
                                                value="{{ $orderCommunication->no_bentukperikatan ?? '' }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('no_bentukperikatan', this.value)">

                                            {{-- VIEW MODE --}}
                                            <span x-show="!isEdit" class="flex justify-center items-center h-full">
                                                {{ $orderCommunication->no_bentukperikatan ?? '-' }}
                                            </span>
                                        </td>

                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Bentuk Perikatan
                                            Perjanjian/SPK/PO</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                            {{ $orderCommunication->company_name ?? ($orderCommunication->vendor->name ?? 'Otomatis Nama Vendor') }}
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                            <div class="flex justify-end" id="file_bentukperikatan_container">
                                                @if ($orderCommunication->file_bentukperikatan)
                                                    <x-button.button-action color="yellow" icon="eye"
                                                        onclick="viewFile('file_bentukperikatan')">
                                                        Lihat
                                                    </x-button.button-action>
                                                    <x-button.button-action color="red" icon="trash"
                                                        class="ml-2" onclick="deleteFile('file_bentukperikatan')">
                                                        Hapus
                                                    </x-button.button-action>
                                                @else
                                                    <x-button.button-action color="teal" icon="upload"
                                                        onclick="uploadFile('file_bentukperikatan')">
                                                        Upload
                                                    </x-button.button-action>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <tr
                                        class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">10</td>
                                        {{-- <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            <input type="date" name="date_bap"
                                                value="{{ $orderCommunication->date_bap }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_bap', this.value)">
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            <input type="text" name="no_bap" placeholder="Isi data..."
                                                value="{{ $orderCommunication->no_bap }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('no_bap', this.value)">
                                        </td> --}}
                                        {{-- Kolom Tanggal BAP --}}
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{-- EDIT MODE --}}
                                            <input x-show="isEdit" type="date" name="date_bap"
                                                value="{{ $orderCommunication->date_bap ? \Carbon\Carbon::parse($orderCommunication->date_bap)->toDateString() : '' }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_bap', this.value)">

                                            {{-- VIEW MODE --}}
                                            <span x-show="!isEdit" class="flex justify-center items-center h-full">
                                                {{ $orderCommunication->date_bap ? \Carbon\Carbon::parse($orderCommunication->date_bap)->format('m/d/Y') : '-' }}
                                            </span>
                                        </td>

                                        {{-- Kolom Nomor BAP --}}
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{-- EDIT MODE --}}
                                            <input x-show="isEdit" type="text" name="no_bap"
                                                placeholder="Isi data..."
                                                value="{{ $orderCommunication->no_bap ?? '' }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('no_bap', this.value)">

                                            {{-- VIEW MODE --}}
                                            <span x-show="!isEdit" class="flex justify-center items-center h-full">
                                                {{ $orderCommunication->no_bap ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Berita Acara Pemeriksaan
                                            Pekerjaan (BAP)</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                            {{ $orderCommunication->company_name ?? ($orderCommunication->vendor->name ?? 'Otomatis Nama Vendor') }}
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                            <div class="flex justify-end" id="file_bap_container">
                                                @if ($orderCommunication->file_bap)
                                                    <x-button.button-action color="yellow" icon="eye"
                                                        onclick="viewFile('file_bap')">
                                                        Lihat
                                                    </x-button.button-action>
                                                    <x-button.button-action color="red" icon="trash"
                                                        class="ml-2" onclick="deleteFile('file_bap')">
                                                        Hapus
                                                    </x-button.button-action>
                                                @else
                                                    <x-button.button-action color="teal" icon="upload"
                                                        onclick="uploadFile('file_bap')">
                                                        Upload
                                                    </x-button.button-action>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <tr
                                        class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">11</td>
                                        {{-- <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            <input type="date" name="date_bast"
                                                value="{{ $orderCommunication->date_bast }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_bast', this.value)">
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            <input type="text" name="no_bast" placeholder="Isi data..."
                                                value="{{ $orderCommunication->no_bast }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('no_bast', this.value)">
                                        </td> --}}
                                        {{-- Kolom Tanggal BAST --}}
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{-- EDIT MODE --}}
                                            <input x-show="isEdit" type="date" name="date_bast"
                                                value="{{ $orderCommunication->date_bast ? \Carbon\Carbon::parse($orderCommunication->date_bast)->toDateString() : '' }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('date_bast', this.value)">

                                            {{-- VIEW MODE --}}
                                            <span x-show="!isEdit" class="flex justify-center items-center h-full">
                                                {{ $orderCommunication->date_bast
                                                    ? \Carbon\Carbon::parse($orderCommunication->date_bast)->format('m/d/Y')
                                                    : '-' }}
                                            </span>
                                        </td>

                                        {{-- Kolom Nomor BAST --}}
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">
                                            {{-- EDIT MODE --}}
                                            <input x-show="isEdit" type="text" name="no_bast"
                                                placeholder="Isi data..."
                                                value="{{ $orderCommunication->no_bast ?? '' }}"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1"
                                                onchange="updateField('no_bast', this.value)">

                                            {{-- VIEW MODE --}}
                                            <span x-show="!isEdit" class="flex justify-center items-center h-full">
                                                {{ $orderCommunication->no_bast ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Berita Acara Serah
                                            Terima
                                            Pekerjaan (BAST)</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                            {{ $orderCommunication->company_name ?? ($orderCommunication->vendor->name ?? 'Otomatis Nama Vendor') }}
                                        </td>
                                        <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                            <div class="flex justify-end" id="file_bast_container">
                                                @if ($orderCommunication->file_bast)
                                                    <x-button.button-action color="yellow" icon="eye"
                                                        onclick="viewFile('file_bast')">
                                                        Lihat
                                                    </x-button.button-action>
                                                    <x-button.button-action color="red" icon="trash"
                                                        class="ml-2" onclick="deleteFile('file_bast')">
                                                        Hapus
                                                    </x-button.button-action>
                                                @else
                                                    <x-button.button-action color="teal" icon="upload"
                                                        onclick="uploadFile('file_bast')">
                                                        Upload
                                                    </x-button.button-action>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk Upload Surat Penunjukan -->
        <div id="uploadSuratPenunjukanModal"
            class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-11/12 md:w-1/2 lg:w-1/3 max-h-screen overflow-y-auto">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Upload Surat Penunjukan
                        Penyedia Barang/Jasa</h3>

                    <form id="uploadSuratPenunjukanForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="nilaikontrak_suratpenunjukan"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Nilai Kontrak
                            </label>
                            <input type="number" id="nilaikontrak_suratpenunjukan"
                                name="nilaikontrak_suratpenunjukan"
                                value="{{ $orderCommunication->nilaikontrak_suratpenunjukan ?? '' }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md 
                                  bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring focus:ring-blue-300 dark:focus:ring-blue-700"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="file_suratpenunjukan_input"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                File Surat Penunjukan
                            </label>
                            <input type="file" id="file_suratpenunjukan_input" name="file"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md 
                                  bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-100 focus:outline-none focus:ring focus:ring-blue-300 dark:focus:ring-blue-700"
                                accept=".pdf,.doc,.docx,.xls,.xlsx" required>
                        </div>

                        <div class="flex justify-end space-x-2 mt-6">
                            <button type="button" onclick="closeUploadSuratPenunjukanModal()"
                                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-100 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            window.IS_EDIT = {{ $isEdit ? 'true' : 'false' }};
        </script>
        <script>
            // CSRF Token untuk AJAX
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const orderCommId = {{ $orderCommunication->id }};
            const workRequestId = {{ $workRequests->id }};

            // Toggle vendor dropdown
            function toggleVendorDropdown() {
                document.getElementById("vendorDropdown").classList.toggle("hidden");
            }

            // Filter vendor dropdown
            function filterVendorDropdown() {
                let input = document.getElementById("vendorInput").value.toLowerCase();
                let items = document.querySelectorAll("#vendorDropdown li");

                items.forEach(item => {
                    const text = item.innerText.toLowerCase();
                    item.style.display = text.includes(input) ? "" : "none";
                });
            }


            // Function saat pilih vendor
            function selectVendor(id, name, address, purpose) {
                document.getElementById("vendorInput").value = name;
                document.getElementById("vendor_id").value = id;
                document.getElementById("vendorNameDisplay").textContent = name;
                document.getElementById("vendorAddress").textContent = address;
                document.getElementById("vendorPurpose").textContent = purpose;
                document.getElementById("vendorDropdown").classList.add("hidden");

                // Update semua sel dengan nama vendor
                const vendorCells = document.querySelectorAll('.vendor-name-cell');
                vendorCells.forEach(cell => {
                    cell.textContent = name;
                });

                // Simpan informasi vendor
                updateVendorInfo(id, name, address, purpose);
            }

            document.addEventListener('click', function(event) {
                const input = document.getElementById('vendorInput');
                const dropdown = document.getElementById('vendorDropdown');
                if (!input.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add("hidden");
                }
            });

            // Function untuk update field
            function updateField(field, value) {
                fetch(`/work_request/order_communication/${orderCommId}/update-field`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            field: field,
                            value: value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Data berhasil disimpan', 'success');
                        } else {
                            showNotification('Gagal menyimpan data', 'error');
                            console.log("DEBUG: gagal simpan", response);
                        }
                    })
                    .catch(error => {
                        showNotification('Terjadi kesalahan', 'error');
                    });
            }

            // Function untuk membuka modal upload surat penunjukan

            function openUploadSuratPenunjukanModal() {
                document.getElementById('uploadSuratPenunjukanModal').classList.remove('hidden');
            }

            // Function untuk menutup modal upload surat penunjukan
            function closeUploadSuratPenunjukanModal() {
                document.getElementById('uploadSuratPenunjukanModal').classList.add('hidden');
            }

            // Event listener untuk form upload surat penunjukan
            document.getElementById('uploadSuratPenunjukanForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData();
                formData.append('field', 'file_suratpenunjukan');
                formData.append('file', document.getElementById('file_suratpenunjukan_input').files[0]);
                formData.append('nilaikontrak_suratpenunjukan', document.getElementById('nilaikontrak_suratpenunjukan')
                    .value);

                fetch(`/work_request/order_communication/${orderCommId}/upload`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('File berhasil diupload', 'success');
                            closeUploadSuratPenunjukanModal();
                            // Update UI untuk menampilkan file yang diupload
                            updateFileUI('file_suratpenunjukan', data.file_name);
                        } else {
                            showNotification('Gagal upload file', 'error');
                        }
                    })
                    .catch(error => {
                        showNotification('Terjadi kesalahan', 'error');
                    });
            });

            // Function untuk upload file
            function uploadFile(field) {
                if (field === 'file_suratpenunjukan') {
                    openUploadSuratPenunjukanModal();
                    return;
                }
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = '*/*';

                input.onchange = function(e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    const formData = new FormData();
                    formData.append('field', field);
                    formData.append('file', file);

                    fetch(`/work_request/order_communication/${orderCommId}/upload`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showNotification('File berhasil diupload', 'success');
                                // Update UI untuk menampilkan file yang diupload
                                updateFileUI(field, data.file_name);
                            } else {
                                showNotification('Gagal upload file', 'error');
                            }
                        })
                        .catch(error => {
                            showNotification('Terjadi kesalahan', 'error');
                        });
                };

                input.click();
            }

            // Function untuk delete file
            function deleteFile(field) {
                if (!confirm('Apakah Anda yakin ingin menghapus file ini?' +
                        (field === 'file_suratpenunjukan' ? ' Nilai kontrak juga akan dihapus.' : ''))) return;


                fetch(`/work_request/order_communication/${orderCommId}/delete-file`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            field: field
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('File berhasil dihapus', 'success');
                            // Update UI setelah hapus file
                            updateFileUI(field, null);
                        } else {
                            showNotification('Gagal menghapus file', 'error');
                        }
                    })
                    .catch(error => {
                        showNotification('Terjadi kesalahan', 'error');
                    });
            }

            // Function untuk view file
            function viewFile(field) {
                window.open(`/work_request/order_communication/${orderCommId}/view-file/${field}`, '_blank');
            }

            // Function untuk update vendor info
            function updateVendorInfo(vendorId, name, address, purpose) {
                fetch(`/work_request/order_communication/${orderCommId}/update-vendor`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            vendor_id: vendorId,
                            company_name: name,
                            company_address: address,
                            company_goal: purpose
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Informasi vendor berhasil disimpan', 'success');
                        } else {
                            showNotification('Gagal menyimpan informasi vendor', 'error');
                        }
                    })
                    .catch(error => {
                        showNotification('Terjadi kesalahan', 'error');
                    });
            }

            // routes download
            const downloadRoutes = {
                file_evaluationletter: "{{ route('work_request.print-evaluation', $workRequests->id) }}",
                file_beritaacaraklarifikasi: "{{ route('work_request.print-beritaacaraklarifikasi', $workRequests->id) }}",
                file_lampiranberitaacaraklarifikasi: "{{ route('work_request.print-lampiranberitaacaraklarifikasi', $workRequests->id) }}",
                file_suratpenunjukan: "{{ route('work_request.print-suratpenunjukan', $workRequests->id) }}"
            };

            // Function untuk update UI file
            function updateFileUI(field, fileName) {
                const container = document.getElementById(`${field}_container`);
                if (container) {
                    if (fileName) {
                        if (field === 'file_suratpenunjukan') {
                            // Tampilan khusus untuk file_suratpenunjukan
                            container.innerHTML = `
                            <a href="{{ route('work_request.print-suratpenunjukan', $workRequests->id) }}">
                                <x-button.button-action color="yellow" icon="eye">
                                    Lihat
                                </x-button.button-action>
                            </a>
                            <x-button.button-action color="red" icon="trash" class="ml-2" onclick="deleteFile('${field}')">
                                Hapus
                            </x-button.button-action>
                        `;
                        } else {
                            // Tampilan standar untuk file lainnya
                            container.innerHTML = `
                            <x-button.button-action color="yellow" icon="eye" onclick="viewFile('${field}')">
                                Lihat
                            </x-button.button-action>
                            <x-button.button-action color="red" icon="trash" class="ml-2" onclick="deleteFile('${field}')">
                                Hapus
                            </x-button.button-action>
                        `;
                        }
                    } else {
                        // Tampilkan tombol Upload (dan Download untuk field tertentu)
                        if (field === 'file_beritaacaraklarifikasi' || field === 'file_evaluationletter' || field ===
                            'file_lampiranberitaacaraklarifikasi' || field === 'file_suratpenunjukan') {
                            container.innerHTML = `
                    <div class="flex justify-center space-x-2">
                        <x-button.button-action color="blue" icon="upload" onclick="uploadFile('${field}')">
                            Upload
                        </x-button.button-action>
                        <a href="${downloadRoutes[field]}" target="_blank">
                            <x-button.button-action color="blue" icon="print">
                                Download
                            </x-button.button-action>
                         </a>
                    </div>
                `;
                        } else {
                            container.innerHTML = `
                    <x-button.button-action color="blue" icon="upload" onclick="uploadFile('${field}')">
                        Upload
                    </x-button.button-action>
                `;
                        }
                    }
                }
            }

            // Function untuk show notification
            function showNotification(message, type) {
                // Implementasi notifikasi sederhana
                const notification = document.createElement('div');
                notification.className = `fixed bottom-4 right-4 p-4 rounded-md shadow-md text-white ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }

            // Event listeners untuk auto-save
            document.addEventListener('DOMContentLoaded', function() {
                // Input fields untuk data teks
                const inputFields = document.querySelectorAll('input[type="date"], input[type="text"]');
                inputFields.forEach(input => {
                    // Skip jika sudah ada event listener
                    if (!input.hasAttribute('data-has-listener')) {
                        input.setAttribute('data-has-listener', 'true');
                        input.addEventListener('change', function() {
                            updateField(this.name, this.value);
                        });
                    }
                });
            });
        </script>
    </div>
</x-app-layout>
