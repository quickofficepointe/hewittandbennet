@extends('layouts.portal')
@section('pageTitle', 'Receive Payment')

@section('content')
@if (! $student)
    <x-portal.card title="1. Find the student" class="max-w-3xl">
        <form method="GET" class="flex gap-2">
            <input name="q" value="{{ request('q') }}" autofocus placeholder="Admission number, name, phone or ID number" class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <x-portal.button icon="fa-magnifying-glass">Search</x-portal.button>
        </form>
        @if (request()->filled('q'))
            <div class="mt-5 divide-y divide-slate-100">
                @forelse ($matches as $match)
                    <a href="{{ route('portal.accounts.payments.create', ['student' => $match->id]) }}" class="flex items-center justify-between py-3 hover:bg-slate-50 px-2 rounded">
                        <div>
                            <div class="font-medium">{{ $match->full_name }}</div>
                            <div class="text-xs text-slate-500"><span class="font-mono">{{ $match->admission_no }}</span> &middot; {{ $match->course?->name }} &middot; {{ ucfirst($match->status) }}</div>
                        </div>
                        <span class="text-sm {{ $match->balance > 0 ? 'text-red-600' : 'text-green-600' }}">Balance {{ money($match->balance) }}</span>
                    </a>
                @empty
                    <x-portal.empty message="No student matches that search." />
                @endforelse
            </div>
        @endif
    </x-portal.card>
@else
    <div class="grid gap-6 lg:grid-cols-3">
        <x-portal.card title="Student">
            <div class="font-semibold">{{ $student->full_name }}</div>
            <div class="text-sm text-slate-500 font-mono">{{ $student->admission_no }}</div>
            <div class="text-sm text-slate-500">{{ $student->course?->name }}</div>
            <div class="mt-4 text-sm space-y-1">
                <div class="flex justify-between"><span class="text-slate-500">Billed</span><span>{{ money($student->total_billed) }}</span></div>
                <div class="flex justify-between"><span class="text-slate-500">Paid</span><span>{{ money($student->total_paid) }}</span></div>
                <div class="flex justify-between font-semibold"><span>Balance</span><span class="{{ $student->balance > 0 ? 'text-red-600' : 'text-green-600' }}">{{ money($student->balance) }}</span></div>
            </div>
            <div class="mt-4 flex gap-2">
                <x-portal.button size="sm" variant="secondary" :href="route('portal.accounts.balances.statement', $student)">Statement</x-portal.button>
                <x-portal.button size="sm" variant="ghost" :href="route('portal.accounts.payments.create')">Change student</x-portal.button>
            </div>
        </x-portal.card>

        <x-portal.card title="2. Payment details" class="lg:col-span-2">
            <form method="POST" action="{{ route('portal.accounts.payments.store') }}" class="grid gap-4 sm:grid-cols-2" x-data="{ method: '{{ old('method', 'mpesa') }}' }">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <x-portal.input name="amount" type="number" step="0.01" min="1" label="Amount (KES)" :value="$student->balance > 0 ? $student->balance : null" required />
                <x-portal.input name="paid_on" type="date" label="Date paid" :value="today()->format('Y-m-d')" required />
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Method <span class="text-red-500">*</span></label>
                    <select name="method" x-model="method" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white">
                        @foreach (\App\Models\Payment::METHODS as $key => $label)<option value="{{ $key }}">{{ $label }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Transaction reference <span x-show="['mpesa','bank','cheque'].includes(method)" class="text-red-500">*</span></label>
                    <input name="reference" value="{{ old('reference') }}" :placeholder="method === 'mpesa' ? 'e.g. SJK4XY12AB' : 'Slip / cheque number'" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm uppercase">
                    @error('reference')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2"><x-portal.input name="notes" label="Being payment for (optional)" placeholder="e.g. Term 2 tuition" /></div>
                <div class="sm:col-span-2"><x-portal.button icon="fa-check">Record payment &amp; print receipt</x-portal.button></div>
            </form>
        </x-portal.card>
    </div>
@endif
@endsection
