<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto ">

        <!-- Navbar-style tabs -->
        <div class="border-b mb-8">
            <div class="mb-4">
                <div class="flex justify-between items-center">
                    <!-- Tabs -->
                    <div class="flex space-x-8">
                        <a href="{{ route('work_request.work_request_items.edit', ['id' => $workRequest]) }}"
                            class="text-xl text-gray-800 dark:text-gray-100 pb-2 
                            {{ request()->routeIs('work_request.work_request_items.edit') ? 'font-bold border-b-2 border-teal-600' : 'hover:text-teal-600 hover:border-b-2 hover:border-teal-600' }}">
                            Form Request
                        </a>

                        <a href="{{ route('work_request.work_rabs.edit', ['id' => $workRequest]) }}"
                            class="text-xl text-gray-800 dark:text-gray-100 pb-2 
                            {{ request()->routeIs('work_request.work_rabs.edit') ? 'font-bold border-b-2 border-teal-600' : 'hover:text-teal-600 hover:border-b-2 hover:border-teal-600' }}">
                            Form RAB
                        </a>
                        <a href=""
                            class="text-xl text-gray-800 dark:text-gray-100 pb-2 
                            {{ request()->routeIs('') ? 'font-bold border-b-2 border-teal-600' : 'hover:text-teal-600 hover:border-b-2 hover:border-teal-600' }}">
                            Form Spesification
                        </a>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <x-button.button-action color="red" type="button"
                            onclick="window.location='{{ route('work_request.index') }}'">
                            Kembali
                        </x-button.button-action>

                        <x-button.button-action color="teal" type="button" onclick="window.location=''">
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
