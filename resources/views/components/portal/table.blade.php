@props(['headers' => [], 'datatable' => false])
<div class="overflow-x-auto">
    <table @if ($datatable) data-table="true" @endif {{ $attributes->merge(['class' => 'min-w-full text-sm']) }}>
        <thead>
            <tr class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                @foreach ($headers as $header)
                    <th class="px-4 py-3 whitespace-nowrap">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            {{ $slot }}
        </tbody>
    </table>
</div>
