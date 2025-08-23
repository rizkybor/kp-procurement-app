@props(['workRequest'])

<!-- Modal for Adding Cost Details -->
<div x-data="{ modalOpen: false }">
    <!-- Button to Open Modal -->
    <x-button.button-action @click="modalOpen = true" color="yellow" type="button" icon="add-document"
        showTextOnMobile="true">
        Upload File Spesification
    </x-button.button-action>
    <div class="fixed inset-0 bg-gray-900 bg-opacity-30 z-50 flex items-center justify-center" x-show="modalOpen" x-cloak>
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg max-w-lg w-full"
            @click.outside="modalOpen = false">
            <div class="flex justify-center items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Tambah Spesification</h3>
            </div>
            <form action="{{ route('work_request.work_spesifications.store', ['id' => $workRequest->id]) }}"
                method="POST">
                @csrf
                {{-- @method('PUT') --}}
                <div class="grid gap-4">
                    {{-- scope_of_work --}}
                    <div>
                        <x-label for="scope_of_work" value="{{ __('Lingkup Pekerjaan') }}" />
                        <x-input id="scope_of_work" type="text" name="scope_of_work"
                            class="mt-1 block w-full min-h-[40px]" required autocomplete="scope_of_work"
                            placeholder="Masukkan lingkup pekerjaan" value="" />
                        <x-input-error for="scope_of_work" class="mt-2" />
                    </div>

                    {{-- contract_type --}}
                    <div>
                        <x-label for="contract_type" value="{{ __('Tipe Kontrak') }}" />
                        <x-input id="contract_type" type="text" name="contract_type"
                            class="mt-1 block w-full min-h-[40px]" required autocomplete="contract_type"
                            placeholder="Masukkan tipe kontrak" value="" />
                        <x-input-error for="contract_type" class="mt-2" />
                    </div>

                    {{-- safety_aspect --}}
                    <div>
                        <x-label for="safety_aspect" value="{{ __('Aspek Keamanan') }}" />
                        <x-input id="safety_aspect" type="text" name="safety_aspect"
                            class="mt-1 block w-full min-h-[40px]" required autocomplete="safety_aspect"
                            placeholder="Masukkan aspek keamanan" value="" />
                        <x-input-error for="safety_aspect" class="mt-2" />
                    </div>

                    {{-- reporting --}}
                    <div>
                        <x-label for="reporting" value="{{ __('Laporan') }}" />
                        <x-input id="reporting" type="text" name="reporting" class="mt-1 block w-full min-h-[40px]"
                            required autocomplete="reporting" placeholder="Masukkan laporan" value="" />
                        <x-input-error for="reporting" class="mt-2" />
                    </div>

                    {{-- provider_requirements --}}
                    <div>
                        <x-label for="provider_requirements" value="{{ __('Kebutuhan Penyedia') }}" />
                        <x-input id="provider_requirements" type="text" name="provider_requirements"
                            class="mt-1 block w-full min-h-[40px]" required autocomplete="provider_requirements"
                            placeholder="Masukkan kebutuhan penyedia" value="" />
                        <x-input-error for="provider_requirements" class="mt-2" />
                    </div>

                    {{-- payment_procedures --}}
                    <div>
                        <x-label for="payment_procedures" value="{{ __('Mekanisme Pembayaran') }}" />
                        <x-input id="payment_procedures" type="text" name="payment_procedures"
                            class="mt-1 block w-full min-h-[40px]" required autocomplete="payment_procedures"
                            placeholder="Masukkan mekanisme pembayaran" value="" />
                        <x-input-error for="payment_procedures" class="mt-2" />
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
