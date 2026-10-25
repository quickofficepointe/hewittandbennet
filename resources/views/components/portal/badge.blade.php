@props(['status' => null, 'color' => null])
@php($color = $color ?? status_color($status))
<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-full bg-{$color}-100 text-{$color}-800 px-2.5 py-0.5 text-xs font-medium whitespace-nowrap"]) }}>{{ $slot->isEmpty() ? ucwords(str_replace('_', ' ', (string) $status)) : $slot }}</span>
