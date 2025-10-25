<!-- Modal Konfirmasi Global -->
<div id="globalConfirmModal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
    <!-- Background overlay -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-200"
        data-confirm-overlay></div>

    <!-- Modal box -->
    <div class="relative z-10 w-full max-w-md scale-95 opacity-0 transition-all duration-200
                rounded-lg bg-white dark:bg-gray-800 shadow-lg p-6"
        data-confirm-box role="dialog" aria-modal="true" aria-labelledby="confirmTitle" aria-describedby="confirmMessage">
        <h3 id="confirmTitle" class="text-lg font-semibold text-gray-800 dark:text-gray-100">Konfirmasi</h3>
        <p id="confirmMessage" class="mt-2 text-sm text-gray-600 dark:text-gray-300">Apakah Anda yakin?</p>

        <div class="mt-6 flex justify-end gap-2">
            <button id="confirmCancelBtn"
                class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100
                       dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                Batal
            </button>
            <button id="confirmOkBtn"
                class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                Hapus
            </button>
        </div>
    </div>
</div>

<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">📩 Semua Pesan</h1>

            <div class="flex gap-2">
                @if ($notifications->whereNull('read_at')->count() > 0)
                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                        @csrf
                        <x-button.button-action color="green" icon="check" type="submit">
                            Tandai Semua Dibaca
                        </x-button.button-action>
                    </form>
                @endif

                @if ($notifications->count() > 0)
                    <x-button.button-action color="red" icon="trash" type="button"
                        onclick="clearAllNotifications()">
                        Hapus Semua
                    </x-button.button-action>
                @endif
            </div>
        </div>

        <!-- Daftar Notifikasi -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-5">
            <div class="overflow-y-auto max-h-[600px] scrollbar-hidden">
                @if ($notifications->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">Tidak ada notifikasi.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($notifications as $notification)
                            @php
                                $rawMessage = $notification->messages ?? 'Tidak ada pesan';

                                if (is_string($rawMessage) && json_decode($rawMessage, true)) {
                                    $message = json_decode($rawMessage, true);
                                } else {
                                    $message = $rawMessage;
                                }

                                if (is_string($message) && str_contains($message, 'Lihat detail:')) {
                                    $messageParts = explode('Lihat detail:', $message, 2);
                                    $textMessage = trim($messageParts[0]);
                                    if (!empty($notification->notifiable_id)) {
                                        $url = url(
                                            "/work_request/{$notification->notifiable_id}/show/work_request_items",
                                        );
                                    }
                                } else {
                                    $textMessage = is_string($message) ? $message : 'Tidak ada pesan.';
                                    $url = null;
                                }
                            @endphp

                            <div class="relative p-4 border rounded-lg cursor-pointer transition-colors duration-300 ease-in-out 
                                {{ $notification->read_at === null ? 'bg-yellow-100 dark:bg-yellow-900' : 'bg-gray-200 dark:bg-gray-700' }}"
                                @click="markAsRead('{{ route('notifications.markAsRead', $notification->id) }}', {{ $notification->id }}, '{{ $url }}');"
                                data-id="{{ $notification->id }}">

                                <div class="flex justify-between items-center">
                                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-300">
                                        Dikirim oleh :
                                        <span class="font-normal">
                                            {{ $notification->sender->name }} ({{ $notification->sender->nip }} -
                                            {{ $notification->sender->position }})
                                        </span>
                                    </p>
                                    <p class="text-sm text-gray-800 dark:text-gray-300">
                                        Tanggal dikirim : {{ $notification->created_at }}
                                    </p>
                                </div>
                                <div class="w-full border-b border-gray-300 dark:border-gray-600 my-3"></div>

                                <div class="flex justify-between items-center">
                                    <div class="w-2/3">
                                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-300 mt-1">Pesan :
                                        </p>
                                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ $textMessage }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $notification->created_at->diffForHumans() }}</p>
                                    </div>

                                    <div class="w-1/3 flex justify-end gap-2">
                                        <x-button.button-action color="red" type="button"
                                            @click.stop="deleteNotification({{ $notification->id }})">
                                            Hapus
                                        </x-button.button-action>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-4">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Helper ambil CSRF
    const getCSRF = () => (document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '');

    // === EXPOSE GLOBAL: dipanggil dari HTML/Alpine ===
    window.markAsRead = function(url, notificationId, redirectUrl) {
        fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCSRF(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(r => {
                if (!r.ok) throw new Error(r.status);
                return r.json();
            })
            .then(data => {
                if (data.success && redirectUrl) window.location.href = redirectUrl;
            })
            .catch(console.error);
    };

    window.deleteNotification = function(notificationId) {
        window.openConfirmationModal(
            "Konfirmasi Hapus",
            "Apakah Anda yakin ingin menghapus notifikasi ini?",
            function() {
                fetch(`{{ url('/notifications') }}/${notificationId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': getCSRF(),
                            'Accept': 'application/json',
                        },
                    })
                    .then(r => {
                        if (!r.ok) throw new Error('delete fail');
                        return r.json();
                    })
                    .then(data => window.showAutoCloseAlert('globalAlertModal', 3000, data.message, 'success',
                            'Berhasil!')
                        .then(() => location.reload()))
                    .catch(() => window.showAutoCloseAlert('globalAlertModal', 3000,
                        'Notifikasi gagal dihapus.', 'error', 'Error!'));
            }, {
                okLabel: 'Hapus',
                okColor: 'bg-red-600 hover:bg-red-700'
            }
        );
    };

    window.clearAllNotifications = function() {
        window.openConfirmationModal(
            "Konfirmasi Hapus Semua",
            "Apakah Anda yakin ingin menghapus semua notifikasi?",
            function() {
                fetch(`{{ route('notifications.clearAll') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': getCSRF(),
                            'Accept': 'application/json',
                        },
                    })
                    .then(r => {
                        if (!r.ok) throw new Error('clear-all fail');
                        return r.json();
                    })
                    .then(data => window.showAutoCloseAlert('globalAlertModal', 3000, data.message, 'success',
                            'Berhasil!')
                        .then(() => location.reload()))
                    .catch(() => window.showAutoCloseAlert('globalAlertModal', 3000,
                        'Gagal menghapus semua notifikasi.', 'error', 'Error!'));
            }, {
                okLabel: 'Hapus Semua',
                okColor: 'bg-red-600 hover:bg-red-700'
            }
        );
    };
</script>

<!-- Modal controller: openConfirmationModal dengan Tailwind -->
<script>
    (function() {
        const modal = document.getElementById('globalConfirmModal');
        if (!modal) return; // guard

        const overlay = modal.querySelector('[data-confirm-overlay]');
        const box = modal.querySelector('[data-confirm-box]');
        const titleEl = document.getElementById('confirmTitle');
        const msgEl = document.getElementById('confirmMessage');
        const okBtn = document.getElementById('confirmOkBtn');
        const cancelBtn = document.getElementById('confirmCancelBtn');

        let onConfirmFn = null;

        function animateOpen() {
            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                overlay?.classList.remove('opacity-0');
                box?.classList.remove('opacity-0', 'translate-y-4');
                document.body.classList.add('overflow-hidden');
            });
        }

        function animateClose() {
            overlay?.classList.add('opacity-0');
            box?.classList.add('opacity-0', 'translate-y-4');
            document.body.classList.remove('overflow-hidden');
            setTimeout(() => modal.classList.add('hidden'), 180);
        }

        function openModal(title, message, onConfirm, opts = {}) {
            titleEl.textContent = title || 'Konfirmasi';
            msgEl.innerHTML = message || 'Apakah Anda yakin?';

            // Opsi tombol OK (label & warna)
            okBtn.textContent = opts.okLabel || 'OK';
            okBtn.className =
                `rounded-md px-4 py-2 text-sm font-medium text-white ${opts.okColor || 'bg-blue-600 hover:bg-blue-700'}`;

            onConfirmFn = (typeof onConfirm === 'function') ? onConfirm : null;
            animateOpen();

            // Fokus awal ke tombol OK
            setTimeout(() => okBtn.focus(), 50);
        }

        function closeModal() {
            onConfirmFn = null;
            animateClose();
        }

        okBtn.addEventListener('click', () => {
            const fn = onConfirmFn;
            closeModal();
            if (fn) fn();
        });

        cancelBtn.addEventListener('click', closeModal);

        // ✅ klik overlay juga menutup
        overlay?.addEventListener('click', closeModal);

        // Tutup dengan Escape
        window.addEventListener('keydown', (e) => {
            if (!modal.classList.contains('hidden') && e.key === 'Escape') closeModal();
        });

        // Expose global
        window.openConfirmationModal = openModal;
        window.closeConfirmationModal = closeModal;

        // Fallback alert sederhana jika belum ada utilitas Anda
        if (!window.showAutoCloseAlert) {
            window.showAutoCloseAlert = function(_id, ms, text, type = 'success', title = 'Info') {
                alert(`${title}: ${text}`);
                return Promise.resolve();
            };
        }
    })();
</script>
