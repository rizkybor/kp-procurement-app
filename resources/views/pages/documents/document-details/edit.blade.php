<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto ">

        <!-- Navbar-style tabs -->
        <div class="border-b mb-8">
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <!-- Tabs -->
                    <div class="flex space-x-8">
                        <a href="{{ route('docs-pengadaan_request.index') }}"
                            class="text-xl text-gray-800 dark:text-gray-100 font-bold hover:text-violet-600 border-b-2 border-transparent hover:border-violet-600 pb-2">
                            Form Request
                        </a>
                        <a href="{{ route('docs-pengadaan_rab.index') }}"
                            class="text-xl text-gray-800 dark:text-gray-100 hover:text-violet-600 border-b-2 border-transparent hover:border-violet-600 pb-2">
                            Form RAB
                        </a>
                        <a href=""
                            class="text-xl text-gray-800 dark:text-gray-100 hover:text-violet-600 border-b-2 border-transparent hover:border-violet-600 pb-2">
                            Form Spesification
                        </a>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <x-button.button-action color="red" type="button"
                            onclick="window.location='{{ route('docs-pengadaan') }}'">
                            Kembali
                        </x-button.button-action>

                        <x-button.button-action color="violet" type="button"
                            onclick="window.location='{{ route('docs-pengadaan.edit') }}'">
                            Proccess
                        </x-button.button-action>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content based on selected tab --}}
        <div>
            @yield('content')
        </div>

    </div>
</x-app-layout>
