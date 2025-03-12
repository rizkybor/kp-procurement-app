@props(['workRequest', 'itemRequest'])

<!-- Modal for Adding Cost Details -->
<div x-data="{ modalOpen: false }">
    <!-- Button to Open Modal -->
    <x-button.button-action @click="modalOpen = true" color="teal" type="button">
        + RAB
    </x-button.button-action>
    <div class="fixed inset-0 bg-gray-900 bg-opacity-30 z-50 flex items-center justify-center" x-show="modalOpen" x-cloak>
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg max-w-lg w-full"
            @click.outside="modalOpen = false">
            <div class="flex justify-center items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Tambah Permintaan Barang</h3>
            </div>
            <form action="{{ route('work_request.work_rabs.store', ['id' => $workRequest->id]) }}" method="POST">
                @csrf
                {{-- @method('PUT') --}}
                <div class="grid grid-cols-2 gap-4">
                    {{-- item_name --}}
                    <div>
                        <x-label for="work_request_item_id" value="{{ __('Pilih Item') }}" />
                        <select id="work_request_item_id" name="work_request_item_id"
                            class="block mt-1 w-full border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-200 font-medium px-3 py-2 rounded-lg shadow-sm focus:ring focus:ring-blue-300 dark:focus:ring-blue-700 transition-all">
                            <option disabled selected>Pilih item</option>
                            @foreach ($itemRequest as $item)
                                <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="item_name" class="mt-2" />
                    </div>

                    {{-- harga --}}
                    <div>
                        <x-label for="harga" value="{{ __('Harga') }}" />
                        <x-input id="harga" class="mt-1 block w-full min-h-[40px]" type="text" name="harga"
                            oninput="formatCurrency(this);" inputmode="numeric" />
                        <x-input-error for="harga" class="mt-2" />
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

<script>
    document.addEventListener("DOMContentLoaded", function() {

        window.formatCurrency = function(input) {
            let value = input.value.replace(/\D/g, ''); // Hanya angka
            if (value === '') return;
            input.value = new Intl.NumberFormat("id-ID").format(value);
            checkChanges();
        };
    });
</script>
