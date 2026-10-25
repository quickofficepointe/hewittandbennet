@props(['name', 'label' => null, 'options' => [], 'value' => null, 'required' => false, 'placeholder' => null])
@php($selected = (string) old($name, $value))
<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 mb-1">{{ $label }} @if ($required)<span class="text-red-500">*</span>@endif</label>
    @endif
    <select id="{{ $name }}" name="{{ $name }}" @if ($required) required @endif
            {{ $attributes->merge(['class' => 'block w-full rounded-lg border-slate-300 border px-3 py-2 text-sm bg-white focus:border-primary focus:ring-1 focus:ring-primary outline-none']) }}>
        @if ($placeholder !== null)<option value="">{{ $placeholder }}</option>@endif
        @foreach ($options as $key => $text)
            <option value="{{ $key }}" @selected($selected === (string) $key)>{{ $text }}</option>
        @endforeach
    </select>
    @error($name)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
