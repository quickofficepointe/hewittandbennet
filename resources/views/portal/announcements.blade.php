@extends('layouts.portal')
@section('pageTitle', 'Announcements')

@section('content')
<div class="grid gap-6 {{ $canManage ? 'lg:grid-cols-3' : '' }}">
    @if ($canManage)
        <x-portal.card title="New announcement" class="lg:order-2 h-fit">
            <form method="POST" action="{{ route('portal.announcements.store') }}" class="space-y-4">
                @csrf
                <x-portal.input name="title" label="Title" required />
                <x-portal.textarea name="body" label="Message" rows="6" required />
                <x-portal.select name="audience" label="Audience" :options="\App\Models\Announcement::AUDIENCES" />
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_pinned" value="1" class="rounded"> Pin to top</label>
                <x-portal.button icon="fa-bullhorn">Publish</x-portal.button>
            </form>
        </x-portal.card>
    @endif

    <div class="{{ $canManage ? 'lg:col-span-2 lg:order-1' : '' }} space-y-4">
        @forelse ($announcements as $announcement)
            <x-portal.card>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="font-semibold text-slate-800">
                            @if ($announcement->is_pinned)<i class="fa-solid fa-thumbtack text-secondary mr-1"></i>@endif
                            {{ $announcement->title }}
                        </h3>
                        <div class="text-xs text-slate-500 mt-1">
                            {{ $announcement->created_at->format('d M Y, H:i') }} &middot; {{ $announcement->author?->name ?? 'College' }}
                            @if ($canManage) &middot; <x-portal.badge color="blue">{{ \App\Models\Announcement::AUDIENCES[$announcement->audience] }}</x-portal.badge>@endif
                        </div>
                    </div>
                    @if ($canManage)
                        <form method="POST" action="{{ route('portal.announcements.destroy', $announcement) }}" onsubmit="return confirm('Delete this announcement?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700" title="Delete"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    @endif
                </div>
                <div class="mt-3 text-sm text-slate-700 whitespace-pre-line">{{ $announcement->body }}</div>
            </x-portal.card>
        @empty
            <x-portal.card><x-portal.empty icon="fa-bullhorn" message="No announcements yet." /></x-portal.card>
        @endforelse
        {{ $announcements->links() }}
    </div>
</div>
@endsection
