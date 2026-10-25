@props(['title' => null, 'subtitle' => null, 'padding' => true])
<div {{ $attributes->merge(['class' => 'print-area bg-white rounded-xl shadow-sm border border-slate-200']) }}>
    @if ($title || isset($actions))
        <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-slate-100">
            <div>
                @if ($title)<h2 class="font-semibold text-slate-800">{{ $title }}</h2>@endif
                @if ($subtitle)<p class="text-xs text-slate-500 mt-0.5">{{ $subtitle }}</p>@endif
            </div>
            @isset($actions)
                <div class="flex flex-wrap items-center gap-2 no-print">{{ $actions }}</div>
            @endisset
        </div>
    @endif
    <div class="{{ $padding ? 'p-5' : '' }}">
        {{ $slot }}
    </div>
</div>
