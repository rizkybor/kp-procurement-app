<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Status Dokumen & Button Back -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <!-- Kiri -->
            <div class="w-full sm:w-1/2 bg-white dark:bg-gray-800 shadow-sm rounded-lg p-5">
                <div class="grid grid-cols-2 gap-4">
                    {{-- Dibuat Oleh --}}
                    <div>
                        <x-label for="transaction_status" value="{{ __('Dibuat Oleh') }}"
                            class="text-gray-800 dark:text-gray-100" />
                        <p class="text-m md:text-m text-gray-800 dark:text-gray-100 font-bold">
                            {{ $workRequest->user->name }} ({{ $workRequest->user->department }})
                        </p>
                    </div>

                    {{-- Status Dokumen --}}
                    <div>
                        <x-label for="document_status" value="{{ __('Status Dokumen') }}"
                            class="text-gray-800 dark:text-gray-100" />
                        <x-label-status :status="$workRequest->status" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    {{-- Total RAB --}}
                    <div>
                        <x-label for="transaction_status" value="{{ __('Total RAB') }}"
                            class="text-gray-800 dark:text-gray-100" />
                        <p class="text-m md:text-m text-gray-800 dark:text-gray-100 font-bold">
                            Rp. {{ number_format($totalRab, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Kanan (Tombol) -->
            <div class="flex justify-start sm:justify-end gap-2 mt-5">
                <x-button.secondary-button onclick="window.location='{{ route('work_request.index') }}'">
                    Kembali
                </x-button.secondary-button>
            </div>
        </div>

        <!-- Navbar-style tabs -->
        <div class="border-b mb-8">
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <!-- Tabs (Hidden on mobile) -->
                    <div class="hidden md:flex space-x-8">
                        <a href="{{ route('work_request.work_request_items.show', $workRequest->id) }}"
                            class="text-xl text-gray-800 dark:text-gray-100 pb-2 
                            {{ request()->routeIs('work_request.work_request_items.show') ? 'font-bold border-b-2 border-teal-600' : 'hover:text-teal-600 hover:border-b-2 hover:border-teal-600' }}">
                            Form Request
                        </a>

                        <a href="{{ route('work_request.work_rabs.show', $workRequest->id) }}"
                            class="text-xl text-gray-800 dark:text-gray-100 pb-2 
                            {{ request()->routeIs('work_request.work_rabs.show') ? 'font-bold border-b-2 border-teal-600' : 'hover:text-teal-600 hover:border-b-2 hover:border-teal-600' }}">
                            Form RAB
                        </a>

                        <a href="{{ route('work_request.work_spesifications.show', $workRequest->id) }}"
                            class="text-xl text-gray-800 dark:text-gray-100 pb-2 
                            {{ request()->routeIs('work_request.work_spesifications.show') ? 'font-bold border-b-2 border-teal-600' : 'hover:text-teal-600 hover:border-b-2 hover:border-teal-600' }}">
                            Form Spesification
                        </a>
                    </div>

                    <!-- Dropdown Menu for Mobile -->
                    <div class="md:hidden relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="text-xl text-gray-800 dark:text-gray-100 pb-2 flex items-center">
                            Menu
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute left-0 mt-2 w-48 bg-white dark:bg-gray-800 shadow-md rounded-lg py-2 z-50">
                            <a href="{{ route('work_request.work_request_items.show', $workRequest->id) }}"
                                class="block px-4 py-2 text-gray-800 dark:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-700">
                                Form Request
                            </a>
                            <a href="{{ route('work_request.work_rabs.show', $workRequest->id) }}"
                                class="block px-4 py-2 text-gray-800 dark:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-700">
                                Form RAB
                            </a>
                            <a href="{{ route('work_request.work_spesifications.show', $workRequest->id) }}"
                                class="block px-4 py-2 text-gray-800 dark:text-gray-100 hover:bg-gray-200 dark:hover:bg-gray-700">
                                Form Spesification
                            </a>
                        </div>
                    </div>

                    <!-- Actions -->
                    <x-documents.header :workRequest="$workRequest" isShowPage="true" :document_status="$workRequest['status']"
                        :latestApprover=$latestApprover />
                </div>
            </div>
        </div>
        <!-- Actions -->

        {{-- Content based on selected tab --}}
        <div>
            @yield('content')
        </div>
    </div>
</x-app-layout>
