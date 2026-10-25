@extends('layouts.portal')
@section('pageTitle', 'Payroll Approvals')

@section('content')
<x-portal.card :padding="false" subtitle="HR prepares each month's payroll; open a draft to review and approve it.">
    <x-portal.table :headers="['Period', 'Employees', 'Gross', 'Net', 'Prepared by', 'Status', '']">
        @forelse ($runs as $run)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-medium">{{ $run->period_label }}</td>
                <td class="px-4 py-3">{{ $run->payslips_count }}</td>
                <td class="px-4 py-3">{{ money($run->total_gross) }}</td>
                <td class="px-4 py-3 font-semibold">{{ money($run->total_net) }}</td>
                <td class="px-4 py-3">{{ $run->preparer?->name }}</td>
                <td class="px-4 py-3"><x-portal.badge :status="$run->status" /></td>
                <td class="px-4 py-3 text-right"><a href="{{ route('portal.director.payroll', ['run' => $run->id]) }}" class="text-xs text-primary hover:underline">{{ $run->status === 'draft' ? 'Review & approve' : 'View' }}</a></td>
            </tr>
        @empty
            <tr><td colspan="7"><x-portal.empty icon="fa-money-check-dollar" message="No payroll has been prepared yet." /></td></tr>
        @endforelse
    </x-portal.table>
</x-portal.card>
@endsection
