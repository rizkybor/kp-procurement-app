<div id="rejectDocumentModal"
    class="fixed inset-0 bg-gray-900 bg-opacity-30 z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-md w-full mx-4 sm:mx-0">
        <h3 id="rejectModalTitle" class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Batalkan Dokumen
        </h3>

        <form id="rejectDocumentForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Alasan --}}
            <div class="mb-4" id="rejectReasonGroup">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alasan Dibatalkan
                    :</label>
                {{-- Input saat submit --}}
                <input type="text" name="reason" id="rejectReasonInput" required
                    class="form-input w-full rounded-md">

                {{-- Teks saat view only --}}
                <p id="rejectReasonText" class="hidden justify text-red-800 dark:text-gray-100 text-sm"></p>
            </div>

            {{-- Upload File --}}
            {{-- Section file upload dinonaktifkan sementara --}}
            <!--
            <div class="mb-4" id="fileUploadSection">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload Dokumen Pembatalan
                    :</label>
                <input type="file" name="file" id="rejectFileInput" accept="application/pdf" required
                    class="form-input w-full">
            </div>
            -->

            {{-- File Preview (hanya untuk view) --}}
            {{-- Preview file dinonaktifkan sementara --}}
            <!--
            <div class="mt-4 mb-4 hidden flex flex-col items-center justify-center gap-2" id="rejectedFilePreview">
                <svg height="64px" width="64px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 303.188 303.188" xml:space="preserve"
                    fill="#000000">
                    SVG content di sini...
                </svg>
                <a href="#" id="rejectedFileLink" target="_blank" class="text-sm text-blue-600 underline">Lihat
                    Dokumen Pembatalan</a>
            </div>
            -->

            <div class="flex justify-end gap-2">
                <x-secondary-button type="button" onclick="closeRejectModal()">Tutup</x-secondary-button>
                <x-button.button-action color="red" type="submit" id="rejectSubmitButton">
                    Batalkan
                </x-button.button-action>
            </div>
        </form>
    </div>
</div>

<script>
    function openRejectModal(actionUrl = '', isViewOnly = false, reason = '', fileUrl = '') {
        const form = document.getElementById('rejectDocumentForm');
        const modal = document.getElementById('rejectDocumentModal');
        const title = document.getElementById('rejectModalTitle');

        const reasonGroup = document.getElementById('rejectReasonGroup');
        const reasonInput = document.getElementById('rejectReasonInput');
        const reasonText = document.getElementById('rejectReasonText');

        // Elemen file yang tidak digunakan sementara dikomentari
        /*
        const fileInput = document.getElementById('rejectFileInput');
        const fileSection = document.getElementById('fileUploadSection');
        const filePreview = document.getElementById('rejectedFilePreview');
        const fileLink = document.getElementById('rejectedFileLink');
        */

        const submitButton = document.getElementById('rejectSubmitButton');

        if (isViewOnly) {
            form.removeAttribute('action');

            // Tampilkan reason sebagai teks
            reasonInput.classList.add('hidden');
            reasonInput.removeAttribute('required');
            reasonText.innerText = reason;
            reasonText.classList.remove('hidden');

            // Kode file handling yang tidak digunakan sementara
            /*
            fileInput.classList.add('hidden');
            fileInput.removeAttribute('required');
            fileSection.classList.add('hidden');

            filePreview.classList.remove('hidden');
            fileLink.href = fileUrl;
            */

            // Sembunyikan tombol submit
            submitButton.classList.add('hidden');

            // Ubah judul
            title.innerText = 'Alasan Pembatalan Dokumen';
        } else {
            form.setAttribute('action', actionUrl);

            reasonInput.value = '';
            reasonInput.classList.remove('hidden');
            reasonInput.setAttribute('required', true);
            reasonText.classList.add('hidden');

            // Kode file handling yang tidak digunakan sementara
            /*
            fileInput.classList.remove('hidden');
            fileInput.setAttribute('required', true);
            fileSection.classList.remove('hidden');

            filePreview.classList.add('hidden');
            fileLink.href = '#';
            */

            submitButton.classList.remove('hidden');

            title.innerText = 'Batalkan Dokumen';
        }

        modal.classList.remove('hidden');
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectDocumentModal');
        const form = document.getElementById('rejectDocumentForm');
        const reasonInput = document.getElementById('rejectReasonInput');

        reasonInput.removeAttribute('readonly');
        form.reset();
        modal.classList.add('hidden');
    }
</script>
