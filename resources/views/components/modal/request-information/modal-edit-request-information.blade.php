@props(['workRequest', 'keproyekanList' => [], 'typeProcurementList' => []])

<!-- Modal for Adding Cost Details -->
<div x-data="{ modalOpen: false }">
    <!-- Button to Open Modal -->
    <x-button.button-action @click="modalOpen = true" color="yellow" icon="pencil" showTextOnMobile="true" type="button">
        Edit Informasi
    </x-button.button-action>
    <div class="fixed inset-0 bg-gray-900 bg-opacity-30 z-50 flex items-center justify-center" x-show="modalOpen" x-cloak>
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg max-w-lg w-full"
            @click.outside="modalOpen = false">
            <div class="flex justify-center items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Edit Informasi Dokumen</h3>
            </div>
            <form action="{{ route('work_request.update', $workRequest->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Nama Pekerjaan --}}
                    <div class="md:col-span-2">
                        <x-label for="work_name_request" value="{{ __('Nama Pekerjaan') }}" />
                        <x-input id="work_name_request" type="text" name="work_name_request"
                            class="mt-1 block w-full min-h-[40px]" required autocomplete="off"
                            placeholder="Masukkan nama pekerjaan" value="{{ $workRequest->work_name_request }}" />
                        <x-input-error for="work_name_request" class="mt-2" />
                    </div>

                    {{-- Bagian / Divisi --}}
                    <div>
                        <x-label for="department" value="{{ __('Bagian / Divisi') }}" />
                        <x-input id="department" type="text" name="department" class="mt-1 block w-full min-h-[40px]"
                            required autocomplete="organization" placeholder="Masukkan bagian atau divisi"
                            value="{{ $workRequest->department }}" />
                        <x-input-error for="department" class="mt-2" />
                    </div>

                    {{-- Nomor --}}
                    <div>
                        <x-label for="request_number" value="{{ __('Nomor') }}" />
                        <x-input id="request_number" type="text" name="request_number"
                            class="mt-1 block w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 cursor-not-allowed"
                            required autocomplete="off" value="{{ $workRequest->request_number }}" readonly />
                    </div>

                    {{-- Judul Proyek --}}
                    <div>
                        <x-label for="project_title" value="{{ __('Judul Proyek') }}" />
                        <x-input id="project_title" type="text" name="project_title"
                            class="mt-1 block w-full min-h-[40px]" required autocomplete="off"
                            placeholder="Masukkan judul proyek" value="{{ $workRequest->project_title }}" />
                        <x-input-error for="project_title" class="mt-2" />
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <x-label for="request_date" value="{{ __('Tanggal') }}" />
                        <x-input id="request_date" type="date" name="request_date"
                            class="mt-1 block w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 cursor-not-allowed"
                            required value="{{ $workRequest->request_date }}" readonly />
                    </div>


                    {{-- Jenis Pengadaan --}}
                    <div>
                        <x-label for="procurement_type" value="{{ __('Jenis Pengadaan') }}" />
                        <select id="procurement_type" name="procurement_type"
                            class="mt-1 block w-full min-h-[40px] border-gray-300 rounded-md shadow-sm
               focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                            required>
                            <option value="">-- Pilih --</option>
                            @foreach ($typeProcurementList as $item)
                                <option value="{{ $item->name }}"
                                    {{ $workRequest->procurement_type === $item->name ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="procurement_type" class="mt-2" />
                    </div>

                    {{-- Tenggat --}}
                    <div>
                        <x-label for="deadline" value="{{ __('Tenggat') }}" />
                        <x-input id="deadline" type="date" name="deadline" class="mt-1 block w-full min-h-[40px]"
                            required min="{{ $workRequest->request_date }}" value="{{ $workRequest->deadline }}" />
                        <x-input-error for="deadline" class="mt-2" />
                    </div>

                    {{-- Internal / Keproyekan --}}
                    <div>
                        <x-label for="project_type" value="{{ __('Internal / Keproyekan') }}" />
                        <select id="project_type" name="project_type"
                            class="mt-1 block w-full min-h-[40px] border-gray-300 rounded-md shadow-sm
               focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                            required>
                            <option value="">-- Pilih --</option>
                            @foreach ($keproyekanList as $item)
                                <option value="{{ $item->name }}"
                                    {{ $workRequest->project_type === $item->name ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error for="project_type" class="mt-2" />
                    </div>

                    {{-- PIC --}}
                    <div>
                        <x-label for="pic" value="{{ __('PIC') }}" />
                        <x-input id="pic" type="text" name="pic" class="mt-1 block w-full min-h-[40px]"
                            required autocomplete="name" placeholder="Masukkan PIC" value="{{ $workRequest->pic }}" />
                        <x-input-error for="pic" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <x-button.button-action color="red" class="px-4 py-2 bg-gray-500 text-white rounded-md"
                        @click="modalOpen = false">
                        Batal
                    </x-button.button-action>
                    <x-button.button-action color="teal" type="submit">
                        Simpan
                    </x-button.button-action>
                </div>
            </form>
        </div>
    </div>
</div>
