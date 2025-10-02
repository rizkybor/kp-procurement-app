@props([
    'href'     => '#',
    'label'    => 'Download',
    'size'     => 'sm',         
    'tone'     => 'emerald',    
    'block'    => false,        
    'disabled' => false,        
    'download' => false,        
    'target'   => null,         
])

@php
  // size map
  $sizeMap = [
    'sm' => 'px-3 py-1.5 text-xs',
    'md' => 'px-3.5 py-2 text-sm',
  ];
  $pad = $sizeMap[$size] ?? $sizeMap['sm'];

  // tone map (bg, hover, ring)
  $tones = [
    'emerald' => [
      'bg'   => 'from-emerald-600 to-emerald-500',
      'hov'  => 'hover:from-emerald-700 hover:to-emerald-600',
      'ring' => 'focus-visible:ring-emerald-400',
      'text' => 'text-white',
    ],
    'blue' => [
      'bg'   => 'from-blue-600 to-blue-500',
      'hov'  => 'hover:from-blue-700 hover:to-blue-600',
      'ring' => 'focus-visible:ring-blue-400',
      'text' => 'text-white',
    ],
    'indigo' => [
      'bg'   => 'from-indigo-600 to-indigo-500',
      'hov'  => 'hover:from-indigo-700 hover:to-indigo-600',
      'ring' => 'focus-visible:ring-indigo-400',
      'text' => 'text-white',
    ],
    'slate' => [
      'bg'   => 'from-slate-700 to-slate-600',
      'hov'  => 'hover:from-slate-800 hover:to-slate-700',
      'ring' => 'focus-visible:ring-slate-400',
      'text' => 'text-white',
    ],
  ];
  $toneCfg = $tones[$tone] ?? $tones['emerald'];

  $base = "group relative inline-flex items-center gap-2 rounded-lg font-semibold {$pad} ".
          "bg-gradient-to-r {$toneCfg['bg']} {$toneCfg['hov']} {$toneCfg['text']} shadow-sm ".
          "transition active:translate-y-[1px] select-none ".
          "focus:outline-none focus-visible:ring-2 {$toneCfg['ring']} focus-visible:ring-offset-2 ".
          "dark:focus-visible:ring-offset-gray-900";

  $blockCls = $block ? 'w-full justify-center' : '';
  $ringOverlay = 'absolute inset-0 rounded-lg ring-1 ring-inset ring-white/10 pointer-events-none';

  // disabled state styles
  if ($disabled) {
      $base = "inline-flex items-center gap-2 rounded-lg font-semibold {$pad} ".
              "bg-slate-200 text-slate-500 dark:bg-slate-700 dark:text-slate-300 ".
              "cursor-not-allowed opacity-70";
  }

  // icon size
  $iconSize = $size === 'md' ? 'h-5 w-5' : 'h-4 w-4';
@endphp

@if($disabled)
  <span {{ $attributes->merge(['class' => "{$base} {$blockCls}"]) }} aria-disabled="true">
    {{-- icon download (disabled tint) --}}
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
         class="{{ $iconSize }} shrink-0" fill="none"
         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
      <path d="M7 10l5 5 5-5"/>
      <path d="M12 15V3"/>
    </svg>
    <span>{{ $label }}</span>
  </span>
@else
  <a href="{{ $href }}"
     @if($download) download @endif
     @if($target) target="{{ $target }}" rel="{{ $target === '_blank' ? 'noopener noreferrer' : '' }}" @endif
     {{ $attributes->merge(['class' => "{$base} {$blockCls}"]) }}
     aria-label="{{ $label }}" title="{{ $label }}">
    {{-- icon download --}}
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
         class="{{ $iconSize }} shrink-0"
         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
      <path d="M7 10l5 5 5-5"/>
      <path d="M12 15V3"/>
    </svg>
    <span>{{ $label }}</span>
    <span class="{{ $ringOverlay }}"></span>
  </a>
@endif