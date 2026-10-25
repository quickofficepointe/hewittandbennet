@extends('layouts.portal')
@section('pageTitle', 'Payments & Receipts')

@section('content')
<x-portal.card :padding="false">
    <x-slot:actions>
        <form method="GET" class="flex flex-wrap gap-2 items-center">
            <input name="q" value="{{ request('q') }}" placeholder="Receipt, ref, student" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm">
            <select name="method" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
                <option value="">All methods</option>
                @foreach (\App\Models\Payment::METHODS as $key => $label)<option value="{{ $key }}" @selected(request('method') === $key)>{{ $label }}</option>@endforeach
            </select>
            <input type="date" name="from" value="{{ request('from') }}" class="rounded-lg border border-slate-300 px-2 py-1.5 text-sm" title="From">
            <input type="date" name="to" value="{{ request('to') }}" class="rounded-lg border border-slate-300 px-2 py-1.5 text-sm" title="To">
            <x-portal.button size="sm" variant="secondary" icon="fa-filter">Filter</x-portal.button>
        </form>
        <x-portal.button size="sm" icon="fa-plus" :href="route('portal.accounts.payments.create')">Receive payment</x-portal.button>
    </x-slot:actions>

    <div class="px-5 py-3 text-sm bg-slate-50 border-b border-slate-100">Total for this filter: <strong>{{ money($total) }}</strong></div>
    <x-portal.table :headers="['Receipt', 'Date', 'Student', 'Method', 'Reference', 'Amount', 'Served by', '']">
        @forelse ($payments as $payment)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-mono text-xs"><a class="text-primary hover:underline" href="{{ route('portal.accounts.payments.receipt', $payment) }}">{{ $payment->receipt_no }}</a></td>
                <td class="px-4 py-3 whitespace-nowrap">{{ $payment->paid_on->format('d M Y') }}</td>
                <td class="px-4 py-3"><a href="{{ route('portal.accounts.balances.statement', $payment->student_id) }}" class="hover:text-primary">{{ $payment->student?->full_name }}</a> <div class="text-xs text-slate-500 font-mono">{{ $payment->student?->admission_no }}</div></td>
                <td class="px-4 py-3">{{ \App\Models\Payment::METHODS[$payment->method] }}</td>
                <td class="px-4 py-3 font-mono text-xs">{{ $payment->reference ?? '-' }}</td>
                <td class="px-4 py-3 font-medium whitespace-nowrap">{{ money($payment->amount) }}</td>
                <td class="px-4 py-3 text-slate-500">{{ $payment->receiver?->name }}</td>
                <td class="px-4 py-3 text-right whitespace-nowrap">
                    <a href="{{ route('portal.accounts.payments.receipt', $payment) }}" class="text-xs text-primary hover:underline mr-2"><i class="fa-solid fa-print"></i></a>
                    <form method="POST" action="{{ route('portal.accounts.payments.destroy', $payment) }}" class="inline" onsubmit="return confirm('Reverse this payment? Only do this for payments captured in error.')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-600 hover:underline">Reverse</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="8"><x-portal.empty icon="fa-receipt" message="No payments found." /></td></tr>
        @endforelse
    </x-portal.table>
    <div class="p-4">{{ $payments->links() }}</div>
</x-portal.card>
@endsection
