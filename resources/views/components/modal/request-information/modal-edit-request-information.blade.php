@props(['workRequest'])

<!-- Modal for Adding Cost Details -->
<div x-data="{ modalOpen: false }">
    <!-- Button to Open Modal -->
    <x-button.button-action @click="modalOpen = true" color="yellow" icon="pencil" type="button">
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
                <div class="grid grid-cols-2 grid-rows-5 gap-4">
                    {{-- Bagian / Divisi --}}
                    <div>
                        <x-label for="department" value="{{ __('Bagian / Divisi') }}" />
                        <x-input id="department" type="text" name="department" class="mt-1 block w-full min-h-[40px]"
                            required autocomplete="department" placeholder="Masukkan bagian atau divisi"
                            value="{{ $workRequest->department }}" />
                        <x-input-error for="department" class="mt-2" />
                    </div>

                    {{-- Nomor --}}
                    <div>
                        <x-label for="request_number" value="{{ __('Nomor') }}" />
                        <x-input id="request_number" type="text"
                            class="block mt-1 w-full bg-gray-200 dark:bg-gray-700" name="request_number" required
                            autocomplete="request_number" value="{{ $workRequest->request_number }}" readonly />
                    </div>

                    {{-- Judul Proyek --}}
                    <div>
                        <x-label for="project_title" value="{{ __('Judul Proyek') }}" />
                        <x-input id="project_title" type="text" name="project_title"
                            class="mt-1 block w-full min-h-[40px]" required autocomplete="project_title"
                            placeholder="Masukkan judul proyek" value="{{ $workRequest->project_title }}" />
                        <x-input-error for="project_title" class="mt-2" />
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <x-label for="request_date" value="{{ __('Tanggal') }}" />
                        <x-input id="request_date" type="date" class="block mt-1 w-full bg-gray-200 dark:bg-gray-700"
                            name="request_date" required value="{{ $workRequest->request_date }}" readonly />
                    </div>

                    {{-- Pemilik Proyek --}}
                    <div>
                        <x-label for="project_owner" value="{{ __('Pemilik Proyek') }}" />
                        <x-input id="project_owner" type="text" name="project_owner"
                            class="mt-1 block w-full min-h-[40px]" required autocomplete="project_owner"
                            placeholder="Masukkan pemilik proyek" value="{{ $workRequest->project_owner }}" />
                        <x-input-error for="project_owner" class="mt-2" />
                    </div>

                    {{-- Tenggat --}}
                    <div>
                        <x-label for="deadline" value="{{ __('Tenggat') }}" />
                        <x-input id="deadline" type="date" name="deadline" class="mt-1 block w-full min-h-[40px]"
                            required autocomplete="deadline" placeholder="Masukkan tenggat"
                            min="{{ $workRequest->request_date }}" value="{{ $workRequest->deadline }}" />
                        <x-input-error for="deadline" class="mt-2" />
                    </div>

                    {{-- No Kontrak --}}
                    <div>
                        <x-label for="contract_number" value="{{ __('No Kontrak') }}" />
                        <x-input id="contract_number" type="text" name="contract_number"
                            class="mt-1 block w-full min-h-[40px]" required autocomplete="contract_number"
                            placeholder="Masukkan nomor kontrak" value="{{ $workRequest->contract_number }}" />
                        <x-input-error for="contract_number" class="mt-2" />
                    </div>

                    {{-- PIC --}}
                    <div>
                        <x-label for="pic" value="{{ __('PIC') }}" />
                        <x-input id="pic" type="text" name="pic" class="mt-1 block w-full min-h-[40px]"
                            required autocomplete="pic" placeholder="Masukkan pic" value="{{ $workRequest->pic }}" />
                        <x-input-error for="pic" class="mt-2" />
                    </div>

                    {{-- Jenis Pengadaan --}}
                    <div>
                        <x-label for="procurement_type" value="{{ __('Jenis Pengadaan') }}" />
                        <x-input id="procurement_type" type="text" name="procurement_type"
                            class="mt-1 block w-full min-h-[40px]" required autocomplete="procurement_type"
                            placeholder="Masukkan jenis pengadaan" value="{{ $workRequest->procurement_type }}" />
                        <x-input-error for="procurement_type" class="mt-2" />
                    </div>

                    {{-- Aanwijzing --}}
                    <div>
                        <x-label for="aanwijzing" value="{{ __('Aanwijzing') }}" />
                        <x-input id="aanwijzing" type="text" name="aanwijzing"
                            class="mt-1 block w-full min-h-[40px]" required autocomplete="aanwijzing"
                            placeholder="Masukkan aanwijzing" value="{{ $workRequest->aanwijzing }}" />
                        <x-input-error for="aanwijzing" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <x-button.button-action color="red" class="px-4 py-2 bg-gray-500 text-white rounded-md"
                        @click="modalOpen = false">Batal</x-button>
                        <x-button.button-action color="teal" type="submit">Simpan</x-button>
                </div>
            </form>
        </div>
    </div>
</div>
