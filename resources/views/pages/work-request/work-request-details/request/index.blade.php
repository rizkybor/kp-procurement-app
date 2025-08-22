@extends('pages.work-request.work-request-details.edit')

@section('content')
    {{-- Information Dokumen --}}

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <!-- Left: Title -->
        <h1 class="text-lg md:text-xl text-gray-800 dark:text-gray-100 font-bold">
            Informasi Dokumen
        </h1>
        <!-- Right: Buttons -->
        <div class="flex gap-2 mt-4 sm:mt-0">
            <x-modal.request-information.modal-edit-request-information :workRequest="$workRequest" :keproyekanList="$keproyekanList"
                :typeProcurementList="$typeProcurementList" />
        </div>
    </div>
    <div class="mt-4 md:mt-4 md:col-span-2">
        <div class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <!-- Row full untuk Nama Pekerjaan -->
            <div class="flex flex-col sm:flex-row sm:items-center border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">
                <span class="font-semibold w-auto mr-2">Nama Pekerjaan:</span>
                <span class="text-gray-900 dark:text-gray-100 flex-1">
                    {{ $workRequest->work_name_request }}
                </span>
            </div>

            <!-- Grid info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="flex sm:items-center">
                    <span class="font-semibold mr-2">Bagian/Divisi:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1">
                        {{ $workRequest->department }}
                    </span>
                </div>

                <div class="flex sm:items-center">
                    <span class="font-semibold mr-2">Nomor Permintaan:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1">
                        {{ $workRequest->request_number }}
                    </span>
                </div>

                <div class="flex sm:items-center">
                    <span class="font-semibold mr-2">Judul Proyek:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1">
                        {{ $workRequest->project_title }}
                    </span>
                </div>

                <div class="flex sm:items-center">
                    <span class="font-semibold mr-2">Tanggal:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1">
                        {{ $workRequest->request_date }}
                    </span>
                </div>

                <div class="flex sm:items-center">
                    <span class="font-semibold mr-2">Internal/Keproyekan:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1">
                        {{ $workRequest->project_type }}
                    </span>
                </div>

                <div class="flex sm:items-center">
                    <span class="font-semibold mr-2">Tenggat:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1">
                        {{ $workRequest->deadline }}
                    </span>
                </div>

                <div class="flex sm:items-center">
                    <span class="font-semibold mr-2">Jenis Pengadaan:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1">
                        {{ $workRequest->procurement_type }}
                    </span>
                </div>

                <div class="flex sm:items-center">
                    <span class="font-semibold mr-2">PIC:</span>
                    <span class="text-gray-900 dark:text-gray-100 flex-1">
                        {{ $workRequest->pic }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- End Information Dokumen --}}

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-8">
        <!-- Left: Title -->
        <h1 class="text-lg md:text-xl text-gray-800 dark:text-gray-100 font-bold">
            Permintaan Barang
        </h1>

        <!-- Right: Buttons -->
        <div class="flex gap-2 mt-4 sm:mt-0">
            {{-- Button Download Template  --}}
            <x-button.button-action type="button"
                onclick="window.location.href='{{ route('work_request.work_request_items.template', $workRequest->id) }}'">
                Download Template
            </x-button.button-action>

            {{-- Button Import Template  --}}
            <x-modal.request-item.import-file-item :workRequest="$workRequest" />

            {{-- Button Add Manual  --}}
            <x-modal.request-item.modal-create-request-item :workRequest="$workRequest" />
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-4">

        <!-- Card (Customers) -->
        <x-documents.table-request :workRequest="$workRequest" :itemRequest="$itemRequest" />

    </div>
@endsection
