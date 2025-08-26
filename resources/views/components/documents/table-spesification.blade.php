@props(['specRequest', 'workRequest'])

<div class="col-span-full xl:col-span-12 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
    <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60">
        <h2 class="font-semibold dark:text-gray-100">Edit Form Spesification</h2>
    </header>

    {{-- Error global dari controller/validasi --}}
    @if ($errors->any())
        <div class="mb-4 p-3 rounded-md bg-red-100 border border-red-400 text-red-700 text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-3 rounded-md bg-red-100 border border-red-400 text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 p-3 rounded-md bg-green-100 border border-green-400 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="p-5 space-y-6">

        <!-- Spesifikasi Ringkasan -->
        <div x-data="specAutosave({
            workId: {{ $workRequest->id }},
            specId: {{ $specRequest->id ?? 'null' }},
            values: {
                contract_type: @js($specRequest->contract_type ?? ($workRequest->contract_type ?? '')),
                payment_mechanism: @js($specRequest->payment_mechanism ?? ($workRequest->payment_mechanism ?? '')),
                work_duration: @js($specRequest->work_duration ?? ($workRequest->work_duration ?? '')),
            },
            createUrl: '{{ route('work_request.work_spesifications.store', ['id' => $workRequest->id]) }}',
            updateUrlTpl: '{{ route('work_request.work_spesifications.update', ['id' => $workRequest->id, 'work_spesification_id' => '__ID__']) }}',
            csrf: '{{ csrf_token() }}'
        })" class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Tipe Kontrak --}}
            <div class="flex items-start md:items-center gap-3">
                <label class="text-gray-600 dark:text-gray-300 w-48 pt-2 md:pt-0">Tipe Kontrak</label>
                <div class="flex-1">
                    <input type="text" x-model="values.contract_type" @input="queueSave('contract_type')"
                        placeholder="mis. Lump Sum, Time-Based, Unit Price"
                        class="w-full rounded-lg border-b border-gray-300 dark:border-gray-600 bg-transparent focus:outline-none focus:border-amber-500 text-amber-500 py-1.5" />
                    <p x-show="errors.contract_type" x-cloak class="mt-1 text-sm text-red-600"
                        x-text="errors.contract_type"></p>
                </div>
            </div>

            {{-- Mekanisme Pembayaran --}}
            <div class="flex items-start md:items-center gap-3">
                <label class="text-gray-600 dark:text-gray-300 w-56 pt-2 md:pt-0">Mekanisme Pembayaran</label>
                <div class="flex-1">
                    <input type="text" x-model="values.payment_mechanism" @input="queueSave('payment_mechanism')"
                        placeholder="mis. Termin, Bulanan, Progress, Sekaligus"
                        class="w-full rounded-lg border-b border-gray-300 dark:border-gray-600 bg-transparent focus:outline-none focus:border-amber-500 text-amber-500 py-1.5" />
                    <p x-show="errors.payment_mechanism" x-cloak class="mt-1 text-sm text-red-600"
                        x-text="errors.payment_mechanism"></p>
                </div>
            </div>

            {{-- Jangka Waktu Pekerjaan --}}
            <div class="flex items-start md:items-center gap-3">
                <label class="text-gray-600 dark:text-gray-300 w-48 pt-2 md:pt-0">Jangka Waktu Pekerjaan</label>
                <div class="flex-1">
                    <input type="text" x-model="values.work_duration" @input="queueSave('work_duration')"
                        placeholder="mis. 12 bulan / 180 hari kalender"
                        class="w-full rounded-lg border-b border-gray-300 dark:border-gray-600 bg-transparent focus:outline-none focus:border-amber-500 text-amber-500 py-1.5" />
                    <p x-show="errors.work_duration" x-cloak class="mt-1 text-sm text-red-600"
                        x-text="errors.work_duration"></p>
                </div>
            </div>

            {{-- Status autosave (letakkan di paling bawah kolom kiri) --}}
            <div class="col-span-1 md:col-span-2">
                <span class="text-xs"
                    :class="{
                        'text-gray-400': status==='idle',
                        'text-amber-600': status==='saving',
                        'text-emerald-600': status==='saved',
                        'text-red-600': status==='error'
                    }"
                    x-text="statusText">
                </span>
            </div>
        </div>


        <!-- Tabel File -->
        <div class="overflow-x-auto border border-gray-100 rounded-xl">
            <div
                class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700/60 bg-gray-50 dark:bg-gray-800/50 rounded-t-xl">
                {{-- Title --}}
                <h2 class="text-base md:text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                    File Specification
                </h2>

                {{-- Upload Button --}}
                <div>
                    <x-modal.request-spesification.modal-create-request-spesification :workRequest="$workRequest" />
                </div>
            </div>

            <table class="table-auto w-full">
                <thead
                    class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="p-3 text-left w-20">No</th>
                        <th class="p-3 text-left">Nama File</th>
                        <th class="p-3 text-left">Catatan</th>
                        <th class="p-3 text-center w-32">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                    @forelse($specRequest?->files ?? [] as $file)
                        <tr>
                            <td class="p-3">{{ $loop->iteration }}</td>
                            <td class="p-3">
                                <a href="{{ asset('storage/' . $file->path) }}" target="_blank"
                                    class="text-amber-600 hover:underline">
                                    {{ $file->original_name }}
                                </a>
                                <div class="text-xs text-gray-500">
                                    ({{ number_format($file->size / 1024, 1) }} KB)
                                </div>
                            </td>
                            <td class="p-3">{{ $file->description }}</td>
                            <td class="p-3">
                                <div class="flex flex-col sm:flex-row sm:justify-center gap-2">
                                    {{-- Download --}}
                                    <a href="{{ asset('storage/' . $file->path) }}" target="_blank"
                                        class="inline-flex items-center justify-center w-full sm:w-auto px-3 py-1.5 text-xs font-medium
                                    rounded-md bg-teal-500 text-white hover:bg-teal-600
                                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500
                                    dark:focus:ring-offset-gray-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                        </svg>
                                        Download
                                    </a>

                                    {{-- Hapus --}}
                                    <form
                                        action="{{ route('work_request.work_spesification_files.destroy', ['id' => $workRequest->id, 'file' => $file->id]) }}"
                                        method="POST" class="w-full sm:w-auto"
                                        onsubmit="return confirm('Yakin ingin hapus file ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-full sm:w-auto px-3 py-1.5 text-xs font-medium
                                        rounded-md bg-red-500 text-white hover:bg-red-600
                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500
                                        dark:focus:ring-offset-gray-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1.5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h2a2 2 0 012 2v2" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-3 text-center text-gray-400">
                                Belum ada file diunggah
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>


