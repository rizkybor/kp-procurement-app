@php
    // daftar departemen yang SUDAH punya Manager
    $departmentsWithManager = \App\Models\User::where('role', 'manager')
        ->pluck('department')
        ->filter()
        ->unique()
        ->values();

    // cek direksi unik (global)
    $hasDirKeu = \App\Models\User::where('role', 'direktur_keuangan')->exists();
    $hasDirUtama = \App\Models\User::where('role', 'direktur_utama')->exists();
    $hasFungsiPengadaan = \App\Models\User::where('role', 'fungsi_pengadaan')->exists();
@endphp

<x-app-layout>
    {{-- <x-authentication-layout> --}}
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Membuat Akun</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Tambahkan informasi akun baru, termasuk detail pihak terkait, durasi, dan persyaratan khusus.
                    </p>
                </div>
            </div>
            @if (session('status'))
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        showAutoCloseAlert('globalAlertModal', 3000, @json(session('status')), 'success', 'Success!');
                    });
                </script>
            @endif


            <div class="mt-5 md:mt-0 md:col-span-2">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="px-4 py-5 sm:p-6 bg-white dark:bg-gray-800 shadow rounded-lg">
                        <div class="grid grid-cols-1 gap-y-6">
                            <!-- Full Name -->
                            <div>
                                <x-label for="name">{{ __('Nama Lengkap') }} <span
                                        class="text-red-500">*</span></x-label>
                                <x-input id="name" type="text" name="name"
                                    class="mt-1 block w-full min-h-[40px]" :value="old('name')" required autofocus
                                    autocomplete="name" placeholder="Masukkan nama lengkap" />
                            </div>

                            <!-- NIP -->
                            <div>
                                <x-label for="nip">{{ __('NIP') }} <span
                                        class="text-red-500">*</span></x-label>
                                <x-input id="nip" type="text" name="nip" :value="old('nip')" required
                                    oninput="limitNIPLength(this)" placeholder="Masukkan nomor NIP" />
                                <x-input-error for="nip" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-label for="email">{{ __('Alamat Email') }} <span
                                        class="text-red-500">*</span></x-label>
                                <x-input id="email" type="email" name="email" :value="old('email')" required
                                    placeholder="Masukkan alamat email" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-label for="password">{{ __('Password') }} <span
                                        class="text-red-500">*</span></x-label>
                                <x-input id="password" type="password" name="password" required
                                    autocomplete="new-password" placeholder="Masukkan password" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <x-label for="password_confirmation">{{ __('Konfirmasi Password') }} <span
                                        class="text-red-500">*</span></x-label>
                                <x-input id="password_confirmation" type="password" name="password_confirmation"
                                    required autocomplete="new-password" placeholder="Masukkan ulang password" />
                            </div>

                            <!-- Department -->
                            <div>
                                <x-label for="department">{{ __('Departemen') }} <span
                                        class="text-red-500">*</span></x-label>
                                {{-- <select id="department" name="department"
                                    class="mt-1 block w-full form-select rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">Pilih Departemen</option>
                                    <option value="SDM">SDM</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Pengadaan">Pengadaan</option>
                                    <option value="Keuangan">Keuangan</option>
                                    <option value="Operasi">Operasi</option>
                                    <option value="Direksi">Direksi</option>
                                </select> --}}
                                <select id="department" name="department"
                                    class="mt-1 block w-full form-select rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">Pilih Departemen</option>
                                    @foreach (['SDM', 'Finance', 'Operasi'] as $dept)
                                        <option value="{{ $dept }}"
                                            {{ request('department') === $dept ? 'selected' : '' }}>
                                            {{ $dept }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error for="department" class="mt-2" />
                            </div>

                            <!-- Position -->
                            <div>
                                <x-label for="position">{{ __('Posisi') }} <span
                                        class="text-red-500">*</span></x-label>
                                <x-input id="position" type="text" name="position" :value="old('position')" required
                                    placeholder="Masukkan posisi" />
                            </div>

                            <!-- Role -->
                            <div>
                                <x-label for="role">{{ __('Role') }} <span
                                        class="text-red-500">*</span></x-label>
                                <select id="role" name="role"
                                    class="mt-1 block w-full form-select rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">Pilih Role</option>
                                    <option value="maker">Maker</option>
                                    <option value="manager">Manager</option>
                                    <option value="direktur_keuangan">Direktur Keuangan</option>
                                    {{-- <option value="direktur_utama">Direktur Utama</option> --}}
                                    <option value="fungsi_pengadaan">Fungsi Pengadaan</option>
                                </select>
                                <x-input-error for="role" class="mt-2" />
                            </div>

                            <!-- Employee Status -->
                            <div>
                                <x-label for="employee_status">{{ __('Status Pegawai') }} <span
                                        class="text-red-500">*</span></x-label>
                                <select id="employee_status" name="employee_status"
                                    class="mt-1 block w-full form-select rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">Pilih Status</option>
                                    <option value="permanent">Permanent</option>
                                    <option value="contract">Contract</option>
                                    <option value="probation">Probation</option>
                                </select>
                            </div>

                            <!-- Gender -->
                            <div>
                                <x-label for="gender">{{ __('Gender') }} <span
                                        class="text-red-500">*</span></x-label>
                                <div class="mt-1 space-y-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" id="gender_pria" name="gender" value="pria"
                                            class="form-radio h-4 w-4" required />
                                        <span class="ml-2">Pria</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" id="gender_wanita" name="gender" value="wanita"
                                            class="form-radio h-4 w-4" required />
                                        <span class="ml-2">Wanita</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Identity Number -->
                            <div>
                                <x-label for="identity_number">{{ __('Nomor Identitas') }} <span
                                        class="text-red-500">*</span></x-label>
                                <x-input id="identity_number" type="text" name="identity_number" :value="old('identity_number')"
                                    required placeholder="Masukkan nomor identitas" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <x-button>{{ __('Daftarkan Akun') }}</x-button>
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                            <div class="mt-6">
                                <label class="flex items-start">
                                    <input type="checkbox" class="form-checkbox mt-1" name="terms" id="terms"
                                        required />
                                    <span class="text-sm ml-2">
                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' =>
                                                '<a target="_blank" href="' .
                                                route('terms.show') .
                                                '" class="text-sm underline hover:no-underline">' .
                                                __('Terms of Service') .
                                                '</a>',
                                            'privacy_policy' =>
                                                '<a target="_blank" href="' .
                                                route('policy.show') .
                                                '" class="text-sm underline hover:no-underline">' .
                                                __('Privacy Policy') .
                                                '</a>',
                                        ]) !!}
                                    </span>
                                </label>
                            </div>
                        @endif
                    </div>
                </form>
            </div>

        </div>

        <!-- Form -->

        <x-validation-errors class="mt-4" />
        <!-- Footer -->
        {{-- <div class="pt-5 mt-6 border-t border-gray-100 dark:border-gray-700/60">
            <div class="text-sm">
                {{ __('Have an account?') }} <a
                    class="font-medium text-violet-500 hover:text-violet-600 dark:hover:text-violet-400"
                    href="{{ route('login') }}">{{ __('Sign In') }}</a>
            </div>
        </div> --}}
    </div>
    <script>
        function limitNIPLength(input) {
            if (input.value.length > 8) input.value = input.value.slice(0, 8);
        }

        // --- data dari backend ---
        const departmentsWithManager = @json($departmentsWithManager ?? []);
        const hasDirKeu = @json($hasDirKeu);
        const hasDirUtama = @json($hasDirUtama);
        const hasFungsiPengadaan = @json($hasFungsiPengadaan);



        function updateRoleAvailability() {
            const departmentSelect = document.getElementById('department');
            const roleSelect = document.getElementById('role');
            if (!departmentSelect || !roleSelect) return;

            const opt = (val) => roleSelect.querySelector(`option[value="${val}"]`);
            const selectedDept = departmentSelect.value || '';

            // 0) Default: jika belum pilih departemen, kunci Manager
            const managerOpt = opt('manager');
            if (managerOpt) {
                if (!selectedDept) {
                    managerOpt.disabled = true;
                    managerOpt.hidden = false; // ganti true kalau mau disembunyikan
                    managerOpt.textContent = 'Manager (pilih departemen dahulu)';
                    if (roleSelect.value === 'manager') roleSelect.value = '';
                } else {
                    // 1) Manager unik per departemen
                    const alreadyHasManager = departmentsWithManager.includes(selectedDept);
                    if (alreadyHasManager) {
                        managerOpt.disabled = true;
                        managerOpt.hidden = false;
                        managerOpt.textContent = 'Manager (sudah terisi di departemen ini)';
                        if (roleSelect.value === 'manager') roleSelect.value = '';
                    } else {
                        managerOpt.disabled = false;
                        managerOpt.hidden = false;
                        managerOpt.textContent = 'Manager';
                    }
                }
            }

            // 2) Direktur Keuangan unik global
            const dirKeuOpt = opt('direktur_keuangan');
            if (dirKeuOpt) {
                if (hasDirKeu) {
                    dirKeuOpt.disabled = true;
                    dirKeuOpt.hidden = false; // set true jika mau sembunyikan
                    dirKeuOpt.textContent = 'Direktur Keuangan (sudah terisi)';
                    if (roleSelect.value === 'direktur_keuangan') roleSelect.value = '';
                } else {
                    dirKeuOpt.disabled = false;
                    dirKeuOpt.hidden = false;
                    dirKeuOpt.textContent = 'Direktur Keuangan';
                }
            }

            // 3) Direktur Utama unik global
            // const dirUtamaOpt = opt('direktur_utama');
            // if (dirUtamaOpt) {
            //     if (hasDirUtama) {
            //         dirUtamaOpt.disabled = true;
            //         dirUtamaOpt.hidden = false; // set true jika mau sembunyikan
            //         dirUtamaOpt.textContent = 'Direktur Utama (sudah terisi)';
            //         if (roleSelect.value === 'direktur_utama') roleSelect.value = '';
            //     } else {
            //         dirUtamaOpt.disabled = false;
            //         dirUtamaOpt.hidden = false;
            //         dirUtamaOpt.textContent = 'Direktur Utama';
            //     }
            // }

            // 4) Maker: hanya aktif jika departemen punya Manager
            const fpOpt = opt('fungsi_pengadaan');
            if (fpOpt) {
                if (hasFungsiPengadaan) {
                    fpOpt.disabled = true;
                    fpOpt.hidden = false; // set true kalau ingin disembunyikan
                    fpOpt.textContent = 'Fungsi Pengadaan (sudah terisi)';
                    if (roleSelect.value === 'fungsi_pengadaan') roleSelect.value = '';
                } else {
                    fpOpt.disabled = false;
                    fpOpt.hidden = false;
                    fpOpt.textContent = 'Fungsi Pengadaan';
                }
            }

            // 5) Maker: hanya aktif jika departemen punya Manager
            const makerOpt = opt('maker');
            if (makerOpt) {
                const deptHasManager = selectedDept && departmentsWithManager.includes(selectedDept);

                if (!selectedDept) {
                    makerOpt.disabled = true;
                    makerOpt.textContent = 'Maker (pilih departemen dahulu)';
                    if (roleSelect.value === 'maker') roleSelect.value = '';
                } else if (!deptHasManager) {
                    makerOpt.disabled = true;
                    makerOpt.textContent = 'Maker (butuh Manager di departemen ini)';
                    if (roleSelect.value === 'maker') roleSelect.value = '';
                } else {
                    makerOpt.disabled = false;
                    makerOpt.textContent = 'Maker';
                }
            }
        }

        // Pasang listener setelah DOM siap
        document.addEventListener('DOMContentLoaded', () => {
            updateRoleAvailability();
            const departmentSelect = document.getElementById('department');
            departmentSelect?.addEventListener('change', updateRoleAvailability);
        });
    </script>
    {{-- </x-authentication-layout> --}}
</x-app-layout>
