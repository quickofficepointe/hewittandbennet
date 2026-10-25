@extends('layouts.portal')
@section('pageTitle', 'Job Applications')

@section('content')
<x-portal.card :padding="false">
    <x-slot:actions>
        <form method="GET" class="flex flex-wrap gap-2">
            <select name="vacancy_id" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
                <option value="">All vacancies</option>
                @foreach ($vacancies as $id => $title)<option value="{{ $id }}" @selected(request('vacancy_id') == $id)>{{ $title }}</option>@endforeach
            </select>
            <select name="status" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
                <option value="">Any status</option>
                @foreach (\App\Models\JobApplication::STATUSES as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>@endforeach
            </select>
            <x-portal.button size="sm" variant="secondary" icon="fa-filter">Filter</x-portal.button>
        </form>
    </x-slot:actions>
    <x-portal.table :headers="['Applicant', 'Position', 'Received', 'Cover letter', 'CV', 'Status']">
        @forelse ($applications as $application)
            <tr class="align-top">
                <td class="px-4 py-3"><div class="font-medium">{{ $application->name }}</div><div class="text-xs text-slate-500">{{ $application->email }} &middot; {{ $application->phone }}</div></td>
                <td class="px-4 py-3">{{ $application->vacancy?->title ?? $application->position ?? 'General application' }}</td>
                <td class="px-4 py-3 whitespace-nowrap">{{ $application->created_at->format('d M Y') }}</td>
                <td class="px-4 py-3 max-w-xs text-slate-600 text-xs">{{ \Illuminate\Support\Str::limit($application->cover_letter, 160) ?: '-' }}</td>
                <td class="px-4 py-3"><a href="{{ route('portal.hr.applications.cv', $application) }}" class="text-xs text-primary hover:underline"><i class="fa-solid fa-download"></i> Download</a></td>
                <td class="px-4 py-3">
                    <form method="POST" action="{{ route('portal.hr.applications.update', $application) }}">
                        @csrf @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="rounded border border-slate-300 px-2 py-1 text-xs bg-white">
                            @foreach (\App\Models\JobApplication::STATUSES as $status)<option value="{{ $status }}" @selected($application->status === $status)>{{ ucfirst($status) }}</option>@endforeach
                        </select>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6"><x-portal.empty icon="fa-file-import" message="No applications found." /></td></tr>
        @endforelse
    </x-portal.table>
    <div class="p-4">{{ $applications->links() }}</div>
</x-portal.card>
@endsection
