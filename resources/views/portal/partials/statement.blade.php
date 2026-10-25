{{-- Running-balance fee statement. Needs: $student, $lines (App\Support\Statement), $receiptRoute (route name taking a payment) --}}
<x-portal.print-header title="Fee Statement">
    <div class="text-xs text-slate-500">As at {{ now()->format('d M Y') }}</div>
</x-portal.print-header>
<div class="grid grid-cols-2 gap-2 text-sm mb-4">
    <div><span class="text-slate-500">Student:</span> <strong>{{ $student->full_name }}</strong></div>
    <div><span class="text-slate-500">Admission No.:</span> <strong>{{ $student->admission_no }}</strong></div>
    <div><span class="text-slate-500">Course:</span> {{ $student->course?->name }}</div>
    <div><span class="text-slate-500">Phone:</span> {{ $student->phone ?? '-' }}</div>
</div>
<div class="overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="bg-slate-50 text-left text-xs uppercase text-slate-500">
                <th class="px-3 py-2">Date</th><th class="px-3 py-2">Ref</th><th class="px-3 py-2">Description</th>
                <th class="px-3 py-2 text-right">Debit</th><th class="px-3 py-2 text-right">Credit</th><th class="px-3 py-2 text-right">Balance</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($lines as $line)
                <tr>
                    <td class="px-3 py-2 whitespace-nowrap">{{ $line['date']->format('d M Y') }}</td>
                    <td class="px-3 py-2 font-mono text-xs whitespace-nowrap">
                        @if ($line['payment'])
                            <a href="{{ route($receiptRoute, $line['payment']) }}" class="text-primary hover:underline">{{ $line['reference'] }}</a>
                        @else
                            {{ $line['reference'] }}
                        @endif
                    </td>
                    <td class="px-3 py-2">{{ $line['description'] }}</td>
                    <td class="px-3 py-2 text-right">{{ $line['debit'] ? money($line['debit'], false) : '' }}</td>
                    <td class="px-3 py-2 text-right text-green-700">{{ $line['credit'] ? money($line['credit'], false) : '' }}</td>
                    <td class="px-3 py-2 text-right font-medium">{{ money($line['balance'], false) }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-3 py-6 text-center text-slate-400">No transactions yet.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="bg-slate-50 font-semibold">
                <td colspan="3" class="px-3 py-2">Totals</td>
                <td class="px-3 py-2 text-right">{{ money($lines->sum('debit'), false) }}</td>
                <td class="px-3 py-2 text-right">{{ money($lines->sum('credit'), false) }}</td>
                <td class="px-3 py-2 text-right">{{ money($lines->last()['balance'] ?? 0) }}</td>
            </tr>
        </tfoot>
    </table>
</div>
