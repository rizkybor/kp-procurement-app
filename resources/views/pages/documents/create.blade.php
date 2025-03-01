<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Dashboard actions -->
        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <!-- Left: Title -->
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Tambah Dokumen Pengadaan</h1>
            </div>

            <!-- Right: Actions -->
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <x-button.button-action color="red" type="button"
                    onclick="window.location='{{ route('docs-pengadaan') }}'" class="float-right">
                    Batal
                </x-button.button-action>

                <x-button.button-action color="violet" type="button"
                    onclick="window.location='{{ route('docs-pengadaan.edit') }}'" class="float-right">
                    Simpan
                </x-button.button-action>
            </div>
        </div>
        <!-- Dashboard actions end -->

        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="grid grid-cols-2 grid-rows-6 gap-4">
                    <div class="col-span-2">
                        <div>
                            <x-label for="test" value="{{ __('Nama Pekerjaan') }}" />
                            <x-input id="test" type="text" class="mt-1 block w-full min-h-[40px]"
                                wire:model.live="state.test" required autocomplete="test" />
                            <x-input-error for="test" class="mt-2" />
                        </div>
                    </div>
                    <div class="row-start-2">
                        <div>
                            <x-label for="test" value="{{ __('Bagian / Divisi') }}" />
                            <x-input id="test" type="text" class="mt-1 block w-full min-h-[40px]"
                                wire:model.live="state.test" required autocomplete="test" />
                            <x-input-error for="test" class="mt-2" />
                        </div>
                    </div>
                    <div class="row-start-2">
                        <div>
                            <x-label for="test" value="{{ __('Nomor') }}" />
                            <x-input id="test" type="text" class="mt-1 block w-full min-h-[40px]"
                                wire:model.live="state.test" required autocomplete="test" />
                            <x-input-error for="test" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <div>
                            <x-label for="test" value="{{ __('Tanggal') }}" />
                            <x-input id="test" type="text" class="mt-1 block w-full min-h-[40px]"
                                wire:model.live="state.test" required autocomplete="test" />
                            <x-input-error for="test" class="mt-2" />
                        </div>

                    </div>
                    <div class="row-start-3">
                        <div>
                            <x-label for="test" value="{{ __('Judul Proyek') }}" />
                            <x-input id="test" type="text" class="mt-1 block w-full min-h-[40px]"
                                wire:model.live="state.test" required autocomplete="test" />
                            <x-input-error for="test" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <div>
                            <x-label for="test" value="{{ __('Tenggat') }}" />
                            <x-input id="test" type="text" class="mt-1 block w-full min-h-[40px]"
                                wire:model.live="state.test" required autocomplete="test" />
                            <x-input-error for="test" class="mt-2" />
                        </div>
                    </div>
                    <div class="row-start-4">
                        <div>
                            <x-label for="test" value="{{ __('Pemilik Proyek') }}" />
                            <x-input id="test" type="text" class="mt-1 block w-full min-h-[40px]"
                                wire:model.live="state.test" required autocomplete="test" />
                            <x-input-error for="test" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <div>
                            <x-label for="test" value="{{ __('PIC') }}" />
                            <x-input id="test" type="text" class="mt-1 block w-full min-h-[40px]"
                                wire:model.live="state.test" required autocomplete="test" />
                            <x-input-error for="test" class="mt-2" />
                        </div>
                    </div>
                    <div class="row-start-5">
                        <div>
                            <x-label for="test" value="{{ __('No Kontrak') }}" />
                            <x-input id="test" type="text" class="mt-1 block w-full min-h-[40px]"
                                wire:model.live="state.test" required autocomplete="test" />
                            <x-input-error for="test" class="mt-2" />
                        </div>
                    </div>
                    <div>
                        <div>
                            <x-label for="test" value="{{ __('Aanwijzing') }}" />
                            <x-input id="test" type="text" class="mt-1 block w-full min-h-[40px]"
                                wire:model.live="state.test" required autocomplete="test" />
                            <x-input-error for="test" class="mt-2" />
                        </div>
                    </div>
                    <div class="row-start-6">
                        <div>
                            <x-label for="test" value="{{ __('Jenis Pengadaan') }}" />
                            <x-input id="test" type="text" class="mt-1 block w-full min-h-[40px]"
                                wire:model.live="state.test" required autocomplete="test" />
                            <x-input-error for="test" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
