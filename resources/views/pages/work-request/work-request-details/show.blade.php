@php
    $printOptions = [
        [
            'label' => 'Surat Permintaan',
            'route' => route('work_request.print-form-request', $workRequest->id),
        ],
        [
            'label' => 'Surat Rab',
            'route' => route('work_request.print-rab', $workRequest->id),
        ],
    ];
@endphp

<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
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
                    <div class="flex gap-2">

                        <x-button.button-action color="red" type="button"
                            onclick="window.location='{{ route('work_request.index') }}'">
                            Kembali
                        </x-button.button-action>

                        <x-button.button-action color="yellow" type="button"
                            onclick="window.location='{{ route('work_request.work_request_items.edit', $workRequest->id) }}'">
                            Edit
                        </x-button.button-action>

                        <x-button.button-action color="green" icon="send"
                            data-action="{{ route('work_request.processApproval', $workRequest['id']) }}"
                            data-title="Process Document" data-button-text="Process"
                            data-button-color="bg-green-500 hover:bg-green-600 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-700"
                            onclick="openModal(this)">
                            Process
                        </x-button.button-action>

                        {{-- Cetak Dokumen --}}
                        <div x-data="{ open: false }" class="relative">
                            <x-button.button-action @click="open = !open" color="blue" icon="print">
                                Cetak Dokumen
                            </x-button.button-action>

                            <div x-show="open" @click.away="open = false"
                                class="absolute z-10 mt-2 bg-white border rounded-lg shadow-lg w-56">
                                <ul class="py-2 text-gray-700">
                                    @foreach ($printOptions as $option)
                                        <li>
                                            <a href="{{ $option['route'] }}" target="_blank"
                                                class="block px-4 py-2 hover:bg-blue-500 hover:text-white">
                                                {{ $option['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Structure -->
        {{-- <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-md mx-4">
                    <div class="p-6">
                        <h3 id="modalTitle" class="text-lg font-medium text-gray-900 dark:text-white mb-4"></h3>
                        <form id="modalForm" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="approval_note"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Note</label>
                                <textarea id="approval_note" name="approval_note" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-teal-500 focus:border-teal-500 dark:bg-gray-700 dark:text-white"></textarea>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="closeModal()"
                                    class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    Cancel
                                </button>
                                <button id="modalSubmitButton" type="submit"
                                    class="px-4 py-2 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
        <x-modal.global.modal-proccess-global :workRequest="$workRequest" />
        {{-- Content based on selected tab --}}
        <div>
            @yield('content')
        </div>
</x-app-layout>

<script>
    function openModal(button) {
        let actionRoute = button.getAttribute('data-action');
        let modalTitle = button.getAttribute('data-title');
        let buttonText = button.getAttribute('data-button-text');
        let buttonColor = button.getAttribute('data-button-color');

        document.querySelector('#modalForm').setAttribute('action', actionRoute);
        document.querySelector('#modalTitle').innerText = modalTitle;
        document.querySelector('#modalSubmitButton').innerText = buttonText;
        document.querySelector('#modalSubmitButton').setAttribute('data-button-color',
            buttonColor);
        document.querySelector('#modalSubmitButton').classList.remove('bg-green-500', 'hover:bg-green-600',
            'bg-orange-500', 'hover:bg-orange-600', 'dark:bg-orange-500', 'dark:hover:bg-orange-600',
            'dark:focus:ring-orange-700', 'dark:bg-green-500', 'dark:hover:bg-green-600',
            'dark:focus:ring-green-700');
        document.querySelector('#modalSubmitButton').classList.add(...buttonColor.split(' '));

        document.querySelector('#modalOverlay').classList.remove('hidden');
    }

    function closeModal() {
        document.querySelector('#modalOverlay').classList.add('hidden');
    }
</script>
