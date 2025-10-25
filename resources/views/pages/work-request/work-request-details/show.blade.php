<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Status Dokumen & Button Back -->
        <div class="flex flex-col sm:flex-row sm:justify-between mb-8">
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


            <div class="sm:w-full">
                <!-- Kanan (Tombol) -->
                <div class="flex flex-col gap-2 mt-5">
                    <!-- Row tombol (Riwayat + Kembali) -->
                    <div class="flex justify-end gap-2 mb-3">
                        <x-secondary-button onclick="openHistoryModal({{ $workRequest->id }})">
                            Riwayat Dokumen
                        </x-secondary-button>

                        <x-button.secondary-button onclick="window.location='{{ route('work_request.index') }}'">
                            Kembali
                        </x-button.secondary-button>
                    </div>
                    <div class="flex justify-end gap-2">
                        <!-- Row bawah: Komponen Header -->
                        <x-documents.header :workRequest="$workRequest" isShowPage="true" :document_status="$workRequest['status']" :latestApprover="$latestApprover" />
                    </div>
                </div>



            </div>

        </div>

 {{-- Alerts --}}
    @if (session('success'))
        <div role="alert"
             class="mb-4 flex items-center justify-between p-4 rounded-lg border border-green-400 bg-green-50 dark:bg-green-900/40 text-green-800 dark:text-green-100">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600 dark:text-green-300" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button type="button" aria-label="Close"
                    class="text-green-600 dark:text-green-300 hover:text-green-800 dark:hover:text-green-100"
                    onclick="this.closest('[role=alert]').remove()">✕</button>
        </div>
    @endif

    @if (session('error'))
        <div role="alert"
             class="mb-4 flex items-center justify-between p-4 rounded-lg border border-red-400 bg-red-50 dark:bg-red-900/40 text-red-800 dark:text-red-100">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-600 dark:text-red-300" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button type="button" aria-label="Close"
                    class="text-red-600 dark:text-red-300 hover:text-red-800 dark:hover:text-red-100"
                    onclick="this.closest('[role=alert]').remove()">✕</button>
        </div>
    @endif
    
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

<x-documents.histories :workRequest="$workRequest" />
