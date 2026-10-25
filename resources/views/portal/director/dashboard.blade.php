@extends('layouts.portal')
@section('pageTitle', 'Executive Dashboard')

@section('content')
<div class="mb-6 flex flex-wrap items-end justify-between gap-3">
    <div>
        <h2 class="text-xl font-semibold">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ \Illuminate\Support\Str::before(auth()->user()->name, ' ') }}</h2>
        <p class="text-sm text-slate-500">College performance at a glance &middot; {{ now()->format('l, d F Y') }}</p>
    </div>
    <div class="flex gap-2 no-print">
        <x-portal.button size="sm" variant="secondary" icon="fa-graduation-cap" :href="route('portal.director.reports.academic')">Academic</x-portal.button>
        <x-portal.button size="sm" variant="secondary" icon="fa-sack-dollar" :href="route('portal.director.reports.finance')">Finance</x-portal.button>
        <x-portal.button size="sm" variant="secondary" icon="fa-people-group" :href="route('portal.director.reports.hr')">HR</x-portal.button>
    </div>
</div>

@if ($approvals['expenses'] || $approvals['payroll']->isNotEmpty())
    <div class="mb-6 grid gap-3 md:grid-cols-2">
        @if ($approvals['expenses'])
            <a href="{{ route('portal.director.expenses') }}" class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-amber-900 text-sm flex items-center justify-between hover:border-amber-400">
                <span><i class="fa-solid fa-file-signature mr-1"></i> <strong>{{ $approvals['expenses'] }}</strong> expense(s) worth <strong>{{ money($approvals['expensesValue']) }}</strong> await your approval</span>
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        @endif
        @foreach ($approvals['payroll'] as $run)
            <a href="{{ route('portal.director.payroll', ['run' => $run->id]) }}" class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-amber-900 text-sm flex items-center justify-between hover:border-amber-400">
                <span><i class="fa-solid fa-money-check-dollar mr-1"></i> {{ $run->period_label }} payroll ({{ $run->payslips_count }} staff, {{ money($run->total_net) }} net) awaits approval</span>
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        @endforeach
    </div>
@endif

<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 mb-6">
    <x-portal.stat label="Active students" :value="number_format($kpis['students'])" icon="fa-user-graduate" :hint="$kpis['newThisYear'].' admitted in '.now()->year" :href="route('portal.admin.students.index')" />
    <x-portal.stat label="Fees collected {{ now()->year }}" :value="money($kpis['collectedYear'])" icon="fa-sack-dollar" color="green"
                   :hint="($kpis['collectionRate'] !== null ? $kpis['collectionRate'].'% of billed' : 'Nothing billed yet').' · '.money($kpis['collectedMonth']).' this month'" />
    <x-portal.stat label="Outstanding fees" :value="money($kpis['outstanding'])" icon="fa-scale-unbalanced" color="red" :href="route('portal.accounts.balances')" />
    <x-portal.stat label="Staff" :value="$kpis['staff']" icon="fa-id-badge" color="indigo" :hint="$approvals['leave'].' leave request(s) pending'" :href="route('portal.hr.employees.index')" />
    <x-portal.stat label="Attendance (30 days)" :value="$kpis['attendanceRate'] !== null ? $kpis['attendanceRate'].'%' : '-'" icon="fa-clipboard-user" color="teal" />
    <x-portal.stat label="Pending applications" :value="$kpis['pendingApplications']" icon="fa-inbox" color="amber" :href="route('portal.admin.applications.index', ['status' => 'pending'])" />
    <x-portal.stat label="Units without a trainer" :value="$kpis['unassignedUnits']" icon="fa-chalkboard-user" :color="$kpis['unassignedUnits'] ? 'red' : 'green'" :href="route('portal.admin.units.index')" />
    <x-portal.stat label="Courses running" :value="$enrolment->count()" icon="fa-book" color="blue" :href="route('portal.director.reports.academic')" />
</div>

<div class="grid gap-6 lg:grid-cols-3">
    <x-portal.card title="Income vs expenditure {{ now()->year }}" class="lg:col-span-2">
        <canvas id="director-finance" height="110"></canvas>
    </x-portal.card>

    <x-portal.card title="Student status">
        <canvas id="director-status" height="200"></canvas>
    </x-portal.card>

    <x-portal.card title="Admissions - last 12 months" class="lg:col-span-2">
        <canvas id="director-admissions" height="100"></canvas>
    </x-portal.card>

    <x-portal.card title="Enrolment by course">
        @forelse ($enrolment as $course)
            @php($max = max(1, $enrolment->max('students_count')))
            <div class="mb-3">
                <div class="flex justify-between text-sm mb-1"><span class="truncate pr-3">{{ $course->name }}</span><span class="font-medium">{{ $course->students_count }}</span></div>
                <div class="h-2 rounded-full bg-slate-100"><div class="h-2 rounded-full bg-primary" style="width: {{ $course->students_count / $max * 100 }}%"></div></div>
            </div>
        @empty
            <x-portal.empty message="No active students yet." />
        @endforelse
    </x-portal.card>

    <x-portal.card title="Latest fee payments" class="lg:col-span-3" :padding="false">
        <x-portal.table :headers="['Receipt', 'Date', 'Student', 'Method', 'Amount']">
            @forelse ($recentPayments as $payment)
                <tr>
                    <td class="px-4 py-2 font-mono text-xs">{{ $payment->receipt_no }}</td>
                    <td class="px-4 py-2">{{ $payment->paid_on->format('d M Y') }}</td>
                    <td class="px-4 py-2">{{ $payment->student?->full_name }}</td>
                    <td class="px-4 py-2">{{ \App\Models\Payment::METHODS[$payment->method] }}</td>
                    <td class="px-4 py-2 font-medium">{{ money($payment->amount) }}</td>
                </tr>
            @empty
                <tr><td colspan="5"><x-portal.empty message="No payments yet." /></td></tr>
            @endforelse
        </x-portal.table>
    </x-portal.card>
</div>
@endsection

@push('scripts')
@include('portal.partials.finance-chart', ['canvas' => 'director-finance', 'monthly' => $monthly])
<script>
    (function () {
        if (typeof Chart === 'undefined') return;
        const admissions = @json($admissions);
        new Chart(document.getElementById('director-admissions'), {
            type: 'line',
            data: { labels: admissions.map(a => a.label), datasets: [{ label: 'New students', data: admissions.map(a => a.total), borderColor: '#1E3A8A', backgroundColor: 'rgba(30,58,138,.08)', fill: true, tension: .3, pointRadius: 3 }] },
            options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } }, x: { grid: { display: false } } } },
        });

        const status = @json($statusMix);
        const colors = { active: '#1E3A8A', graduated: '#16A34A', deferred: '#F59E0B', suspended: '#DC2626', discontinued: '#94A3B8' };
        const keys = Object.keys(status);
        new Chart(document.getElementById('director-status'), {
            type: 'doughnut',
            data: { labels: keys.map(k => k.charAt(0).toUpperCase() + k.slice(1)), datasets: [{ data: keys.map(k => status[k]), backgroundColor: keys.map(k => colors[k] || '#CBD5E1'), borderWidth: 2, borderColor: '#fff' }] },
            options: { cutout: '65%', plugins: { legend: { position: 'bottom', labels: { boxWidth: 12 } } } },
        });
    })();
</script>
@endpush
