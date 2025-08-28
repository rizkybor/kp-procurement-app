<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <!-- Left: Title -->
            <h1 class="text-xl md:text-2xl text-gray-800 dark:text-gray-100 font-bold">
                ORCOM (Order Communication)
            </h1>
        </div>
        <div class="grid grid-cols-12 gap-6">

            <!-- Card (Customers) -->
            <div class="col-span-full xl:col-span-12 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
                <!-- Header -->
                <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60 grid grid-cols-12 gap-2">
                    <h2 class="font-semibold dark:text-gray-100 py-1 col-span-12">
                        ORCOM (Order Communication)
                    </h2>
                    <h2 class="font-semibold dark:text-gray-100 py-1 col-span-12">
                        {{ $workRequests->work_name_request }}
                    </h2>
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
                                oninput="filterVendorDropdown()" onclick="toggleVendorDropdown()" autocomplete="off" />

                            <input type="hidden" id="vendor_id" name="vendor_id" value="" />

                            <ul id="vendorDropdown"
                                class="absolute z-10 w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 
                    rounded-md mt-1 max-h-60 overflow-auto shadow-md hidden transition-all">
                                <!-- Daftar vendor -->
                                @foreach ($vendors as $vendor)
                                    <li class="px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-all"
                                        onclick="selectVendor('{{ $vendor['id'] }}', '{{ $vendor['name'] }}', '{{ $vendor['address'] }}', '{{ $vendor['type'] }}')">
                                        <div class="font-semibold text-gray-800 dark:text-gray-200">
                                            {{ $vendor['name'] }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $vendor['address'] }}
                                        </div>
                                        <div class="text-xs text-blue-600 dark:text-blue-400 mt-1">{{ $vendor['type'] }}
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
                                    name="company_name">{{ $orderCommunication->company_name ?? '-' }}</span></span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold dark:text-gray-100 w-40">Alamat Perusahaan</span>
                            <span class="text-gray-600 dark:text-gray-400">: <span id="vendorAddress"
                                    name="company_address">{{ $orderCommunication->company_address ?? '-' }}</span></span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold dark:text-gray-100 w-40">Tujuan Perusahaan</span>
                            <span class="text-gray-600 dark:text-gray-400">: <span id="vendorPurpose"
                                    name="company_goal">{{ $orderCommunication->company_goal ?? '-' }}</span></span>
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
                                    <th scope="col" class="px-3 py-3 border-x dark:border-neutral-600 min-w-[200px]">
                                        Uraian
                                    </th>
                                    <th scope="col" class="px-3 py-3 border-x dark:border-neutral-600 w-40">
                                        Dari
                                    </th>
                                    <th scope="col" class="px-3 py-3 border-x dark:border-neutral-600 w-40">
                                        Kepada
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 border-x dark:border-neutral-600 w-32 text-center">
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <!-- Table body -->
                            <tbody>
                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">1</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <span class="flex justify-center items-center h-full">
                                            {{ \Carbon\Carbon::parse($workRequests->created_at)->format('m/d/Y') }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        {{ $workRequests->request_number }}</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Formulir Permintaan Pengadaan
                                        Barang Jasa</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        {{ $workRequests->user->department }}</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center">
                                            <x-button.button-action color="blue" icon="print">
                                                Download
                                            </x-button.button-action>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">2</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="date" name="date_applicationletter"
                                            value="{{ $orderCommunication->date_applicationletter }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600" name="no_applicationletter">
                                        {{ $orderCommunication->no_applicationletter ?? '-' }}
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Surat Permohonan Permintaan
                                        Harga</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                        {{ $orderCommunication->company_name ?? 'Otomatis Nama Vendor' }}
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center">
                                            <a href="{{ route('work_request.print-application', $workRequests->id) }}">
                                                <x-button.button-action color="blue" icon="print">
                                                    Download
                                                </x-button.button-action>
                                            </a>

                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">3</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="date" name="date_offerletter"
                                            value="{{ $orderCommunication->date_offerletter }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="text" name="no_offerletter" placeholder="Isi data..."
                                            value="{{ $orderCommunication->no_offerletter }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Surat Penawaran Harga</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                        {{ $orderCommunication->company_name ?? 'Otomatis Nama Vendor' }}
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center" id="file_offerletter_container">
                                            @if ($orderCommunication->file_offerletter)
                                                <x-button.button-action color="yellow" icon="eye"
                                                    onclick="viewFile('file_offerletter')">
                                                    Lihat
                                                </x-button.button-action>
                                                <x-button.button-action color="red" icon="trash" class="ml-2"
                                                    onclick="deleteFile('file_offerletter')">
                                                    Hapus
                                                </x-button.button-action>
                                            @else
                                                <x-button.button-action color="blue" icon="upload"
                                                    onclick="uploadFile('file_offerletter')">
                                                    Upload
                                                </x-button.button-action>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">4</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="date" name="date_evaluationletter"
                                            value="{{ $orderCommunication->date_evaluationletter }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600" name="no_evaluationletter">
                                        {{ $orderCommunication->no_evaluationletter ?? '-' }}</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Evaluasi Teknis Penawaran
                                        Mitra</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        {{ $workRequests->user->department }}</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <x-button.button-action color="blue" icon="upload"
                                                onclick="uploadFile('file_offerletter')">
                                                Upload
                                            </x-button.button-action>
                                            <x-button.button-action color="blue" icon="print">
                                                Download
                                            </x-button.button-action>
                                        </div>

                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">5</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="date" name="date_negotiationletter"
                                            value="{{ $orderCommunication->date_negotiationletter }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600"
                                        name="no_negotiationletter">
                                        {{ $orderCommunication->no_negotiationletter ?? '-' }}</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Surat undangan klarifikasi
                                        dan negoisasi harga</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                        {{ $orderCommunication->company_name ?? 'Otomatis Nama Vendor' }}
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center">
                                            <a
                                                href="{{ route('work_request.print-negotiation', $workRequests->id) }}">
                                                <x-button.button-action color="blue" icon="print">
                                                    Download
                                                </x-button.button-action>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">6</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="date" name="date_beritaacaraklarifikasi"
                                            value="{{ $orderCommunication->date_beritaacaraklarifikasi }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600"
                                        name="no_beritaacaraklarifikasi">
                                        {{ $orderCommunication->no_beritaacaraklarifikasi ?? '-' }}
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Berita Acara Klarifikasi &
                                        Negoisasi Harga</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                        {{ $orderCommunication->company_name ?? 'Otomatis Nama Vendor' }}
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center" id="file_beritaacaraklarifikasi_container">
                                            @if ($orderCommunication->file_beritaacaraklarifikasi)
                                                <x-button.button-action color="yellow" icon="eye"
                                                    onclick="viewFile('file_beritaacaraklarifikasi')">
                                                    Lihat
                                                </x-button.button-action>
                                                <x-button.button-action color="red" icon="trash" class="ml-2"
                                                    onclick="deleteFile('file_beritaacaraklarifikasi')">
                                                    Hapus
                                                </x-button.button-action>
                                            @else
                                                <div class="flex justify-center space-x-2">
                                                    <x-button.button-action color="blue" icon="upload"
                                                        onclick="uploadFile('file_beritaacaraklarifikasi')">
                                                        Upload
                                                    </x-button.button-action>
                                                    <x-button.button-action color="blue" icon="print">
                                                        Download
                                                    </x-button.button-action>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">7</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="date" name="date_suratpenunjukan"
                                            value="{{ $orderCommunication->date_suratpenunjukan }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600" name="no_suratpenunjukan">
                                        {{ $orderCommunication->no_suratpenunjukan ?? '-' }}</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Surat Penunjukan Penyedia
                                        Barang/Jasa</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                        {{ $orderCommunication->company_name ?? 'Otomatis Nama Vendor' }}
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <x-button.button-action color="blue" icon="upload"
                                                onclick="uploadFile('file_beritaacaraklarifikasi')">
                                                Upload
                                            </x-button.button-action>
                                            <x-button.button-action color="blue" icon="print">
                                                Download
                                            </x-button.button-action>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">8</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="date" name="date_bentukperikatan"
                                            value="{{ $orderCommunication->date_bentukperikatan }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="text" name="no_bentukperikatan" placeholder="Isi data..."
                                            value="{{ $orderCommunication->no_bentukperikatan }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Bentuk Perikatan
                                        Perjanjian/SPK/PO</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                        {{ $orderCommunication->company_name ?? 'Otomatis Nama Vendor' }}
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center" id="file_bentukperikatan_container">
                                            @if ($orderCommunication->file_bentukperikatan)
                                                <x-button.button-action color="yellow" icon="eye"
                                                    onclick="viewFile('file_bentukperikatan')">
                                                    Lihat
                                                </x-button.button-action>
                                                <x-button.button-action color="red" icon="trash" class="ml-2"
                                                    onclick="deleteFile('file_bentukperikatan')">
                                                    Hapus
                                                </x-button.button-action>
                                            @else
                                                <x-button.button-action color="blue" icon="upload"
                                                    onclick="uploadFile('file_bentukperikatan')">
                                                    Upload
                                                </x-button.button-action>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">9</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="date" name="date_bap"
                                            value="{{ $orderCommunication->date_bap }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="text" name="no_bap" placeholder="Isi data..."
                                            value="{{ $orderCommunication->no_bap }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Berita Acara Pemeriksaan
                                        Pekerjaan (BAP)</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                        {{ $orderCommunication->company_name ?? 'Otomatis Nama Vendor' }}
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center" id="file_bap_container">
                                            @if ($orderCommunication->file_bap)
                                                <x-button.button-action color="yellow" icon="eye"
                                                    onclick="viewFile('file_bap')">
                                                    Lihat
                                                </x-button.button-action>
                                                <x-button.button-action color="red" icon="trash" class="ml-2"
                                                    onclick="deleteFile('file_bap')">
                                                    Hapus
                                                </x-button.button-action>
                                            @else
                                                <x-button.button-action color="blue" icon="upload"
                                                    onclick="uploadFile('file_bap')">
                                                    Upload
                                                </x-button.button-action>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">10</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="date" name="date_bast"
                                            value="{{ $orderCommunication->date_bast }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="text" name="no_bast" placeholder="Isi data..."
                                            value="{{ $orderCommunication->no_bast }}"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Berita Acara Serah Terima
                                        Pekerjaan (BAST)</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">
                                        {{ $orderCommunication->company_name ?? 'Otomatis Nama Vendor' }}
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center" id="file_bast_container">
                                            @if ($orderCommunication->file_bast)
                                                <x-button.button-action color="yellow" icon="eye"
                                                    onclick="viewFile('file_bast')">
                                                    Lihat
                                                </x-button.button-action>
                                                <x-button.button-action color="red" icon="trash" class="ml-2"
                                                    onclick="deleteFile('file_bast')">
                                                    Hapus
                                                </x-button.button-action>
                                            @else
                                                <x-button.button-action color="blue" icon="upload"
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
            updateVendorInfo({
                name,
                address,
                type: purpose
            });
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
                    }
                })
                .catch(error => {
                    showNotification('Terjadi kesalahan', 'error');
                });
        }

        // Function untuk upload file
        function uploadFile(field) {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '.pdf,.doc,.docx,.jpg,.jpeg,.png';

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
            if (!confirm('Apakah Anda yakin ingin menghapus file ini?')) return;

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
        function updateVendorInfo(vendorData) {
            fetch(`/work_request/order_communication/${orderCommId}/update-vendor`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        company_name: vendorData.name,
                        company_address: vendorData.address,
                        company_goal: vendorData.type
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

        // Function untuk update UI file
        function updateFileUI(field, fileName) {
            const container = document.getElementById(`${field}_container`);
            if (container) {
                if (fileName) {
                    container.innerHTML = `
                        <x-button.button-action color="yellow" icon="eye" onclick="viewFile('${field}')">
                            Lihat
                        </x-button.button-action>
                        <x-button.button-action color="red" icon="trash" class="ml-2" onclick="deleteFile('${field}')">
                            Hapus
                        </x-button.button-action>
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
                input.addEventListener('change', function() {
                    updateField(this.name, this.value);
                });
            });
        });
    </script>
</x-app-layout>
