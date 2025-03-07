<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <form id="submit_form_request"action="{{ route('work_request.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <!-- Dashboard actions -->
            <div class="sm:flex sm:justify-between sm:items-center mb-8">
                <!-- Left: Title -->
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Tambah Dokumen Pengadaan
                    </h1>
                </div>

                <!-- Right: Actions -->
                <div class="form-group">
                    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                        <x-button.button-action color="red" type="button" class="float-right"
                            onclick="window.location='{{ route('work_request.index') }}'">
                            Batal
                        </x-button.button-action>

                        <x-button.button-action color="teal" type="submit" class="float-right">
                            Simpan
                        </x-button.button-action>
                    </div>
                </div>
            </div>
            <!-- Dashboard actions end -->

            <div class="mt-5 md:mt-0 md:col-span-2">
                <div class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="grid grid-cols-2 grid-rows-6 gap-4">
                        <div class="col-span-2">
                            <div>
                                <x-label for="work_name_request" value="{{ __('Nama Pekerjaan') }}" />
                                <x-input id="work_name_request" type="text" name="work_name_request"
                                    class="mt-1 block w-full min-h-[40px]" required autocomplete="work_name_request"
                                    placeholder="Masukkan nama pekerjaan" />
                                <x-input-error for="work_name_request" class="mt-2" />
                            </div>
                        </div>
                        <div class="row-start-2">
                            <div>
                                <x-label for="department" value="{{ __('Bagian / Divisi') }}" />
                                <x-input id="department" type="text" name="department"
                                    class="mt-1 block w-full min-h-[40px]" required autocomplete="department"
                                    placeholder="Masukkan bagian atau divisi" />
                                <x-input-error for="department" class="mt-2" />
                            </div>
                        </div>
                        <div class="row-start-2">
                            <div>
                                <x-label for="request_number" value="{{ __('Nomor') }}" />
                                <x-input id="request_number" type="text"
                                    class="block mt-1 w-full bg-gray-200 dark:bg-gray-700" name="request_number"
                                    required autocomplete="request_number" value="{{ $numberFormat }}" readonly />
                            </div>
                        </div>
                        <div>
                            <div>
                                <x-label for="request_date" value="{{ __('Tanggal') }}" />
                                <x-input id="request_date" type="date"
                                    class="block mt-1 w-full bg-gray-200 dark:bg-gray-700" name="request_date" required
                                    value="{{ $today }}" readonly />
                            </div>
                        </div>
                        <div class="row-start-3">
                            <div>
                                <x-label for="project_title" value="{{ __('Judul Proyek') }}" />
                                <x-input id="project_title" type="text" name="project_title"
                                    class="mt-1 block w-full min-h-[40px]" required autocomplete="project_title"
                                    placeholder="Masukkan judul proyek" />
                                <x-input-error for="project_title" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <div>
                                <x-label for="deadline" value="{{ __('Tenggat') }}" />
                                <x-input id="deadline" type="date" name="deadline"
                                    class="mt-1 block w-full min-h-[40px]" required autocomplete="deadline"
                                    placeholder="Masukkan tenggat" min="{{ $today }}" />
                                <x-input-error for="deadline" class="mt-2" />
                            </div>
                        </div>
                        <div class="row-start-4">
                            <div>
                                <x-label for="project_owner" value="{{ __('Pemilik Proyek') }}" />
                                <x-input id="project_owner" type="text" name="project_owner"
                                    class="mt-1 block w-full min-h-[40px]" required autocomplete="project_owner"
                                    placeholder="Masukkan pemilik proyek" />
                                <x-input-error for="project_owner" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <div>
                                <x-label for="pic" value="{{ __('PIC') }}" />
                                <x-input id="pic" type="text" name="pic"
                                    class="mt-1 block w-full min-h-[40px]" required autocomplete="pic"
                                    placeholder="Masukkan pic" />
                                <x-input-error for="pic" class="mt-2" />
                            </div>
                        </div>
                        <div class="row-start-5">
                            <div>
                                <x-label for="contract_number" value="{{ __('No Kontrak') }}" />
                                <x-input id="contract_number" type="text" name="contract_number"
                                    class="mt-1 block w-full min-h-[40px]" required autocomplete="contract_number"
                                    placeholder="Masukkan nomor kontrak" />
                                <x-input-error for="contract_number" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <div>
                                <x-label for="aanwijzing" value="{{ __('Aanwijzing') }}" />
                                <x-input id="aanwijzing" type="text" name="aanwijzing"
                                    class="mt-1 block w-full min-h-[40px]" required autocomplete="aanwijzing"
                                    placeholder="Masukkan aanwijzing" />
                                <x-input-error for="aanwijzing" class="mt-2" />
                            </div>
                        </div>
                        <div class="row-start-6">
                            <div>
                                <x-label for="procurement_type" value="{{ __('Jenis Pengadaan') }}" />
                                <x-input id="procurement_type" type="text" name="procurement_type"
                                    class="mt-1 block w-full min-h-[40px]" required autocomplete="procurement_type"
                                    placeholder="Masukkan jenis pengadaan" />
                                <x-input-error for="procurement_type" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
