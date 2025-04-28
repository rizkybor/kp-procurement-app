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
    <div class="mt-4 md:mt-4 md:col-span-2">
        <div class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <strong>Bagian / Divisi:</strong> {{ $workRequest->department }}
                </div>
                <div>
                    <strong>Nomor:</strong> {{ $workRequest->request_number }}
                </div>
                <div>
                    <strong>Judul Proyek:</strong> {{ $workRequest->project_title }}
                </div>
                <div>
                    <strong>Tanggal:</strong> {{ $workRequest->request_date }}
                </div>
                <div>
                    <strong>Pemilik Proyek:</strong> {{ $workRequest->project_owner }}
                </div>
                <div>
                    <strong>Tenggat:</strong> {{ $workRequest->deadline }}
                </div>
                <div>
                    <strong>No Kontrak:</strong> {{ $workRequest->contract_number }}
                </div>
                <div>
                    <strong>PIC:</strong> {{ $workRequest->pic }}
                </div>
                <div>
                    <strong>Jenis Pengadaan:</strong> {{ $workRequest->procurement_type }}
                </div>
                <div>
                    <strong>Aanwijzing:</strong> {{ $workRequest->aanwijzing }}
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
    </div>
    <div class="grid grid-cols-12 gap-6 mt-4">

        <!-- Card (Customers) -->
        <x-documents.table-request-show :workRequest="$workRequest" :itemRequest="$itemRequest" />

    </div>
@endsection