<script>
    function specAutosave(init) {
        return {
            ...init,
            // state
            savingTimer: null,
            dirtyFields: new Set(),
            status: 'idle', // idle | saving | saved | error
            statusText: 'Ready',
            errors: {},

            updateUrl() {
                if (!this.specId) return null;
                return this.updateUrlTpl.replace('__ID__', this.specId);
            },

            setStatus(s, text) {
                this.status = s;
                this.statusText = text || ({
                    idle: 'Ready',
                    saving: 'Saving…',
                    saved: 'Saved',
                    error: 'Error saving'
                } [s]);
            },

            queueSave(field) {
                this.dirtyFields.add(field);
                if (this.savingTimer) clearTimeout(this.savingTimer);
                // debounce 800ms
                this.savingTimer = setTimeout(() => this.flushSave(), 800);
            },

            async flushSave() {
                if (this.dirtyFields.size === 0) return;

                // payload hanya field yang berubah
                const payload = {
                    _method: 'PUT'
                };
                this.dirtyFields.forEach(f => payload[f] = this.values[f]);

                this.setStatus('saving');
                this.errors = {};

                try {
                    // jika belum ada specId -> create dulu
                    if (!this.specId) {
                        const createRes = await fetch(this.createUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': this.csrf,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(this.values)
                        });

                        const createJson = await createRes.json().catch(() => ({}));
                        if (!createRes.ok) {
                            this.handleValidation(createRes.status, createJson);
                            return;
                        }
                        // ambil id baru untuk update berikutnya
                        this.specId = createJson?.data?.id ?? createJson?.id ?? null;
                    }

                    // lalu update hanya field yang dirty
                    const res = await fetch(this.updateUrl(), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': this.csrf,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });

                    const json = await res.json().catch(() => ({}));
                    if (!res.ok) {
                        this.handleValidation(res.status, json);
                        return;
                    }

                    this.setStatus('saved', 'Saved');
                    this.dirtyFields.clear();
                    // kembalikan ke idle setelah 2 detik
                    setTimeout(() => this.setStatus('idle'), 2000);

                } catch (e) {
                    console.error(e);
                    this.setStatus('error', 'Network error');
                }
            },

            handleValidation(status, json) {
                if (status === 422 && json?.errors) {
                    // Laravel validation
                    const flat = {};
                    Object.keys(json.errors).forEach(k => flat[k] = json.errors[k][0]);
                    this.errors = flat;
                    this.setStatus('error', 'Validation error');
                } else {
                    this.setStatus('error', json?.message || 'Failed saving');
                }
            }
        }
    }
</script>
