@extends('layouts.portal')
@section('pageTitle', 'Invoices & Billing')

@section('content')
<div class="grid gap-6 lg:grid-cols-2 mb-6">
    <x-portal.card title="Bill a whole class" subtitle="Raises invoices from the fee structure for every active student in the chosen course term. Already-billed items are skipped.">
        <form method="POST" action="{{ route('portal.accounts.invoices.bulk') }}" class="grid gap-3 sm:grid-cols-2" onsubmit="return confirm('Raise invoices for all matching students?')">
            @csrf
            <x-portal.select name="course_id" label="Course" :options="$courses->pluck('name', 'id')" placeholder="Select..." required />
            <x-portal.select name="intake_id" label="Intake" :options="$intakes" placeholder="All intakes" />
            <x-portal.input name="term_no" type="number" min="1" max="12" label="Course term" value="1" required />
            <x-portal.select name="academic_term_id" label="Academic term" :options="$terms" :value="$currentTerm?->id" placeholder="Select..." required />
            <x-portal.input name="invoice_date" type="date" label="Invoice date" :value="today()->format('Y-m-d')" required />
            <x-portal.input name="due_date" type="date" label="Due date" />
            <label class="sm:col-span-2 flex items-center gap-2 text-sm"><input type="checkbox" name="include_once_off" value="1" class="rounded"> Include once-off items (admission, uniform...)</label>
            <div class="sm:col-span-2"><x-portal.button icon="fa-file-invoice">Raise class invoices</x-portal.button></div>
        </form>
    </x-portal.card>

    <x-portal.card title="Invoice one student" subtitle="For fines, repeat fees, exam fees and other charges.">
        <form method="POST" action="{{ route('portal.accounts.invoices.store') }}" class="grid gap-3 sm:grid-cols-2">
            @csrf
            <x-portal.input name="admission_no" label="Admission number" placeholder="HBIC/{{ date('Y') }}/0001" required />
            <x-portal.input name="amount" type="number" step="0.01" min="1" label="Amount (KES)" required />
            <div class="sm:col-span-2"><x-portal.input name="description" label="Description" placeholder="e.g. Exam re-sit fee" required /></div>
            <x-portal.select name="academic_term_id" label="Academic term" :options="$terms" :value="$currentTerm?->id" placeholder="None" />
            <x-portal.input name="invoice_date" type="date" label="Invoice date" :value="today()->format('Y-m-d')" required />
            <x-portal.input name="due_date" type="date" label="Due date" />
            <div class="sm:col-span-2"><x-portal.button icon="fa-plus">Raise invoice</x-portal.button></div>
        </form>
    </x-portal.card>
</div>

<x-portal.card title="Invoices" :padding="false">
    <x-slot:actions>
        <form method="GET" class="flex gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="Invoice no., student, description" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm">
            <x-portal.button size="sm" variant="secondary" icon="fa-magnifying-glass">Search</x-portal.button>
        </form>
    </x-slot:actions>
    <x-portal.table :headers="['Invoice', 'Date', 'Student', 'Description', 'Term', 'Amount', '']">
        @forelse ($invoices as $invoice)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-mono text-xs">{{ $invoice->invoice_no }}</td>
                <td class="px-4 py-3 whitespace-nowrap">{{ $invoice->invoice_date->format('d M Y') }}</td>
                <td class="px-4 py-3"><a class="hover:text-primary" href="{{ route('portal.accounts.balances.statement', $invoice->student_id) }}">{{ $invoice->student?->full_name }}</a> <div class="text-xs font-mono text-slate-500">{{ $invoice->student?->admission_no }}</div></td>
                <td class="px-4 py-3">{{ $invoice->description }}</td>
                <td class="px-4 py-3">{{ $invoice->term?->name ?? '-' }}</td>
                <td class="px-4 py-3 font-medium whitespace-nowrap">{{ money($invoice->amount) }}</td>
                <td class="px-4 py-3 text-right">
                    <form method="POST" action="{{ route('portal.accounts.invoices.destroy', $invoice) }}" onsubmit="return confirm('Cancel this invoice?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-600 hover:underline">Cancel</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7"><x-portal.empty icon="fa-file-invoice" message="No invoices yet." /></td></tr>
        @endforelse
    </x-portal.table>
    <div class="p-4">{{ $invoices->links() }}</div>
</x-portal.card>
@endsection
