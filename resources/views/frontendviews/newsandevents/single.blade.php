@extends('layouts.app')

@section('meta-title', $event->title . ' - Hewitt And Bennet International College')
@section('meta-description', Str::limit(strip_tags($event->content), 160))
@section('meta-keywords', 'News, Events, Hewitt And Bennet, ' . $event->title)
@section('meta-author', $event->user->name ?? 'Hewitt And Bennet International College')
@section('meta-url', route('newsandevent.show', $event->slug))
@section('meta-image', asset('storage/' . ($event->cover_image ?? 'assets/img/default-image.jpg')))
@section('meta-date', $event->created_at->toIso8601String())

<!-- Open Graph Tags for Social Sharing -->
@section('og:type', 'article')
@section('og:title', $event->title . ' - Hewitt And Bennet International College')
@section('og:description', Str::limit(strip_tags($event->content), 160))
@section('og:image', asset('storage/' . ($event->cover_image ?? 'assets/img/default-image.jpg')))
@section('og:url', route('newsandevent.show', $event->slug))
@section('og:site_name', 'Hewitt And Bennet International College')
@section('og:published_time', $event->created_at->toIso8601String())

<!-- Twitter Card Tags -->
@section('twitter:card', 'summary_large_image')
@section('twitter:title', $event->title . ' - Hewitt And Bennet International College')
@section('twitter:description', Str::limit(strip_tags($event->content), 160))
@section('twitter:image', asset('storage/' . ($event->cover_image ?? 'assets/img/default-image.jpg')))
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content Area -->
        <div class="col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
                <h2 class="text-3xl font-semibold text-gray-800 mb-4">{{ $event->title }}</h2>

                <!-- Cover Image with Size Restriction -->
                @if ($event->cover_image)
                    <img src="{{ asset('storage/' . $event->cover_image) }}" class="w-full h-80 object-cover rounded-lg mb-6" alt="Cover Image">
                @else
                    <img src="https://via.placeholder.com/800x400" class="w-full h-80 object-cover rounded-lg mb-6" alt="Placeholder Image">
                @endif

                <div class="text-gray-700 text-lg">
                    {!! $event->content !!}
                </div>

                <!-- Social Share Buttons -->
                <div class="mt-6">
                    <h5 class="font-semibold text-gray-800 mb-3">Share this article:</h5>
                    <div class="social-share-buttons flex space-x-4">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('newsandevent.show', $event->slug) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">Share on Facebook</a>
                        <a href="https://twitter.com/intent/tweet?url={{ route('newsandevent.show', $event->slug) }}&text={{ urlencode($event->title) }}" target="_blank" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out">Share on X</a>
                        <a href="https://wa.me/?text={{ urlencode(route('newsandevent.show', $event->slug) . ' ' . $event->title) }}" target="_blank" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300 ease-in-out">Share on WhatsApp</a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('newsandevent.show', $event->slug) }}" target="_blank" class="px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition duration-300 ease-in-out">Share on LinkedIn</a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Sidebar for Latest News -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h4 class="text-xl font-semibold text-gray-800 mb-4">Latest News</h4>
            <ul class="space-y-4">
                @foreach ($latestNews as $latestEvent)
                <li class="border-b pb-4">
                    <a href="{{ route('newsandevent.show', $latestEvent->slug) }}" class="text-lg text-gray-800 hover:text-blue-600 transition duration-300 ease-in-out">
                        {{ Str::limit($latestEvent->title, 50) }}
                    </a>
                    <p class="text-sm text-gray-500">{{ $latestEvent->created_at->format('d/m/Y') }}</p>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
