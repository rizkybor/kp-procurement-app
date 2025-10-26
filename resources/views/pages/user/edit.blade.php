{{-- resources/views/pages/user/edit.blade.php --}}
<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Edit Akun</h1>

            <x-link-button href="{{ route('users.index') }}" class="mt-3 sm:mt-0" style="background-color: rgb(175, 175, 78)">
                ← Kembali ke Daftar
            </x-link-button>
        </div>

        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Perbarui Akun</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Ubah informasi akun. Password bersifat opsional—kosongkan jika tidak ingin diubah.
                    </p>
                </div>
            </div>

            <div class="mt-5 md:mt-0 md:col-span-2">
                {{-- PENTING: enctype untuk upload file --}}
                <form method="POST" action="{{ route('users.update', $user) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                        <x-validation-errors class="mb-4" />

                        <div class="grid grid-cols-1 gap-y-6">
                            <!-- Full Name -->
                            <div>
                                <x-label for="name">{{ __('Nama Lengkap') }} <span class="text-red-500">*</span></x-label>
                                <x-input id="name" type="text" name="name"
                                    class="mt-1 block w-full min-h-[40px]"
                                    :value="old('name', $user->name)" required autofocus
                                    autocomplete="name" placeholder="Masukkan nama lengkap" />
                            </div>

                            <!-- NIP -->
                            <div>
                                <x-label for="nip">{{ __('NIP') }} <span class="text-red-500">*</span></x-label>
                                <x-input id="nip" type="text" name="nip"
                                    :value="old('nip', $user->nip)" required
                                    oninput="limitNIPLength(this)" placeholder="Masukkan nomor NIP" />
                                <x-input-error for="nip" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-label for="email">{{ __('Alamat Email') }} <span class="text-red-500">*</span></x-label>
                                <x-input id="email" type="email" name="email"
                                    :value="old('email', $user->email)" required
                                    placeholder="Masukkan alamat email" />
                            </div>

                            <!-- Department -->
                            <div>
                                <x-label for="department">{{ __('Departemen') }} <span class="text-red-500">*</span></x-label>
                                @php $dept = old('department', $user->department); @endphp
                                <select id="department" name="department"
                                    class="mt-1 block w-full form-select rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">Pilih Departemen</option>
                                    @foreach (['SDM','Finance','Pengadaan','Keuangan','Operasi','Direksi'] as $d)
                                        <option value="{{ $d }}" {{ $dept === $d ? 'selected' : '' }}>{{ $d }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="department" class="mt-2" />
                            </div>

                            <!-- Position -->
                            <div>
                                <x-label for="position">{{ __('Posisi') }} <span class="text-red-500">*</span></x-label>
                                <x-input id="position" type="text" name="position"
                                    :value="old('position', $user->position)" required
                                    placeholder="Masukkan posisi" />
                            </div>

                            <!-- Role -->
                            <div>
                                <x-label for="role">{{ __('Role') }} <span class="text-red-500">*</span></x-label>
                                @php $currentRole = old('role', $user->roles->first()->name ?? ''); @endphp
                                <select id="role" name="role"
                                    class="mt-1 block w-full form-select rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">Pilih Role</option>
                                    @foreach($roles as $roleName)
                                        <option value="{{ $roleName }}" {{ $currentRole === $roleName ? 'selected' : '' }}>
                                            {{ $roleName }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error for="role" class="mt-2" />
                            </div>

                            <!-- Employee Status -->
                            <div>
                                <x-label for="employee_status">{{ __('Status Pegawai') }} <span class="text-red-500">*</span></x-label>
                                @php $emp = old('employee_status', $user->employee_status); @endphp
                                <select id="employee_status" name="employee_status"
                                    class="mt-1 block w-full form-select rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">Pilih Status</option>
                                    @foreach (['permanent'=>'Permanent','contract'=>'Contract','probation'=>'Probation'] as $val=>$label)
                                        <option value="{{ $val }}" {{ $emp === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Gender -->
                            <div>
                                <x-label for="gender">{{ __('Gender') }} <span class="text-red-500">*</span></x-label>
                                @php $gender = old('gender', $user->gender); @endphp
                                <div class="mt-1 space-y-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" id="gender_pria" name="gender" value="pria"
                                            class="form-radio h-4 w-4" {{ $gender === 'pria' ? 'checked' : '' }} required />
                                        <span class="ml-2">Pria</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" id="gender_wanita" name="gender" value="wanita"
                                            class="form-radio h-4 w-4" {{ $gender === 'wanita' ? 'checked' : '' }} required />
                                        <span class="ml-2">Wanita</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Identity Number -->
                            <div>
                                <x-label for="identity_number">{{ __('Nomor Identitas') }} <span class="text-red-500">*</span></x-label>
                                <x-input id="identity_number" type="text" name="identity_number"
                                    :value="old('identity_number', $user->identity_number)" required
                                    placeholder="Masukkan nomor identitas" />
                            </div>

                            <!-- Paraf (opsional) -->
                            <div>
                                <x-label for="signature">Paraf (opsional)</x-label>

                                <div class="flex items-center gap-3">
                                    <input id="signature" name="signature" type="file"
                                        accept="image/png,image/jpeg,image/jpg,image/webp"
                                        class="mt-1 block w-full text-sm file:mr-4 file:rounded-md file:border-0
                                               file:bg-violet-50 file:py-2 file:px-4 file:text-violet-700
                                               hover:file:bg-violet-100" />
                                   
                                </div>
                                <p class="text-xs text-gray-500 mt-1">PNG/JPG/WEBP, maks 1 MB. Disarankan rasio ±3:1.</p>

                                @if ($user->signature)
                                    <div id="currentSignatureWrap" class="mt-2">
                                        <p class="text-xs text-gray-500 mb-1">Paraf saat ini:</p>
                                        {{-- Path dari DB: "storage/images-paraf/xxx.ext" --}}
                                        <img src="{{ asset($user->signature) }}" class="h-12 border rounded" alt="Paraf saat ini" />
                                    </div>

                                    <label class="inline-flex items-center mt-2">
                                        <input type="checkbox" id="remove_signature" name="remove_signature" value="1"
                                               class="form-checkbox" {{ old('remove_signature') ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm">Hapus paraf saat ini</span>
                                    </label>
                                @endif

                                <!-- Preview file baru -->
                                <img id="signaturePreview" class="mt-2 max-h-20 rounded border hidden" alt="Preview Paraf Baru" />
                                <x-input-error for="signature" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <x-button>{{ __('Simpan Perubahan') }}</x-button>
                            <a href="{{ route('users.index') }}"
                               class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm
                                      text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <x-validation-errors class="mt-4" />
    </div>

    <script>
        function limitNIPLength(input) {
            input.value = input.value.replace(/\D/g,'').slice(0, 8);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const input       = document.getElementById('signature');
            const preview     = document.getElementById('signaturePreview');
            const removeChk   = document.getElementById('remove_signature');
            const currentWrap = document.getElementById('currentSignatureWrap');

            function hidePreview() {
                preview.src = '';
                preview.classList.add('hidden');
            }

            function showPreviewFromFile(file) {
                preview.src = URL.createObjectURL(file);
                preview.onload = () => URL.revokeObjectURL(preview.src);
                preview.classList.remove('hidden');
            }

            // Pilih file baru
            input?.addEventListener('change', e => {
                const [file] = e.target.files || [];
                if (!file) { hidePreview(); return; }

                const okType = ['image/png','image/jpeg','image/jpg','image/webp'].includes(file.type);
                const okSize = file.size <= 1024 * 1024; // ≤ 1MB
                if (!okType || !okSize) {
                    alert('File harus gambar (PNG/JPG/WEBP) dan maksimal 1 MB.');
                    input.value = '';
                    hidePreview();
                    return;
                }

                // memilih file baru -> batal hapus
                if (removeChk) {
                    removeChk.checked = false;
                    input.disabled = false;
                    currentWrap?.classList.remove('opacity-50');
                }

                showPreviewFromFile(file);
            });

            // Centang hapus paraf
            removeChk?.addEventListener('change', (e) => {
                const on = e.target.checked;
                input.disabled = on;
                if (on) {
                    input.value = '';
                    hidePreview();
                    currentWrap?.classList.add('opacity-50');
                } else {
                    input.disabled = false;
                    currentWrap?.classList.remove('opacity-50');
                }
            });

            // Konsistensi UI saat reload (old('remove_signature') == 1)
            if (removeChk?.checked) {
                input.disabled = true;
                currentWrap?.classList.add('opacity-50');
                hidePreview();
            }
        });
    </script>
</x-app-layout>