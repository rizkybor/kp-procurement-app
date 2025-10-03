@props(['specRequest', 'workRequest'])

<div class="col-span-full xl:col-span-12 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
    <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60">
        <h2 class="font-semibold dark:text-gray-100">Form Spesificationnya</h2>
    </header>

    <div class="p-5 space-y-6">
        <!-- Spesifikasi Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-center gap-3">
                <span class="text-gray-600 dark:text-gray-300 w-48">Tipe Kontrak</span>
                <span class="text-amber-500 font-medium">
                    : {{ $specRequest->contract_type ?? 'Lorem Ipsum' }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-gray-600 dark:text-gray-300 w-56">Mekanisme Pembayaran</span>
                <span class="text-amber-500 font-medium">
                    : {{ $specRequest->payment_mechanism ?? 'Lorem Ipsum' }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-gray-600 dark:text-gray-300 w-48">Jangka Waktu Pekerjaan</span>
                <span class="text-amber-500 font-medium">
                    : {{ $specRequest->work_duration ?? 'Lorem Ipsum' }}
                </span>
            </div>
        </div>

        {{-- @php
            $files = collect($specRequest ?? [])->loadMissing('files')->pluck('files')->flatten(1);
            $rowNo = 1;
        @endphp --}}

        <!-- Tabel File -->
        <div class="overflow-x-auto border border-gray-100 dark:border-gray-700/60 rounded-xl">
             <div
                class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700/60 bg-gray-50 dark:bg-gray-800/50 rounded-t-xl">
                {{-- Title --}}
                <h2 class="text-base md:text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                    File Specification
                </h2>
            </div>

            <table class="table-auto w-full">
                <thead
                    class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="p-3 text-left w-20">No</th>
                        <th class="p-3 text-left">Nama File</th>
                        <th class="p-3 text-left">Catatan</th>
                        <th class="p-3 text-center w-32">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                    @forelse($specRequest?->files ?? [] as $file)
                        <tr>
                            <td class="p-3">{{ $loop->iteration }}</td>
                            <td class="p-3">
                                <a href="{{ asset('storage/' . $file->path) }}" target="_blank"
                                    class="text-amber-600 hover:underline">
                                    {{ $file->original_name }}
                                </a>
                                <div class="text-xs text-gray-500">
                                    ({{ number_format($file->size / 1024, 1) }} KB)
                                </div>
                            </td>
                            <td class="p-3">{{ $file->description }}</td>
                            <td class="p-3">
                                <div class="flex flex-col sm:flex-row sm:justify-center gap-2">
                                    {{-- Download --}}
                                    <a href="{{ asset('storage/' . $file->path) }}" target="_blank"
                                        class="inline-flex items-center justify-center w-full sm:w-auto px-3 py-1.5 text-xs font-medium
                  rounded-md bg-teal-500 text-white hover:bg-teal-600
                  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500
                  dark:focus:ring-offset-gray-800">
                                        {{-- ikon optional --}}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                        </svg>
                                        Download
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-3 text-center text-gray-400">
                                Belum ada file diunggah
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
