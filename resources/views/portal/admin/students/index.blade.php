@extends('layouts.portal')
@section('pageTitle', 'Students')

@section('content')
<x-portal.card :padding="false">
    <x-slot:actions>
        <form method="GET" class="flex flex-wrap gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="Name, admission no., phone, ID" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm">
            <select name="course_id" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
                <option value="">All courses</option>
                @foreach ($courses as $id => $name)<option value="{{ $id }}" @selected(request('course_id') == $id)>{{ $name }}</option>@endforeach
            </select>
            <select name="intake_id" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
                <option value="">All intakes</option>
                @foreach ($intakes as $id => $name)<option value="{{ $id }}" @selected(request('intake_id') == $id)>{{ $name }}</option>@endforeach
            </select>
            <select name="status" class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm bg-white">
                <option value="">Any status</option>
                @foreach (\App\Models\Student::STATUSES as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>@endforeach
            </select>
            <x-portal.button size="sm" variant="secondary" icon="fa-filter">Filter</x-portal.button>
        </form>
        <x-portal.button size="sm" icon="fa-user-plus" :href="route('portal.admin.students.create')">Admit student</x-portal.button>
    </x-slot:actions>

    <x-portal.table :headers="['Admission No.', 'Name', 'Course', 'Intake', 'Term', 'Phone', 'Portal', 'Status']">
        @forelse ($students as $student)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-mono text-xs"><a class="text-primary hover:underline" href="{{ route('portal.admin.students.show', $student) }}">{{ $student->admission_no }}</a></td>
                <td class="px-4 py-3 font-medium"><a href="{{ route('portal.admin.students.show', $student) }}">{{ $student->full_name }}</a></td>
                <td class="px-4 py-3">{{ $student->course?->name }}</td>
                <td class="px-4 py-3">{{ $student->intake?->name ?? '-' }}</td>
                <td class="px-4 py-3">{{ $student->current_term }}</td>
                <td class="px-4 py-3 whitespace-nowrap">{{ $student->phone }}</td>
                <td class="px-4 py-3">{!! $student->user_id ? '<i class="fa-solid fa-circle-check text-green-600" title="Has portal account"></i>' : '<i class="fa-regular fa-circle text-slate-300" title="No portal account"></i>' !!}</td>
                <td class="px-4 py-3"><x-portal.badge :status="$student->status" /></td>
            </tr>
        @empty
            <tr><td colspan="8"><x-portal.empty icon="fa-user-graduate" message="No students match your filters." /></td></tr>
        @endforelse
    </x-portal.table>
    <div class="p-4">{{ $students->links() }}</div>
</x-portal.card>
@endsection
