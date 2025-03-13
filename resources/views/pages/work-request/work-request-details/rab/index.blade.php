@extends('pages.work-request.work-request-details.edit')
@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-8">
        <!-- Left: Title -->
        <h1 class="text-lg md:text-xl text-gray-800 dark:text-gray-100 font-bold">
            Items RAB
        </h1>

        <!-- Right: Buttons -->
        <div class="flex gap-2 mt-4 sm:mt-0">
            <x-modal.request-rab.modal-create-request-rab :workRequest="$workRequest" :itemRequest="$itemRequest" />
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-4">

        <!-- Card (Customers) -->
        <x-documents.table-rab :rabRequest="$rabRequest" :workRequest="$workRequest" />

    </div>
@endsection
