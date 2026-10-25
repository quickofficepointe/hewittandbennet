@extends('layouts.portal')
@section('pageTitle', 'Employees')

@section('content')
<x-portal.card :padding="false">
    <x-slot:actions>
        <form method="GET" class="flex flex-wrap gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="Name, number or designation" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm">
            <select name="department_id" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
                <option value="">All departments</option>
                @foreach ($departments as $id => $name)<option value="{{ $id }}" @selected(request('department_id') == $id)>{{ $name }}</option>@endforeach
            </select>
            <select name="status" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
                <option value="">Any status</option>
                @foreach (\App\Models\Employee::STATUSES as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucwords(str_replace('_', ' ', $status)) }}</option>@endforeach
            </select>
            <x-portal.button size="sm" variant="secondary" icon="fa-filter">Filter</x-portal.button>
        </form>
        <x-portal.button size="sm" icon="fa-user-plus" :href="route('portal.hr.employees.create')">Add employee</x-portal.button>
    </x-slot:actions>

    <x-portal.table :headers="['Employee No.', 'Name', 'Designation', 'Department', 'Type', 'Gross pay', 'Portal', 'Status']">
        @forelse ($employees as $employee)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-mono text-xs"><a class="text-primary hover:underline" href="{{ route('portal.hr.employees.show', $employee) }}">{{ $employee->employee_no }}</a></td>
                <td class="px-4 py-3 font-medium"><a href="{{ route('portal.hr.employees.show', $employee) }}">{{ $employee->full_name }}</a></td>
                <td class="px-4 py-3">{{ $employee->designation }}</td>
                <td class="px-4 py-3">{{ $employee->department?->name ?? '-' }}</td>
                <td class="px-4 py-3">{{ \App\Models\Employee::TYPES[$employee->employment_type] }}</td>
                <td class="px-4 py-3 whitespace-nowrap">{{ money($employee->gross_pay) }}</td>
                <td class="px-4 py-3">{{ $employee->user?->role_label ?? '-' }}</td>
                <td class="px-4 py-3"><x-portal.badge :status="$employee->status" /></td>
            </tr>
        @empty
            <tr><td colspan="8"><x-portal.empty icon="fa-id-badge" message="No employees found." /></td></tr>
        @endforelse
    </x-portal.table>
    <div class="p-4">{{ $employees->links() }}</div>
</x-portal.card>
@endsection
