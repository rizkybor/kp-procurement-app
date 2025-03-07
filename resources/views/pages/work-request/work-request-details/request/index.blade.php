@extends('pages.documents.document-details.edit')
@section('content')
    {{-- Information Dokumen --}}
    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="grid grid-cols-2 grid-rows-5 gap-4">
                <div>
                    <div>
                        <div><strong>Bagian / Divisi:</strong></div>
                    </div>
                </div>
                <div>
                    <div>
                        <strong>Nomor:</strong>
                    </div>
                </div>
                <div>
                    <div>
                        <strong>Judul Proyek:</strong>
                    </div>
                </div>
                <div>
                    <div>
                        <strong>Tanggal:</strong>
                    </div>
                </div>
                <div>
                    <div>
                        <strong>Pemilik Proyek:</strong>
                    </div>
                </div>
                <div>
                    <div>
                        <strong>Tenggat:</strong>
                    </div>
                </div>
                <div>
                    <div>
                        <strong>No Kontrak:</strong>
                    </div>
                </div>
                <div>
                    <div>
                        <strong>PIC:</strong>
                    </div>
                </div>
                <div>
                    <div>
                        <strong>Jenis Pengadaan:</strong>
                    </div>
                </div>
                <div>
                    <div>
                        <strong>Aanwijzing:</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End Information Dokumen --}}

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-8">
        <!-- Left: Title -->
        <h1 class="text-lg md:text-xl text-gray-800 dark:text-gray-100 font-bold">
            Dokumen Pengadaan
        </h1>
        <!-- Right: Buttons -->
        <div class="flex gap-2 mt-4 sm:mt-0">
            <x-button.button-action color="teal" type="button" onclick="window.location=' '">
                + Items
            </x-button.button-action>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-4">

        <!-- Card (Customers) -->
        <x-documents.table-request />

    </div>
@endsection
