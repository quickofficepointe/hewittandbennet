@extends('layouts.portal')
@section('pageTitle', 'Financial Reports '.$year)

@section('content')
<div class="no-print flex flex-wrap items-center justify-between gap-3 mb-6">
    <form method="GET" class="flex gap-2 items-center">
        <label class="text-sm text-slate-600">Year</label>
        <select name="year" onchange="this.form.submit()" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
            @foreach (range(now()->year, now()->year - 5) as $y)<option value="{{ $y }}" @selected($year === $y)>{{ $y }}</option>@endforeach
        </select>
    </form>
    <x-portal.button variant="secondary" type="button" onclick="window.print()" icon="fa-print">Print report</x-portal.button>
</div>

@php($surplus = $totals['income'] - $totals['expenses'] - $totals['payroll'])
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">
    <x-portal.stat label="Fee income" :value="money($totals['income'])" icon="fa-arrow-trend-up" color="green" />
    <x-portal.stat label="Approved expenses" :value="money($totals['expenses'])" icon="fa-arrow-trend-down" color="amber" />
    <x-portal.stat label="Salaries paid" :value="money($totals['payroll'])" icon="fa-money-check-dollar" color="indigo" />
    <x-portal.stat :label="$surplus >= 0 ? 'Surplus' : 'Deficit'" :value="money(abs($surplus))" icon="fa-scale-balanced" :color="$surplus >= 0 ? 'green' : 'red'" />
</div>

<div class="grid gap-6 lg:grid-cols-2">
    <x-portal.card title="Monthly income & expenditure" class="lg:col-span-2">
        <canvas id="report-monthly" height="90"></canvas>
    </x-portal.card>

    <x-portal.card title="Income statement by month" :padding="false">
        <x-portal.table :headers="['Month', 'Income', 'Expenses', 'Salaries', 'Net']">
            @foreach ($monthly as $row)
                @php($net = $row['income'] - $row['expenses'] - $row['payroll'])
                <tr>
                    <td class="px-4 py-2">{{ $row['month'] }}</td>
                    <td class="px-4 py-2 text-right">{{ money($row['income'], false) }}</td>
                    <td class="px-4 py-2 text-right">{{ money($row['expenses'], false) }}</td>
                    <td class="px-4 py-2 text-right">{{ money($row['payroll'], false) }}</td>
                    <td class="px-4 py-2 text-right font-medium {{ $net < 0 ? 'text-red-600' : '' }}">{{ money($net, false) }}</td>
                </tr>
            @endforeach
        </x-portal.table>
    </x-portal.card>

    <div class="space-y-6">
        <x-portal.card title="Expenses by category">
            @forelse ($byCategory as $name => $amount)
                <div class="flex justify-between text-sm py-1.5 border-b border-slate-100 last:border-0"><span>{{ $name }}</span><span class="font-medium">{{ money($amount) }}</span></div>
            @empty
                <x-portal.empty message="No approved expenses this year." />
            @endforelse
        </x-portal.card>
        <x-portal.card title="Collections by payment method">
            @forelse ($byMethod as $method => $amount)
                <div class="flex justify-between text-sm py-1.5 border-b border-slate-100 last:border-0"><span>{{ \App\Models\Payment::METHODS[$method] ?? $method }}</span><span class="font-medium">{{ money($amount) }}</span></div>
            @empty
                <x-portal.empty message="No payments this year." />
            @endforelse
        </x-portal.card>
    </div>

    <x-portal.card title="Billed vs collected by course" class="lg:col-span-2" :padding="false">
        <x-portal.table :headers="['Course', 'Billed', 'Collected', 'Collection rate']">
            @forelse ($byCourse as $row)
                <tr>
                    <td class="px-4 py-2">{{ $row['course'] }}</td>
                    <td class="px-4 py-2 text-right">{{ money($row['billed'], false) }}</td>
                    <td class="px-4 py-2 text-right">{{ money($row['collected'], false) }}</td>
                    <td class="px-4 py-2 text-right">{{ $row['billed'] > 0 ? round($row['collected'] / $row['billed'] * 100).'%' : '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="4"><x-portal.empty message="No billing this year." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>
</div>
@endsection

@push('scripts')
@include('portal.partials.finance-chart', ['canvas' => 'report-monthly', 'monthly' => $monthly])
@endpush
