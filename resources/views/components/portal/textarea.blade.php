@props(['name', 'label' => null, 'value' => null, 'required' => false, 'rows' => 3, 'help' => null])
<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 mb-1">{{ $label }} @if ($required)<span class="text-red-500">*</span>@endif</label>
    @endif
    <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $rows }}" @if ($required) required @endif
              {{ $attributes->merge(['class' => 'block w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none']) }}>{{ old($name, $value) }}</textarea>
    @if ($help)<p class="mt-1 text-xs text-slate-500">{{ $help }}</p>@endif
    @error($name)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
