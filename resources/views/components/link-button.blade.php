@props(['href' => '#', 'color' => 'primary'])

@php
    $colors = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white',
        'blue'    => 'bg-blue-600 hover:bg-blue-700 text-white',
        'red'     => 'bg-red-600 hover:bg-red-700 text-white',
        'green'   => 'bg-green-600 hover:bg-green-700 text-white',
        'gray'    => 'bg-gray-600 hover:bg-gray-700 text-white',
    ];

    $colorClass = $colors[$color] ?? $colors['primary'];
@endphp

<a href="{{ $href }}" {{ $attributes->merge([
    'class' => "inline-flex items-center px-4 py-2 h-10 rounded-lg shadow transition-all duration-200 {$colorClass}"
]) }}>
    {{ $slot }}
</a>