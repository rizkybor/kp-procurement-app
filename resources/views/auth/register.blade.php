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
                                <x-label for="name">{{ __('Full Name') }} <span
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
                                <x-label for="email">{{ __('Email Address') }} <span
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
                                <x-label for="password_confirmation">{{ __('Confirm Password') }} <span
                                        class="text-red-500">*</span></x-label>
                                <x-input id="password_confirmation" type="password" name="password_confirmation"
                                    required autocomplete="new-password" placeholder="Masukkan ulang password" />
                            </div>

                            <!-- Department -->
                            <div>
                                <x-label for="department">{{ __('Department') }} <span
                                        class="text-red-500">*</span></x-label>
                                <select id="department" name="department"
                                    class="mt-1 block w-full form-select rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">Pilih Department</option>
                                    <option value="SDM">SDM</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Pengadaan">Pengadaan</option>
                                    <option value="Keuangan">Keuangan</option>
                                    <option value="Operasi">Operasi</option>
                                    <option value="Direksi">Direksi</option>
                                </select>
                                <x-input-error for="department" class="mt-2" />
                            </div>

                            <!-- Position -->
                            <div>
                                <x-label for="position">{{ __('Position') }} <span
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
                                    <option value="direktur_utama">Direktur Utama</option>
                                    <option value="fungsi_pengadaan">Fungsi Pengadaan</option>
                                </select>
                                <x-input-error for="role" class="mt-2" />
                            </div>

                            <!-- Employee Status -->
                            <div>
                                <x-label for="employee_status">{{ __('Employee Status') }} <span
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
                                <x-label for="identity_number">{{ __('Identity Number') }} <span
                                        class="text-red-500">*</span></x-label>
                                <x-input id="identity_number" type="text" name="identity_number" :value="old('identity_number')"
                                    required placeholder="Masukkan nomor identitas" />
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <x-button>{{ __('Sign Up') }}</x-button>
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
            if (input.value.length > 8) {
                input.value = input.value.slice(0, 8);
            }
        }
    </script>
    {{-- </x-authentication-layout> --}}
</x-app-layout>
