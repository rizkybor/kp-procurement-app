@props(['status' => '-'])

@php
    // Mapping status angka ke role
    $statusRoles = [
        '0' => 'draft',
        '1' => 'manager',
        '2' => 'direktur_keuangan',
        '3' => 'direktur_utama',
        '4' => 'fungsi_pengadaan',
        '5' => 'done',
        '100' => 'finished',
        '101' => 'canceled',
        '102' => 'revised',
        '103' => 'rejected',
    ];

    // Mapping role ke label teks
    $statusLabels = [
        'draft' => 'Draft',
        'manager' => 'Checked by Manager',
        'direktur_keuangan' => 'Checked by Direktur Keuangan',
        'direktur_utama' => 'Checked by Direktur Utama',
        'fungsi_pengadaan' => 'Checked by Fungsi Pengadaan',
        'done' => 'Done',
        'finished' => 'Finished',
        'canceled' => 'Canceled',
        'revised' => 'Revised',
        'rejected' => 'Rejected',
    ];

    // Mapping warna status
    $statusColors = [
        'draft' => 'bg-gray-200 text-gray-800',
        'manager' => 'bg-blue-200 text-blue-800',
        'direktur_keuangan' => 'bg-yellow-200 text-yellow-800',
        'direktur_utama' => 'bg-orange-200 text-orange-800',
        'fungsi_pengadaan' => 'bg-indigo-200 text-indigo-800',
        'done' => 'bg-cyan-200 text-cyan-800',
        'finished' => 'bg-green-200 text-green-800',
        'canceled' => 'bg-gray-300 text-gray-900',
        'revised' => 'bg-orange-300 text-orange-900',
        'rejected' => 'bg-red-200 text-red-800',
    ];

    $role = $statusRoles[$status] ?? '-';
    $label = $statusLabels[$role] ?? '-';
    $colorClass = $statusColors[$role] ?? 'bg-gray-200 text-gray-800';
@endphp

<span class="px-3 py-1 text-sm font-semibold rounded-md {{ $colorClass }}">
    {{ $label }}
</span>
