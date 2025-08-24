@props(['workRequest'])

<!-- Modal Upload File Spesification -->
<div x-data="{ modalOpen: false, files: [] }">
    <!-- Button Open Modal -->
    <x-button.button-action @click="modalOpen = true" color="yellow" type="button" icon="add-document"
        showTextOnMobile="true">
        Upload File Spesification
    </x-button.button-action>

    <!-- Backdrop + Dialog -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-30 z-50 flex items-center justify-center" x-show="modalOpen" x-cloak>
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg max-w-lg w-full"
            @click.outside="modalOpen = false">

            <div class="flex justify-center items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    Upload File Spesification
                </h3>
            </div>

            <form action="{{ route('work_request.work_spesification_files.store', ['id' => $workRequest->id]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-4">
                    <!-- Input file -->
                    <div x-data @change="files = Array.from($event.target.files)">
                        <x-label for="files" value="{{ __('Pilih File') }}" />

                        <input id="files" name="files[]" type="file"
                            class="mt-1 block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-amber-500 file:text-white hover:file:bg-amber-600 dark:file:bg-amber-600 dark:hover:file:bg-amber-500"
                            multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.zip,.rar" />

                        <x-input-error for="files" class="mt-2" />
                        <x-input-error for="files.*" class="mt-2" />

                        <!-- Preview list -->
                        <template x-if="files.length">
                            <ul
                                class="mt-3 space-y-1 text-sm text-gray-700 dark:text-gray-200 max-h-40 overflow-auto border rounded-md p-3 dark:border-gray-700/60">
                                <template x-for="(f, idx) in files" :key="idx">
                                    <li class="flex items-center justify-between">
                                        <span x-text="f.name"></span>
                                        <span class="text-xs text-gray-500"
                                            x-text="(f.size/1024).toFixed(1) + ' KB'"></span>
                                    </li>
                                </template>
                            </ul>
                        </template>

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Format yang didukung: PDF, DOC/DOCX, XLS/XLSX, JPG/PNG, ZIP/RAR. Maks. 10MB per file.
                        </p>
                    </div>

                    <!-- (Opsional) Catatan/Keterangan umum untuk batch upload -->
                    <div>
                        <x-label for="note" value="{{ __('Catatan (opsional)') }}" />
                        <textarea id="note" name="note" rows="2"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100"
                            placeholder="Tambahkan catatan untuk file yang diunggah (opsional)">{{ old('note') }}</textarea>
                        <x-input-error for="note" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <x-button.button-action color="red" type="button" @click="modalOpen = false">
                        Batal
                    </x-button.button-action>

                    <x-button.button-action color="teal" type="submit">
                        Upload
                    </x-button.button-action>
                </div>
            </form>
        </div>
    </div>
</div>
