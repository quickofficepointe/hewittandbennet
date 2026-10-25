@extends('layouts.portal')
@section('pageTitle', 'Leave Requests')

@section('content')
<x-portal.card :padding="false">
    <x-slot:actions>
        <div class="flex gap-1 text-sm">
            @foreach (['pending', 'approved', 'rejected', 'cancelled', 'all'] as $option)
                <a href="{{ route('portal.hr.leave.index', ['status' => $option]) }}" class="px-3 py-1.5 rounded-lg {{ $status === $option ? 'bg-primary text-white' : 'hover:bg-slate-100' }}">{{ ucfirst($option) }}</a>
            @endforeach
        </div>
    </x-slot:actions>
    <x-portal.table :headers="['Employee', 'Type', 'Dates', 'Days', 'Reason', 'Status', 'Decision']">
        @forelse ($requests as $request)
            <tr class="align-top">
                <td class="px-4 py-3"><div class="font-medium">{{ $request->employee?->full_name }}</div><div class="text-xs text-slate-500">{{ $request->employee?->department?->name }}</div></td>
                <td class="px-4 py-3">{{ $request->type->name }}</td>
                <td class="px-4 py-3 whitespace-nowrap">{{ $request->start_date->format('d M Y') }}<br>{{ $request->end_date->format('d M Y') }}</td>
                <td class="px-4 py-3">{{ $request->days }}</td>
                <td class="px-4 py-3 max-w-xs text-slate-600">{{ $request->reason ?: '-' }}</td>
                <td class="px-4 py-3"><x-portal.badge :status="$request->status" />
                    @if ($request->reviewer)<div class="text-xs text-slate-500 mt-1">by {{ $request->reviewer->name }}</div>@endif
                </td>
                <td class="px-4 py-3">
                    @if ($request->status === 'pending')
                        <form method="POST" action="{{ route('portal.hr.leave.decide', $request) }}" class="space-y-2 min-w-[12rem]">
                            @csrf @method('PATCH')
                            <input name="review_notes" placeholder="Note (optional)" class="w-full rounded border border-slate-300 px-2 py-1 text-xs">
                            <div class="flex gap-1">
                                <x-portal.button size="sm" variant="success" name="decision" value="approved">Approve</x-portal.button>
                                <x-portal.button size="sm" variant="danger" name="decision" value="rejected">Reject</x-portal.button>
                            </div>
                        </form>
                    @else
                        <span class="text-xs text-slate-500">{{ $request->review_notes }}</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7"><x-portal.empty icon="fa-plane-departure" message="No leave requests in this list." /></td></tr>
        @endforelse
    </x-portal.table>
    <div class="p-4">{{ $requests->links() }}</div>
</x-portal.card>
@endsection
