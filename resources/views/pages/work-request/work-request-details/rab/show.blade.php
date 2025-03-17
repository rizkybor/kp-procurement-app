@extends('pages.work-request.work-request-details.show')
@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-8">
        <!-- Left: Title -->
        <h1 class="text-lg md:text-xl text-gray-800 dark:text-gray-100 font-bold">
            RAB
        </h1>
    </div>

    <div class="grid grid-cols-12 gap-6 mt-4">

        <!-- Card (Customers) -->
        <x-documents.table-rab-show :rabRequest="$rabRequest" :workRequest="$workRequest" :itemRequest="$itemRequest" :totalRab="$totalRab" />

    </div>
@endsection
