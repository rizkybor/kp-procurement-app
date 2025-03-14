@props(['specRequest', 'workRequest'])

<div class="col-span-full xl:col-span-12 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
    <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60">
        <h2 class="font-semibold  dark:text-gray-100">Daftar Spesification</h2>
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
                            <div class="font-semibold text-left">Lingkup Kerja</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Tipe Kontrak</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Aspek Keamanan</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Laporan</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Kebutuhan Penyedia</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Mekanisme Pembayaran</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Action</div>
                    </tr>
                </thead>
                <!-- Table body -->
                {{-- @php
                    dd($specRequest);
                @endphp --}}
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                    @php $i = 1; @endphp
                    @if (!empty($specRequest) && $specRequest->count())
                        @foreach ($specRequest as $spec)
                            <tr>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">{{ $i++ }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{ $spec->scope_of_work }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">{{ $spec->contract_type }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">{{ $spec->safety_aspect }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">{{ $spec->reporting }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">{{ $spec->provider_requirements }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">{{ $spec->payment_procedures }}</div>
                                </td>
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center flex items-center justify-center gap-2">
                                        <x-modal.request-spesification.modal-edit-request-spesification
                                            :workRequest="$workRequest" :specRequest="$spec" />
                                        <form
                                            action="{{ route('work_request.work_spesifications.destroy', ['id' => $workRequest->id, 'work_spesification_id' => $spec->id]) }}"
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
                                <div class="text-center">Tidak ada spesification tersedia.</div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div>

    </div>
</div>
