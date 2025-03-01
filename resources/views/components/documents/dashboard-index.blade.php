<div class="col-span-full xl:col-span-12 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
    <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60">
        {{-- <h2 class="font-semibold  dark:text-gray-100">List Dokument</h2> --}}
    </header>
    <div class="p-3">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead
                    class="text-xs font-semibold uppercase text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-700 dark:bg-opacity-50">
                    <tr>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">No</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">Nama Pekerjaan</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">Judul Proyek</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Pemilik Proyek</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">No. Kontrak</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Nomor</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Tanggal</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">PIC</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Action</div>
                        </th>

                    </tr>
                </thead>
                <!-- Table body -->
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                    <tr>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center">1</div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-left">Developer</div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-left">Judul Proyek</div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center">Handoko Siswandi</div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center">2 Bulan</div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center">0010.FP-KPU-07-2025</div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center">001-07-225</div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center">Aldy Remansyah</div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center flex items-center justify-center gap-2">
                                <x-button.button-action color="yellow" icon="pencil"
                                    onclick="window.location.href=''">Edit
                                </x-button.button-action>
                                <form action="" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-button.button-action color="red" icon="trash" type="submit">Hapus
                                    </x-button.button-action>
                                </form>


                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>
</div>
