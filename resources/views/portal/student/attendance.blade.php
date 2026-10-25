@extends('layouts.portal')
@section('pageTitle', 'My Attendance')

@section('content')
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3 mb-6">
    @forelse ($byUnit as $row)
        @php($rate = round($row->attended / max(1, $row->total) * 100))
        <x-portal.card>
            <div class="flex justify-between items-start">
                <div>
                    <div class="text-xs font-mono text-primary">{{ $row->unit?->code }}</div>
                    <div class="font-medium text-sm">{{ $row->unit?->name }}</div>
                </div>
                <div class="text-2xl font-semibold {{ $rate < 75 ? 'text-red-600' : 'text-green-600' }}">{{ $rate }}%</div>
            </div>
            <div class="mt-3 h-2 rounded-full bg-slate-100"><div class="h-2 rounded-full {{ $rate < 75 ? 'bg-red-500' : 'bg-green-500' }}" style="width: {{ $rate }}%"></div></div>
            <div class="mt-2 text-xs text-slate-500">{{ $row->attended }} of {{ $row->total }} sessions attended</div>
        </x-portal.card>
    @empty
        <x-portal.card class="sm:col-span-2 xl:col-span-3"><x-portal.empty icon="fa-clipboard-user" message="No attendance has been recorded yet." /></x-portal.card>
    @endforelse
</div>

@if ($records->isNotEmpty())
    <x-portal.card title="Register history" :padding="false">
        <x-portal.table :headers="['Date', 'Unit', 'Status']">
            @foreach ($records as $record)
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $record->date->format('D, d M Y') }}</td>
                    <td class="px-4 py-2">{{ $record->unit?->code }} - {{ $record->unit?->name }}</td>
                    <td class="px-4 py-2"><x-portal.badge :status="$record->status" /></td>
                </tr>
            @endforeach
        </x-portal.table>
        <div class="p-4">{{ $records->links() }}</div>
    </x-portal.card>
@endif
@endsection
