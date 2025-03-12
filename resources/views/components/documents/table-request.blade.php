@props(['itemRequest', 'workRequest'])

<div class="col-span-full xl:col-span-12 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
    <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60">
        <h2 class="font-semibold  dark:text-gray-100">Daftar Permintaan Barang</h2>
    </header>
    <div class="p-3">

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <!-- Table header -->
                <thead
                    class="text-xs font-semibold uppercase text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-700 dark:bg-opacity-50">
                    <tr>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">No</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">Deskripsi</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Jumlah</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Satuan</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Keterangan</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Action</div>
                    </tr>
                </thead>

                <!-- Table body -->
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                    @php $i = 1; @endphp
                    @if (!empty($itemRequest) && $itemRequest->count())
                        @foreach ($itemRequest as $item)
                            <tr>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">{{ $i++ }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{ $item->item_name }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">{{ $item->quantity }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">{{ $item->unit }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">{{ $item->description }}</div>
                                </td>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center flex items-center justify-center gap-2">
                                        <x-modal.request-item.modal-edit-request-item :itemRequest="$item"
                                            :workRequest="$workRequest" />
                                        <form
                                            action="{{ route('work_request.work_request_items.destroy', ['id' => $workRequest->id, 'work_request_item_id' => $item->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-button.button-action color="red" icon="trash" type="submit">Hapus
                                            </x-button.button-action>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="p-2 whitespace-nowrap" colspan="9">
                                <div class="text-center">Tidak ada permintaan barang yang tersedia.</div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div>

    </div>
</div>
