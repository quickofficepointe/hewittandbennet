@extends('layouts.portal')
@section('pageTitle', 'Online Applications')

@section('content')
<x-portal.card :padding="false" subtitle="Applications submitted from the website. Admit an applicant to create their student record.">
    <x-slot:actions>
        <form method="GET" class="flex flex-wrap gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="Name, email or phone" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm">
            <select name="status" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white" onchange="this.form.submit()">
                <option value="">All</option>
                @foreach ($statuses as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>@endforeach
            </select>
            <x-portal.button size="sm" variant="secondary" icon="fa-magnifying-glass">Search</x-portal.button>
        </form>
    </x-slot:actions>

    <x-portal.table :headers="['Applicant', 'Course', 'Campus', 'Start', 'Mode', 'Received', 'Status', '']">
        @forelse ($applications as $application)
            <tr class="hover:bg-slate-50 align-top">
                <td class="px-4 py-3">
                    <div class="font-medium">{{ $application->name }}</div>
                    <div class="text-xs text-slate-500">{{ $application->email }} &middot; {{ $application->phoneNumber }}</div>
                    <div class="text-xs text-slate-500">{{ $application->location }}</div>
                </td>
                <td class="px-4 py-3">{{ $application->course?->name }}</td>
                <td class="px-4 py-3">{{ $application->campus?->name }}</td>
                <td class="px-4 py-3 whitespace-nowrap">{{ $application->startMonth }} {{ $application->startYear }}</td>
                <td class="px-4 py-3">{{ $application->modeOfLearning }}</td>
                <td class="px-4 py-3 whitespace-nowrap">{{ $application->created_at->format('d M Y') }}</td>
                <td class="px-4 py-3"><x-portal.badge :status="$application->status ?? 'pending'" /></td>
                <td class="px-4 py-3 text-right whitespace-nowrap">
                    @if ($application->student)
                        <a href="{{ route('portal.admin.students.show', $application->student) }}" class="text-xs text-primary hover:underline">{{ $application->student->admission_no }}</a>
                    @else
                        <x-portal.button size="sm" variant="success" icon="fa-user-check" :href="route('portal.admin.students.create', ['application' => $application->id])">Admit</x-portal.button>
                        <form method="POST" action="{{ route('portal.admin.applications.update', $application) }}" class="inline-flex gap-1 mt-1">
                            @csrf @method('PATCH')
                            <select name="status" class="rounded border border-slate-300 px-2 py-1 text-xs bg-white" onchange="this.form.submit()">
                                @foreach (['pending', 'contacted', 'rejected'] as $status)
                                    <option value="{{ $status }}" @selected(($application->status ?? 'pending') === $status)>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="8"><x-portal.empty icon="fa-inbox" message="No applications found." /></td></tr>
        @endforelse
    </x-portal.table>
    <div class="p-4">{{ $applications->links() }}</div>
</x-portal.card>
@endsection
