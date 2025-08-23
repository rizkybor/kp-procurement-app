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
                    : {{ $workRequest->contract_type ?? 'Lorem Ipsum' }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-gray-600 dark:text-gray-300 w-56">Mekanisme Pembayaran</span>
                <span class="text-amber-500 font-medium">
                    : {{ $workRequest->payment_mechanism ?? 'Lorem Ipsum' }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-gray-600 dark:text-gray-300 w-48">Jangka Waktu Pekerjaan</span>
                <span class="text-amber-500 font-medium">
                    : {{ $workRequest->work_duration ?? 'Lorem Ipsum' }}
                </span>
            </div>
        </div>

        {{-- @php
            $files = collect($specRequest ?? [])->loadMissing('files')->pluck('files')->flatten(1);
            $rowNo = 1;
        @endphp --}}

        <!-- Tabel File -->
        <div class="overflow-x-auto border border-gray-100 dark:border-gray-700/60 rounded-xl">
            <table class="table-auto w-full">
                <thead
                    class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="p-3 text-left w-20">No</th>
                        <th class="p-3 text-left">Nama File</th>
                        <th class="p-3 text-center w-32">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                    {{-- isi body  --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
