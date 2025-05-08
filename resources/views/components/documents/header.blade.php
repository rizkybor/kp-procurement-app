@props([
    'workRequest',
    'printOptions',
    'document_status',
    'latestApprover',
    'isEditable' => false,
    'isShowPage' => false,
])

@php
    $printOptions = [
        [
            'label' => 'Surat Permintaan',
            'route' => route('work_request.print-form-request', $workRequest->id),
        ],
        [
            'label' => 'Surat Rab',
            'route' => route('work_request.print-rab', $workRequest->id),
        ],
    ];
@endphp

@php
    // Dapatkan current approval stage
    $currentStage = optional($latestApprover)->approver_role ?? 'maker';

    // Tentukan next approver role
    $nextApproverRole = match ($currentStage) {
        'maker' => 'manager',
        'manager' => $workRequest->total_rab > 500000000 ? 'direktur_utama' : 'direktur_keuangan',
        'direktur_utama', 'direktur_keuangan' => 'fungsi_pengadaan',
        default => null,
    };
@endphp

<div class="flex gap-2">
    @if ($isEditable)
        <x-button.button-action color="teal" type="button" icon="right-arrow" showTextOnMobile="true"
            onclick="window.location='{{ route('work_request.work_request_items.show', $workRequest->id) }}'">
            Process Dokumen
        </x-button.button-action>
    @endif

    @if ($isShowPage)
        <div x-data="{ open: false }" class="relative">
            <x-button.button-action @click="open = !open" color="blue" icon="print">
                Cetak Dokumen
            </x-button.button-action>

            <div x-show="open" @click.away="open = false"
                class="absolute z-10 mt-2 bg-white border rounded-lg shadow-lg w-56">
                <ul class="py-2 text-gray-700">
                    @foreach ($printOptions as $option)
                        <li>
                            <a href="{{ $option['route'] }}" target="_blank"
                                class="block px-4 py-2 hover:bg-blue-500 hover:text-white">
                                {{ $option['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- User: Selain Maker --}}
        @if (auth()->user()->role !== 'maker')
            @if (auth()->user()->role === $nextApproverRole && !in_array($document_status, [102, 103, 6, 'approved', 'finalized']))
                <x-button.button-action color="orange" icon="info"
                    data-action="{{ route('work_request.processRevision', $workRequest['id']) }}" data-title="Need Info"
                    data-button-text="Send"
                    data-button-color="bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-500 dark:hover:bg-yellow-600 dark:focus:ring-yellow-700"
                    onclick="openModal(this)">
                    Need Info
                </x-button.button-action>

                <x-button.button-action color="blue" icon="approve"
                    data-action="{{ route('work_request.processApproval', $workRequest['id']) }}"
                    data-title="Approve Document" data-button-text="Approve"
                    data-button-color="bg-green-500 hover:bg-green-600 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-700"
                    onclick="openModal(this)">
                    Approve
                </x-button.button-action>
            @endif
        @endif

        {{-- User: Maker --}}
        @if (auth()->user()->role === 'maker')
            @if ($document_status == 102)
                <x-button.button-action color="orange" icon="reply"
                    data-action="{{ route('work_request.processApproval', $workRequest['id']) }}"
                    data-title="Reply Info" data-button-text="Reply Info"
                    data-button-color="bg-orange-500 hover:bg-orange-600 dark:bg-orange-500 dark:hover:bg-orange-600 dark:focus:ring-orange-700'"
                    onclick="openModal(this)">
                    Reply Info
                </x-button.button-action>
            @endif

            @if (in_array($document_status, [0, 102]))
                <x-button.button-action color="yellow" type="button" icon="pencil"
                    onclick="window.location='{{ route('work_request.work_request_items.edit', $workRequest->id) }}'">
                    Edit Dokumen
                </x-button.button-action>
            @endif

            @if ($document_status == 0)
                <x-button.button-action color="green" icon="send"
                    data-action="{{ route('work_request.processApproval', $workRequest['id']) }}"
                    data-title="Process Document" data-button-text="Process"
                    data-button-color="bg-green-500 hover:bg-green-600 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-700"
                    onclick="openModal(this)">
                    Process
                </x-button.button-action>
            @endif
        @endif
    @endif

    <x-modal.global.modal-proccess-global :workRequest="$workRequest" />
</div>

<script>
    function openModal(button) {
        let actionRoute = button.getAttribute('data-action');
        let modalTitle = button.getAttribute('data-title');
        let buttonText = button.getAttribute('data-button-text');
        let buttonColor = button.getAttribute('data-button-color');

        document.querySelector('#modalForm').setAttribute('action', actionRoute);
        document.querySelector('#modalTitle').innerText = modalTitle;
        document.querySelector('#modalSubmitButton').innerText = buttonText;
        document.querySelector('#modalSubmitButton').setAttribute('data-button-color',
            buttonColor);
        document.querySelector('#modalSubmitButton').classList.remove('bg-green-500', 'hover:bg-green-600',
            'bg-orange-500', 'hover:bg-orange-600', 'dark:bg-orange-500', 'dark:hover:bg-orange-600',
            'dark:focus:ring-orange-700', 'dark:bg-green-500', 'dark:hover:bg-green-600',
            'dark:focus:ring-green-700');
        document.querySelector('#modalSubmitButton').classList.add(...buttonColor.split(' '));

        document.querySelector('#modalOverlay').classList.remove('hidden');
    }

    function closeModal() {
        document.querySelector('#modalOverlay').classList.add('hidden');
    }
</script>
