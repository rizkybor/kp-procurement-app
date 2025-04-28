@props(['workRequest' => null])

<!-- Wrapper Modal dengan ID -->
<div id="modalOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-30 z-50 flex items-center justify-center px-4 hidden">

    <div
        class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-2xl sm:max-w-md sm:h-auto sm:max-h-[90vh] sm:overflow-auto flex flex-col">

        <!-- Header Modal dengan Flex -->
        <div class="flex justify-center items-center mb-1">
            <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                {{-- Dynamic Value --}}
            </h3>
        </div>
        <div class="flex justify-center items-center mb-4">
            <p class="text-gray-700 dark:text-gray-300 text-sm">
                <strong>No Kontrak:</strong> {{ $workRequest['contract_number'] ?? 'Tidak Diketahui' }}
            </p>
        </div>

        <!-- Form -->
        <form id="modalForm" method="POST" class="w-full">
            @csrf
            @method('PUT')

            <!-- Field Pesan -->
            <div class="mb-4">
                <x-label for="messages" value="Pesan (Opsional)" class="text-gray-700 dark:text-gray-200" />
                <textarea id="messages" name="messages" class="form-input w-full mt-1 rounded-md"></textarea>
            </div>

            <!-- Footer Modal -->
            <div class="flex justify-center gap-4">
                <x-secondary-button type="button" onclick="closeModal()">
                    Cancel
                </x-secondary-button>
                <x-button.button-action id="modalSubmitButton" type="submit">
                    Approve
                </x-button.button-action>
            </div>
        </form>
    </div>
</div>

<script>
    function clearMessages() {
        document.getElementById("messages").value = "";
    }

    document.getElementById("modalSubmitButton").addEventListener("click", function() {
        document.getElementById("modalForm").submit(); // 🔥 Kirim form sebelum reset textarea
    });
</script>
