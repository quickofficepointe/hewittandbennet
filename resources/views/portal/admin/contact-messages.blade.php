@extends('layouts.portal')
@section('pageTitle', 'Contact Messages')

@section('content')
<x-portal.card :padding="false" subtitle="Enquiries sent through the website contact form.">
    <x-portal.table :headers="['From', 'Subject', 'Message', 'Received', '']">
        @forelse ($messages as $message)
            <tr class="hover:bg-slate-50 align-top {{ $message->read_at ? 'text-slate-500' : '' }}">
                <td class="px-4 py-3">
                    <div class="font-medium {{ $message->read_at ? '' : 'text-slate-900' }}">{{ $message->name }}</div>
                    <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: '.$message->subject) }}" class="text-xs text-primary hover:underline">{{ $message->email }}</a>
                    @if ($message->phone)<div class="text-xs">{{ $message->phone }}</div>@endif
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                    {{ $message->subject }}
                    @unless ($message->read_at)<span class="ml-1 text-[10px] font-semibold uppercase bg-red-100 text-red-700 rounded px-1.5 py-0.5">New</span>@endunless
                </td>
                <td class="px-4 py-3 max-w-md whitespace-pre-line">{{ $message->message }}</td>
                <td class="px-4 py-3 whitespace-nowrap">{{ $message->created_at->format('d M Y, H:i') }}</td>
                <td class="px-4 py-3 text-right whitespace-nowrap">
                    <form method="POST" action="{{ route('portal.admin.contact-messages.read', $message) }}" class="inline">
                        @csrf @method('PATCH')
                        <button class="text-xs text-primary hover:underline">{{ $message->read_at ? 'Mark new' : 'Mark handled' }}</button>
                    </form>
                    <form method="POST" action="{{ route('portal.admin.contact-messages.destroy', $message) }}" class="inline ml-2" onsubmit="return confirm('Delete this message?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5"><x-portal.empty icon="fa-envelope-open" message="No messages yet." /></td></tr>
        @endforelse
    </x-portal.table>
    <div class="p-4">{{ $messages->links() }}</div>
</x-portal.card>
@endsection
