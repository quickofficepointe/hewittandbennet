@props(['name', 'label' => null, 'type' => 'text', 'value' => null, 'required' => false, 'help' => null])
@php($id = $attributes->get('id', str_replace(['[', ']'], ['_', ''], $name)))
<div>
    @if ($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-slate-700 mb-1">{{ $label }} @if ($required)<span class="text-red-500">*</span>@endif</label>
    @endif
    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}"
           @if ($type !== 'file' && $type !== 'password') value="{{ old(str_replace(['[', ']'], ['.', ''], $name), $value) }}" @endif
           @if ($required) required @endif
           {{ $attributes->merge(['class' => 'block w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none '.($errors->has($name) ? 'border-red-400' : '')]) }}>
    @if ($help)<p class="mt-1 text-xs text-slate-500">{{ $help }}</p>@endif
    @error($name)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
