@props(['workRequest'])

<div x-data="{ uploadOpen: false }">
    <x-button.button-action @click="uploadOpen = true" color="blue" type="button" icon="upload" showTextOnMobile="true">
        Import Template
    </x-button.button-action>

    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" x-show="uploadOpen" x-cloak
        @keydown.escape.window="uploadOpen = false">
        <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-2xl shadow-xl p-6"
            @click.outside="uploadOpen = false">
            <div class="text-lg font-semibold mb-4">Upload Excel Permintaan Barang</div>

            <form action="{{ route('work_request.work_request_items.import', $workRequest->id) }}" method="POST"
                enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="file" name="file"
                    accept=".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                    class="block w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                      file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"
                    required>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <x-button.button-action color="secondary" type="button" @click="uploadOpen = false"
                        class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700">Batal</x-button.button-action>
                    <x-button.button-action color="blue" type="submit"
                        class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">Import</x-button.button-action>
                </div>
            </form>

            <div class="mt-3 text-xs text-slate-500">
                Pastikan header: <strong>deskripsi, jumlah, satuan, keterangan</strong>.
            </div>
        </div>
    </div>
</div>
