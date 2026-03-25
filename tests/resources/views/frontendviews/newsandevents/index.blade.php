@extends('layouts.app')

@section('meta-title', 'Latest News & Events - Hewitt And Bennet International College')
@section('meta-description', 'Stay updated with the latest news, events, and updates from Hewitt And Bennet International College, including announcements, course information, and student achievements.')
@section('meta-keywords', 'News, Events, Hewitt And Bennet International College, Announcements, Updates, Education')
@section('meta-author', 'Hewitt And Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/hewittlogo.jpeg'))

<!-- Open Graph Tags for Enhanced Social Sharing -->
@section('og:type', 'website')
@section('og:title', 'Latest News & Events - Hewitt And Bennet International College')
@section('og:description', 'Get the latest updates and events from Hewitt And Bennet International College. Explore announcements, course details, and more.')
@section('og:image', asset('assets/img/hewittlogo.jpeg'))
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt And Bennet International College')

<!-- Twitter Meta Tags -->
@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Latest News & Events - Hewitt And Bennet International College')
@section('twitter:description', 'Explore recent news and events at Hewitt And Bennet International College. Stay informed on updates and announcements.')
@section('twitter:image', asset('assets/img/hewittlogo.jpeg'))
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<div class="container mx-auto px-6 py-8">
    <h2 class="text-3xl font-semibold text-center mb-12 text-gray-800">Latest News & Events</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($newsEvents as $event)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-all hover:shadow-2xl">
                @if($event->cover_image)
                    <img src="{{ asset('storage/' . $event->cover_image) }}" class="w-full h-48 object-cover" alt="Cover Image">
                @else
                    <img src="https://via.placeholder.com/300x200" class="w-full h-48 object-cover" alt="Placeholder Image">
                @endif
                <div class="p-6">
                    <h5 class="text-xl font-semibold text-gray-800 mb-2">{{ $event->title }}</h5>
                    <p class="text-gray-600 text-sm mb-2"><strong>Author:</strong> {{ $event->user->name }}</p>
                    <p class="text-gray-500 text-xs mb-4"><small>{{ $event->created_at->format('d/m/Y') }}</small></p>
                    <p class="text-gray-700 mb-4">{!! Str::limit($event->content, 100) !!}</p>
                    <a href="{{ route('newsandevent.show', $event->slug) }}" class="inline-block px-6 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">
                        Read More
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
