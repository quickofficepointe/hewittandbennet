@extends('layouts.portal')
@section('pageTitle', 'Finance Report '.$year)

@section('content')
<div class="no-print flex flex-wrap items-center justify-between gap-3 mb-6">
    <form method="GET" class="flex gap-2 items-center">
        <label class="text-sm text-slate-600">Year</label>
        <select name="year" onchange="this.form.submit()" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
            @foreach (range(now()->year, now()->year - 5) as $y)<option value="{{ $y }}" @selected($year === $y)>{{ $y }}</option>@endforeach
        </select>
    </form>
    <div class="flex gap-2">
        <x-portal.button variant="secondary" icon="fa-chart-line" :href="route('portal.accounts.reports', ['year' => $year])">Detailed accounts report</x-portal.button>
        <x-portal.button variant="secondary" type="button" onclick="window.print()" icon="fa-print">Print</x-portal.button>
    </div>
</div>

@php($net = $collected - $expenses - $payroll)
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3 mb-6">
    <x-portal.stat label="Fees billed" :value="money($billed)" icon="fa-file-invoice" color="indigo" />
    <x-portal.stat label="Fees collected" :value="money($collected)" icon="fa-sack-dollar" color="green" :hint="$billed > 0 ? round($collected / $billed * 100).'% collection rate' : null" />
    <x-portal.stat label="Outstanding (all time)" :value="money($outstanding)" icon="fa-scale-unbalanced" color="red" />
    <x-portal.stat label="Operating expenses" :value="money($expenses)" icon="fa-money-bill-transfer" color="amber" />
    <x-portal.stat label="Salaries paid" :value="money($payroll)" icon="fa-money-check-dollar" color="indigo" />
    <x-portal.stat :label="$net >= 0 ? 'Net surplus' : 'Net deficit'" :value="money(abs($net))" icon="fa-scale-balanced" :color="$net >= 0 ? 'green' : 'red'" />
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card title="Monthly trend" class="lg:col-span-2"><canvas id="director-finance-report" height="110"></canvas></x-portal.card>
    <x-portal.card title="Collections by method">
        @forelse ($byMethod as $method => $amount)
            <div class="flex justify-between text-sm py-1.5 border-b border-slate-100 last:border-0"><span>{{ \App\Models\Payment::METHODS[$method] ?? $method }}</span><span class="font-medium">{{ money($amount) }}</span></div>
        @empty
            <x-portal.empty message="No payments this year." />
        @endforelse
    </x-portal.card>
    <x-portal.card title="Largest approved expenses" class="lg:col-span-3" :padding="false">
        <x-portal.table :headers="['Date', 'Category', 'Description', 'Paid to', 'Amount']">
            @forelse ($topExpenses as $expense)
                <tr>
                    <td class="px-4 py-2">{{ $expense->expense_date->format('d M Y') }}</td>
                    <td class="px-4 py-2">{{ $expense->category?->name }}</td>
                    <td class="px-4 py-2">{{ $expense->description }}</td>
                    <td class="px-4 py-2">{{ $expense->payee ?? '-' }}</td>
                    <td class="px-4 py-2 font-medium">{{ money($expense->amount) }}</td>
                </tr>
            @empty
                <tr><td colspan="5"><x-portal.empty message="No approved expenses this year." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>
</div>
@endsection

@push('scripts')
@include('portal.partials.finance-chart', ['canvas' => 'director-finance-report', 'monthly' => $monthly])
@endpush
