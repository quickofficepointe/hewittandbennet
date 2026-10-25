@props(['href' => null, 'variant' => 'primary', 'icon' => null, 'size' => 'md'])
@php
    $styles = [
        'primary' => 'bg-primary text-white hover:bg-primary-dark',
        'secondary' => 'bg-white text-slate-700 border border-slate-300 hover:bg-slate-50',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'success' => 'bg-green-600 text-white hover:bg-green-700',
        'ghost' => 'text-primary hover:bg-primary-50',
    ];
    $sizes = ['sm' => 'px-2.5 py-1.5 text-xs', 'md' => 'px-4 py-2 text-sm'];
    $classes = 'inline-flex items-center justify-center gap-2 rounded-lg font-medium transition '.$styles[$variant].' '.$sizes[$size];
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>@if ($icon)<i class="fa-solid {{ $icon }}"></i>@endif{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>@if ($icon)<i class="fa-solid {{ $icon }}"></i>@endif{{ $slot }}</button>
@endif
