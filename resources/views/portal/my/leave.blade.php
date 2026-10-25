@extends('layouts.portal')
@section('pageTitle', 'My Leave')

@section('content')
@if (! $employee)
    <x-portal.card>
        <x-portal.empty icon="fa-id-badge" message="You do not have an employee record yet. Please ask HR to link your portal account to an employee profile." />
    </x-portal.card>
@else
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">
        @foreach ($balances as $balance)
            <x-portal.stat :label="$balance['type']->name" :value="$balance['remaining'].' days left'" icon="fa-umbrella-beach" color="teal"
                           :hint="$balance['taken'].' of '.$balance['type']->days_per_year.' used in '.now()->year" />
        @endforeach
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <x-portal.card title="Apply for leave" class="h-fit">
            <form method="POST" action="{{ route('portal.my.leave.store') }}" class="space-y-4">
                @csrf
                <x-portal.select name="leave_type_id" label="Leave type" :options="$types->pluck('name', 'id')" placeholder="Select..." required />
                <div class="grid grid-cols-2 gap-3">
                    <x-portal.input name="start_date" type="date" label="From" required />
                    <x-portal.input name="end_date" type="date" label="To" required />
                </div>
                <x-portal.textarea name="reason" label="Reason" />
                <p class="text-xs text-slate-500">Sundays are not counted as leave days.</p>
                <x-portal.button icon="fa-paper-plane">Submit application</x-portal.button>
            </form>
        </x-portal.card>

        <x-portal.card title="My leave history" class="lg:col-span-2" :padding="false">
            <x-portal.table :headers="['Type', 'Dates', 'Days', 'Status', 'HR notes', '']">
                @forelse ($requests as $request)
                    <tr>
                        <td class="px-4 py-3">{{ $request->type->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $request->start_date->format('d M') }} - {{ $request->end_date->format('d M Y') }}</td>
                        <td class="px-4 py-3">{{ $request->days }}</td>
                        <td class="px-4 py-3"><x-portal.badge :status="$request->status" /></td>
                        <td class="px-4 py-3 text-slate-500">{{ $request->review_notes }}</td>
                        <td class="px-4 py-3 text-right">
                            @if ($request->status === 'pending')
                                <form method="POST" action="{{ route('portal.my.leave.cancel', $request) }}">
                                    @csrf @method('PATCH')
                                    <button class="text-xs text-red-600 hover:underline">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><x-portal.empty message="No leave applications yet." /></td></tr>
                @endforelse
            </x-portal.table>
        </x-portal.card>
    </div>
@endif
@endsection
