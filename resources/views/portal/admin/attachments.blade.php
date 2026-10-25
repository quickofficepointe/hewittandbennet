@extends('layouts.portal')
@section('pageTitle', 'Attachment Requests')

@section('content')
<x-portal.card :padding="false" subtitle="Industrial attachment requests submitted through the website.">
    <x-portal.table :headers="['Name', 'Institution', 'Course', 'Department', 'Email', 'Received', '']">
        @forelse ($attachments as $attachment)
            <tr class="hover:bg-slate-50">
                <td class="px-4 py-3 font-medium">{{ $attachment->name }}</td>
                <td class="px-4 py-3">{{ $attachment->institution }}</td>
                <td class="px-4 py-3">{{ $attachment->course }}</td>
                <td class="px-4 py-3">{{ $attachment->department }}</td>
                <td class="px-4 py-3"><a href="mailto:{{ $attachment->email }}" class="text-primary hover:underline">{{ $attachment->email }}</a></td>
                <td class="px-4 py-3 whitespace-nowrap">{{ $attachment->created_at?->format('d M Y') }}</td>
                <td class="px-4 py-3 text-right"><a class="text-xs text-primary hover:underline" href="{{ route('portal.admin.attachments.document', $attachment) }}"><i class="fa-solid fa-download"></i> Documents</a></td>
            </tr>
        @empty
            <tr><td colspan="7"><x-portal.empty icon="fa-paperclip" message="No attachment requests yet." /></td></tr>
        @endforelse
    </x-portal.table>
    <div class="p-4">{{ $attachments->links() }}</div>
</x-portal.card>
@endsection
