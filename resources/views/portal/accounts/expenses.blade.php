@extends('layouts.portal')
@section('pageTitle', 'Expenses')

@section('content')
<div class="grid gap-6 lg:grid-cols-3">
    <div class="space-y-6">
        <x-portal.card title="Record an expense">
            <form method="POST" action="{{ route('portal.accounts.expenses.store') }}" class="space-y-4">
                @csrf
                <x-portal.select name="expense_category_id" label="Category" :options="$categories" placeholder="Select..." required />
                <x-portal.input name="description" label="Description" required />
                <x-portal.input name="payee" label="Paid to" />
                <div class="grid grid-cols-2 gap-3">
                    <x-portal.input name="amount" type="number" step="0.01" min="1" label="Amount" required />
                    <x-portal.input name="expense_date" type="date" label="Date" :value="today()->format('Y-m-d')" required />
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <x-portal.select name="method" label="Method" :options="\App\Models\Payment::METHODS" required />
                    <x-portal.input name="reference" label="Reference" />
                </div>
                <x-portal.button icon="fa-paper-plane">Submit for approval</x-portal.button>
            </form>
        </x-portal.card>
        <x-portal.card title="Categories">
            <form method="POST" action="{{ route('portal.accounts.expenses.categories.store') }}" class="flex gap-2 mb-3">
                @csrf
                <input name="name" placeholder="New category" class="flex-1 rounded-lg border border-slate-300 px-3 py-1.5 text-sm" required>
                <x-portal.button size="sm" icon="fa-plus">Add</x-portal.button>
            </form>
            <div class="flex flex-wrap gap-1">@foreach ($categories as $name)<x-portal.badge color="gray">{{ $name }}</x-portal.badge>@endforeach</div>
        </x-portal.card>
    </div>

    <x-portal.card class="lg:col-span-2" :padding="false">
        <x-slot:actions>
            <form method="GET" class="flex flex-wrap gap-2">
                <select name="status" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
                    <option value="">Any status</option>
                    @foreach (['pending', 'approved', 'rejected'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>@endforeach
                </select>
                <select name="category_id" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
                    <option value="">All categories</option>
                    @foreach ($categories as $id => $name)<option value="{{ $id }}" @selected(request('category_id') == $id)>{{ $name }}</option>@endforeach
                </select>
                <input type="date" name="from" value="{{ request('from') }}" class="rounded-lg border border-slate-300 px-2 py-1.5 text-sm">
                <input type="date" name="to" value="{{ request('to') }}" class="rounded-lg border border-slate-300 px-2 py-1.5 text-sm">
                <x-portal.button size="sm" variant="secondary" icon="fa-filter">Filter</x-portal.button>
            </form>
        </x-slot:actions>
        <div class="px-5 py-3 text-sm bg-slate-50 border-b border-slate-100">Total for this filter: <strong>{{ money($total) }}</strong></div>
        <x-portal.table :headers="['Date', 'Category', 'Description', 'Paid to', 'Amount', 'Status', '']">
            @forelse ($expenses as $expense)
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $expense->expense_date->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $expense->category?->name }}</td>
                    <td class="px-4 py-3">{{ $expense->description }}<div class="text-xs text-slate-500">{{ \App\Models\Payment::METHODS[$expense->method] }} {{ $expense->reference }}</div></td>
                    <td class="px-4 py-3">{{ $expense->payee ?? '-' }}</td>
                    <td class="px-4 py-3 font-medium whitespace-nowrap">{{ money($expense->amount) }}</td>
                    <td class="px-4 py-3"><x-portal.badge :status="$expense->status" />
                        @if ($expense->approver)<div class="text-xs text-slate-500 mt-1">{{ $expense->approver->name }}</div>@endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        @if ($expense->status === 'pending')
                            <form method="POST" action="{{ route('portal.accounts.expenses.destroy', $expense) }}" onsubmit="return confirm('Delete this expense?')">@csrf @method('DELETE')<button class="text-xs text-red-600 hover:underline">Delete</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7"><x-portal.empty icon="fa-money-bill-transfer" message="No expenses found." /></td></tr>
            @endforelse
        </x-portal.table>
        <div class="p-4">{{ $expenses->links() }}</div>
    </x-portal.card>
</div>
@endsection
