@props(['workRequest'])

<!-- Modal for Adding Cost Details -->
<div x-data="{ modalOpen: false }">
    <!-- Button to Open Modal -->
    <x-button.button-action @click="modalOpen = true" color="yellow" type="button" icon="add-document"
        showTextOnMobile="true">
        Tambah Permintaan Barang
    </x-button.button-action>
    <div class="fixed inset-0 bg-gray-900 bg-opacity-30 z-50 flex items-center justify-center" x-show="modalOpen" x-cloak>
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg max-w-lg w-full"
            @click.outside="modalOpen = false">
            <div class="flex justify-center items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Tambah Permintaan Barang</h3>
            </div>
            <form action="{{ route('work_request.work_request_items.store', ['id' => $workRequest->id]) }}"
                method="POST">
                @csrf
                {{-- @method('PUT') --}}
                <div class="grid grid-cols-2 gap-4">
                    {{-- item_name --}}
                    <div>
                        <x-label for="item_name" value="{{ __('Deskripsi') }}" />
                        <x-input id="item_name" type="text" name="item_name" class="mt-1 block w-full min-h-[40px]"
                            required autocomplete="item_name" placeholder="Masukkan deskripsi" value="" />
                        <x-input-error for="item_name" class="mt-2" />
                    </div>

                    {{-- description --}}
                    <div>
                        <x-label for="description" value="{{ __('Keterangan') }}" />
                        <x-input id="description" type="text" name="description"
                            class="mt-1 block w-full min-h-[40px]" required autocomplete="description"
                            placeholder="Masukkan keterangan" value="" />
                        <x-input-error for="description" class="mt-2" />
                    </div>

                    {{-- quantity --}}
                    <div>
                        <x-label for="quantity" value="{{ __('Jumlah') }}" />
                        <x-input id="quantity" type="number" step="0.01" name="quantity"
                            class="mt-1 block w-full min-h-[40px]" required autocomplete="quantity"
                            placeholder="Masukkan jumlah" value="" />
                        <x-input-error for="quantity" class="mt-2" />
                    </div>

                    {{-- unit --}}
                    <div>
                        <x-label for="unit" value="{{ __('Satuan') }}" />
                        <x-input id="unit" type="text" name="unit" class="mt-1 block w-full min-h-[40px]"
                            required autocomplete="unit" placeholder="Masukkan satuan" value="" />
                        <x-input-error for="unit" class="mt-2" />
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
