@props(['color' => 'gray', 'icon' => null, 'size' => 'md', 'showTextOnMobile' => false])

@php
    $colors = [
        'blue' =>
            'bg-blue-500 hover:bg-blue-600 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-900',
        'teal' =>
            'bg-teal-500 hover:bg-teal-600 focus:ring-teal-300 dark:bg-teal-700 dark:hover:bg-teal-800 dark:focus:ring-teal-900',
        'yellow' =>
            'bg-yellow-500 hover:bg-yellow-600 focus:ring-yellow-300 dark:bg-yellow-700 dark:hover:bg-yellow-800 dark:focus:ring-yellow-900',
        'orange' =>
            'bg-orange-500 hover:bg-orange-600 focus:ring-orange-300 dark:bg-orange-700 dark:hover:bg-orange-800 dark:focus:ring-orange-900',
        'red' =>
            'bg-red-500 hover:bg-red-600 focus:ring-red-300 dark:bg-red-700 dark:hover:bg-red-800 dark:focus:ring-red-900',
        'green' =>
            'bg-green-500 hover:bg-green-600 focus:ring-green-300 dark:bg-green-700 dark:hover:bg-green-800 dark:focus:ring-green-900',
        'gray' =>
            'bg-gray-500 hover:bg-gray-600 focus:ring-gray-300 dark:bg-gray-700 dark:hover:bg-gray-800 dark:focus:ring-gray-900',
        'purple' =>
            'bg-purple-500 hover:bg-purple-600 focus:ring-purple-300 dark:bg-purple-700 dark:hover:bg-purple-800 dark:focus:ring-purple-900',
    ];

    $colorClass = $colors[$color] ?? $colors['gray'];

    // Size classes - diperkecil untuk desktop
    $sizes = [
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-2.5 py-1.5 text-sm',
        'md' => 'px-3 py-1.5 text-sm', // Diperkecil dari py-2
        'lg' => 'px-3.5 py-2 text-base', // Diperkecil dari px-4/py-3
        'xl' => 'px-4 py-2.5 text-lg', // Diperkecil dari px-5/py-4
    ];
    $sizeClass = $sizes[$size] ?? $sizes['md'];

    // Icon sizes - diperkecil untuk desktop
    $iconSizes = [
        'xs' => 'w-3 h-3',
        'sm' => 'w-3.5 h-3.5',
        'md' => 'w-4 h-4', // Di desktop tidak diperbesar
        'lg' => 'w-4.5 h-4.5', // Diperkecil dari w-6/h-6
        'xl' => 'w-5 h-5', // Diperkecil dari w-7/h-7
    ];
    $iconSizeClass = $iconSizes[$size] ?? $iconSizes['md'];

    $icons = [
        'eye' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12s-3-4-7-4-7 4-7 4 3 4 7 4 7-4 7-4z"/><circle cx="8" cy="12" r="2"/>',
        'print' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M6 9V4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v5m-12 0h12m-12 0H4a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h2m12 0h2a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-12 6v4a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-4m-12 0h12"></path>',
        'cancel' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>',
        'info' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h1m0 4h-1m0 0h-1m1-8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path>',
        'reject' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>',
        'view' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5C7.5 4.5 3.6 7.6 2 12c1.6 4.4 5.5 7.5 10 7.5s8.4-3.1 10-7.5c-1.6-4.4-5.5-7.5-10-7.5zM12 16.5a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9z"></path>',
        'approve' => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>',
        'pencil' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.121 2.121 0 113 3L6 20l-4 1 1-4 13.5-13.5z"/>',
        'trash' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-5 4v6m4-6v6m-8-6v6m-3 4h14a2 2 0 002-2V6H3v10a2 2 0 002 2z"/>',
        'right-arrow' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m6 0l-3 3m3-3l-3-3m9 3a9 9 0 11-18 0 9 9 0 0118 0z" />',
        'send' => '<path stroke-linecap="round" stroke-linejoin="round" d="M22 2L11 13M22 2L15 22L11 13L2 9l20-7z" />',
        'add-document' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6M6 2a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6H6z" />',
        'upload' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12V4m0 0l-4 4m4-4l4 4" />',
        'back' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />',
        'document' =>
            '<path stroke-linecap="round" stroke-linejoin="round" d="M7 2a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2V8l-6-6H7z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13 2v6h6" />',
    ];

    $iconSvg = isset($icons[$icon])
        ? '<svg class="' .
            $iconSizeClass .
            '" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">' .
            $icons[$icon] .
            '</svg>'
        : '';
@endphp

<button
    {{ $attributes->merge([
        'type' => 'button',
        'class' => "flex items-center gap-2 $sizeClass font-medium rounded-lg text-white $colorClass focus:outline-none focus:ring-2 whitespace-nowrap transition-colors duration-200",
    ]) }}>
    {!! $iconSvg !!}
    @if ($showTextOnMobile)
        {{ $slot }}
    @else
        <span class="hidden sm:inline">{{ $slot }}</span>
    @endif

    @if ($icon && $slot->isNotEmpty())
        <span class="sr-only">{{ $slot }}</span>
    @endif
</button>
