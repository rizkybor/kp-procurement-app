@extends('pages.work-request.work-request-details.show')

@section('content')
    {{-- Information Dokumen --}}

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <!-- Left: Title -->
        <h1 class="text-lg md:text-xl text-gray-800 dark:text-gray-100 font-bold">
            Informasi Dokumen
        </h1>
    </div>
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
            <span class="font-semibold mr-2">Bagian / Divisi:</span>
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
            <span class="font-semibold mr-2">Internal / Keproyekan:</span>
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

    {{-- End Information Dokumen --}}

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-8">
        <!-- Left: Title -->
        <h1 class="text-lg md:text-xl text-gray-800 dark:text-gray-100 font-bold">
            Permintaan Barang
        </h1>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-4">

        <!-- Card (Customers) -->
        <x-documents.table-request-show :workRequest="$workRequest" :itemRequest="$itemRequest" />

    </div>
@endsection
