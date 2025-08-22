@props(['workRequest', 'itemRequest', 'totalRab'])

@php
    $csrf = csrf_token();
    // gunakan route work_request_items.update (PUT)
    $updateUrlTemplate = route('work_request.work_rabs.update', [
        'id' => $workRequest->id,
        'work_rab_id' => '__ID__'
    ]);
@endphp

<div
    x-data="rabInline({
        total: {{ (float) $totalRab }},
        csrf: '{{ $csrf }}',
        urlTpl: '{{ $updateUrlTemplate }}'
    })"
    x-on:rab-row-change.window="registerTotal($event.detail)"
    x-on:rab-save-row.window="saveRow($event.detail)"
    class="col-span-full xl:col-span-12 bg-white dark:bg-gray-800 shadow-sm rounded-xl"
>
    <header class="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60">
        <h2 class="font-semibold dark:text-gray-100">Daftar RAB</h2>
    </header>

    <div class="p-3">
        <div class="overflow-x-auto">
            <table class="table-auto w-full">
                <thead class="text-xs font-semibold uppercase text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-700 dark:bg-opacity-50">
                    <tr>
                        <th class="p-2 whitespace-nowrap"><div class="font-semibold text-center">No</div></th>
                        <th class="p-2 whitespace-nowrap"><div class="font-semibold text-left">Deskripsi</div></th>
                        <th class="p-2 whitespace-nowrap"><div class="font-semibold text-center">Jumlah</div></th>
                        <th class="p-2 whitespace-nowrap"><div class="font-semibold text-center">Satuan</div></th>
                        <th class="p-2 whitespace-nowrap"><div class="font-semibold text-center">Harga</div></th>
                        <th class="p-2 whitespace-nowrap"><div class="font-semibold text-center">Total Harga</div></th>
                        <th class="p-2 whitespace-nowrap"><div class="font-semibold text-center">Action</div></th>
                    </tr>
                </thead>

                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                    @php $i = 1; @endphp
                    @if (!empty($itemRequest) && $itemRequest->count())
                        @foreach ($itemRequest as $rab)
                            <tr
                                x-data="{
                                    id: {{ $rab->id }},
                                    qty: {{ (float) $rab->quantity }},
                                    harga: {{ (float) $rab->harga }},
                                    get total() { return (Number(this.qty)||0) * (Number(this.harga)||0); },
                                    fmt(n){ try { return Number(n||0).toLocaleString('id-ID'); } catch(e){ return n } }
                                }"
                                x-init="$dispatch('rab-row-change', { id, total })"
                            >
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">{{ $i++ }}</div>
                                </td>

                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-left">{{ $rab->item_name }}</div>
                                </td>

                                {{-- JUMLAH: editable --}}
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">
                                        <input
                                            type="number" step="1" min="0"
                                            class="w-20 rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-700 text-right px-2 py-1"
                                            x-model.number="qty"
                                            @input="$dispatch('rab-row-change', { id, total })"
                                            @change="$dispatch('rab-save-row', { id, qty, harga })"
                                        />
                                    </div>
                                </td>

                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">{{ $rab->unit }}</div>
                                </td>

                                {{-- HARGA: editable --}}
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">
                                        <input
                                            type="number" step="1" min="0"
                                            class="w-36 rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-700 text-right px-2 py-1"
                                            x-model.number="harga"
                                            @input="$dispatch('rab-row-change', { id, total })"
                                            @change="$dispatch('rab-save-row', { id, qty, harga })"
                                        />
                                        <div class="text-xs text-gray-500 mt-1">
                                            Rp. <span x-text="fmt(harga)"></span>
                                        </div>
                                    </div>
                                </td>

                                {{-- TOTAL HARGA: otomatis --}}
                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center">
                                        Rp. <span x-text="fmt(total)"></span>
                                    </div>
                                </td>

                                <td class="p-2 whitespace-nowrap">
                                    <div class="text-center flex items-center justify-center gap-2">
                                        <form
                                            action="{{ route('work_request.work_request_items.destroy', ['id' => $workRequest->id, 'work_request_item_id' => $rab->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-button.button-action color="red" icon="trash" type="submit">
                                                Hapus
                                            </x-button.button-action>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="p-2 whitespace-nowrap" colspan="9">
                                <div class="text-center">Tidak ada data rab.</div>
                            </td>
                        </tr>
                    @endif
                </tbody>

                {{-- tabel total keseluruhan harga rab --}}
                @if (!empty($itemRequest) && $itemRequest->count())
                    <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                        <tr>
                            <td class="p-2 whitespace-nowrap"><div class="text-center"></div></td>
                            <td class="p-2 whitespace-nowrap"><div class="text-left"></div></td>
                            <td class="p-2 whitespace-nowrap"><div class="text-center"></div></td>
                            <td class="p-2 whitespace-nowrap"><div class="text-center"></div></td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="text-center"><strong>Keseluruhan Harga RAB :</strong></div>
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="text-center">
                                    Rp. <span x-text="fmt(total)"></span>
                                </div>
                            </td>
                            <td class="p-2 whitespace-nowrap"><div class="text-center"></div></td>
                        </tr>
                    </tbody>
                @endif
            </table>
        </div>
    </div>
</div>

{{-- Alpine controller --}}
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('rabInline', ({ total, csrf, urlTpl }) => ({
        total,           // grand total (footer)
        csrf, urlTpl,
        totals: {},      // map: { [id]: rowTotal }

        fmt(n) {
            try { return Number(n||0).toLocaleString('id-ID'); } catch { return n; }
        },

        // dipanggil dari event 'rab-row-change'
        registerTotal({ id, total }) {
            this.totals[id] = Number(total || 0);
            this.recalcGrand();
        },

        recalcGrand() {
            this.total = Object.values(this.totals).reduce((s, v) => s + Number(v || 0), 0);
        },

        // dipanggil dari event 'rab-save-row'
        async saveRow({ id, qty, harga }) {
            const url = this.urlTpl.replace('__ID__', id);

            try {
                const res = await fetch(url, {
                    method: 'PUT', // sesuai routes
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrf,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        quantity: qty,
                        harga: harga
                        // total_harga dihitung otomatis di server
                    })
                });
                if (!res.ok) throw new Error(`HTTP ${res.status}`);
                const data = await res.json();

                // sinkronisasi grand total dari server
                if (typeof data?.totalRab !== 'undefined') {
                    this.total = Number(data.totalRab || 0);
                }
            } catch (err) {
                console.error(err);
                alert('Gagal menyimpan perubahan. Coba lagi.');
            }
        }
    }))
})
</script>