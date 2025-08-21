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

                    <div class="space-y-2">
                        <div class="flex">
                            <span class="font-semibold dark:text-gray-100 w-40">Nama Perusahaan</span>
                            <span class="text-gray-600 dark:text-gray-400">: <span
                                    id="vendorNameDisplay">-</span></span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold dark:text-gray-100 w-40">Alamat Perusahaan</span>
                            <span class="text-gray-600 dark:text-gray-400">: <span id="vendorAddress">-</span></span>
                        </div>
                        <div class="flex">
                            <span class="font-semibold dark:text-gray-100 w-40">Tujuan Perusahaan</span>
                            <span class="text-gray-600 dark:text-gray-400">: <span id="vendorPurpose">-</span></span>
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
                                        {{ \Carbon\Carbon::parse($workRequests->created_at)->translatedFormat('d F Y') }}
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
                                        <input type="date" name="tanggal"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">-</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Surat Permohonan Permintaan
                                        Harga</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">Otomatis
                                        Nama Vendor</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center">
                                            <x-button.button-action color="blue" icon="print">
                                                Download
                                            </x-button.button-action>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">3</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="date" name="tanggal"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="text" name="custom_field" placeholder="Isi data..."
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Surat Penawaran Harga</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">Otomatis
                                        Nama Vendor</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center">
                                            <x-button.button-action color="blue" icon="upload">
                                                Upload
                                            </x-button.button-action>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">4</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="date" name="tanggal"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">-</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Evaluasi Teknis Penawaran
                                        Mitra</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        {{ $workRequests->user->department }}</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center">
                                            <x-button.button-action color="blue" icon="print">
                                                Download
                                            </x-button.button-action>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">5</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        <input type="date" name="tanggal"
                                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-2 py-1">
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">-</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Surat undangan klarifikasi
                                        dan negoisasi harga</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">Otomatis
                                        Nama Vendor</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center">
                                            <x-button.button-action color="blue" icon="print">
                                                Download
                                            </x-button.button-action>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">6</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        -
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">-</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Berita Acara Klarifikasi &
                                        Negoisasi Harga</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">Otomatis
                                        Nama Vendor</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center">
                                            <x-button.button-action color="blue" icon="upload">
                                                Upload
                                            </x-button.button-action>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">7</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        -
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">-</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Surat Penunjukan Penyedia
                                        Barang/Jasa</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">Otomatis
                                        Nama Vendor</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center">
                                            <x-button.button-action color="blue" icon="print">
                                                Download
                                            </x-button.button-action>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">8</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        -
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">-</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Bentuk Perikatan
                                        Perjanjian/SPK/PO</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">Otomatis
                                        Nama Vendor</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center">
                                            <x-button.button-action color="blue" icon="upload">
                                                Upload
                                            </x-button.button-action>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">9</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        -
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">-</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Berita Acara Pemeriksaan
                                        Pekerjaan (BAP)</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">Otomatis
                                        Nama Vendor</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center">
                                            <x-button.button-action color="blue" icon="upload">
                                                Upload
                                            </x-button.button-action>
                                        </div>
                                    </td>
                                </tr>

                                <tr class="border-b dark:border-neutral-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">10</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">
                                        -
                                    </td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">-</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Berita Acara Serah Terima
                                        Pekerjaan (BAST)</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600">Fungsi Pengadaan</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 vendor-name-cell">Otomatis
                                        Nama Vendor</td>
                                    <td class="px-3 py-4 border-x dark:border-neutral-600 text-center">
                                        <div class="flex justify-center">
                                            <x-button.button-action color="blue" icon="upload">
                                                Upload
                                            </x-button.button-action>
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
        }

        document.addEventListener('click', function(event) {
            const input = document.getElementById('vendorInput');
            const dropdown = document.getElementById('vendorDropdown');
            if (!input.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add("hidden");
            }
        });
    </script>
</x-app-layout>
