<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <!-- Left: Title -->
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">
                Dokumen Pengadaan
            </h1>

            <!-- Right: Buttons -->
            <div class="flex gap-2 mt-4 sm:mt-0">
                <x-button.button-action color="teal" type="button"
                    onclick="window.location='{{ route('work_request.create') }}'">
                    + Data Baru
                </x-button.button-action>
            </div>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-12 gap-6">

            <!-- Card (Customers) -->
            <x-documents.table-index :workRequest="$workRequest" />

        </div>

    </div>
</x-app-layout>
