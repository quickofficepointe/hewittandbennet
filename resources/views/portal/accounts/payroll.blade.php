@extends('layouts.portal')
@section('pageTitle', 'Payroll Payments')

@section('content')
<x-portal.card :padding="false" subtitle="Payrolls approved by the Director. Pay the net salaries, then mark the run as paid.">
    <x-portal.table :headers="['Period', 'Employees', 'Gross', 'Net to pay', 'Approved', 'Status', '']">
        @forelse ($runs as $run)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-medium">{{ $run->period_label }}</td>
                <td class="px-4 py-3">{{ $run->payslips_count }}</td>
                <td class="px-4 py-3">{{ money($run->total_gross) }}</td>
                <td class="px-4 py-3 font-semibold">{{ money($run->total_net) }}</td>
                <td class="px-4 py-3 text-xs">{{ $run->approved_at?->format('d M Y') }}</td>
                <td class="px-4 py-3"><x-portal.badge :status="$run->status" /></td>
                <td class="px-4 py-3 text-right"><a href="{{ route('portal.accounts.payroll.show', $run) }}" class="text-xs text-primary hover:underline">Open</a></td>
            </tr>
        @empty
            <tr><td colspan="7"><x-portal.empty icon="fa-money-check-dollar" message="No approved payrolls yet." /></td></tr>
        @endforelse
    </x-portal.table>
</x-portal.card>
@endsection
