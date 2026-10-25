@props(['label', 'value', 'icon' => 'fa-chart-simple', 'color' => 'blue', 'href' => null, 'hint' => null])
@php($tag = $href ? 'a' : 'div')
<{{ $tag }} @if ($href) href="{{ $href }}" @endif class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 flex items-start gap-4 {{ $href ? 'hover:border-primary/40 hover:shadow transition' : '' }}">
    <div class="h-11 w-11 shrink-0 rounded-lg bg-{{ $color }}-50 text-{{ $color }}-600 flex items-center justify-center">
        <i class="fa-solid {{ $icon }} text-lg"></i>
    </div>
    <div class="min-w-0">
        <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $label }}</div>
        <div class="mt-1 text-2xl font-semibold text-slate-800 truncate">{{ $value }}</div>
        @if ($hint)<div class="text-xs text-slate-500 mt-0.5">{{ $hint }}</div>@endif
    </div>
</{{ $tag }}>
