@extends('layouts.welcomelayout')

@section('meta-title', 'Latest News & Events - Hewitt And Bennet International College')
@section('meta-description', 'Stay updated with the latest news, events, and updates from Hewitt And Bennet International College, including announcements, course information, and student achievements.')
@section('meta-keywords', 'News, Events, Hewitt And Bennet International College, Announcements, Updates, Education')
@section('meta-author', 'Hewitt And Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/hewittlogo.jpeg'))

@section('og:type', 'website')
@section('og:title', 'Latest News & Events - Hewitt And Bennet International College')
@section('og:description', 'Get the latest updates and events from Hewitt And Bennet International College. Explore announcements, course details, and more.')
@section('og:image', asset('assets/img/hewittlogo.jpeg'))
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt And Bennet International College')

@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Latest News & Events - Hewitt And Bennet International College')
@section('twitter:description', 'Explore recent news and events at Hewitt And Bennet International College. Stay informed on updates and announcements.')
@section('twitter:image', asset('assets/img/hewittlogo.jpeg'))
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<section class="py-16 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h5 class="text-lg font-semibold text-primary uppercase tracking-wider">Latest Updates</h5>
            <h1 class="text-4xl md:text-5xl font-bold text-primary mt-2 mb-4">News & Events</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Stay informed about the latest happenings, announcements, and events at Hewitt And Bennet International College.</p>
        </div>

        <!-- Filter Options -->
        <div class="flex flex-wrap justify-center gap-3 mb-10">
            <button class="filter-btn active px-4 py-2 rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition-colors" data-filter="all">
                All Updates
            </button>
            <button class="filter-btn px-4 py-2 rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition-colors" data-filter="news">
                News
            </button>
            <button class="filter-btn px-4 py-2 rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition-colors" data-filter="events">
                Events
            </button>
            <button class="filter-btn px-4 py-2 rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition-colors" data-filter="announcements">
                Announcements
            </button>
        </div>

        <!-- News & Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($newsEvents as $event)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <!-- Image -->
                <div class="relative overflow-hidden">
                    @if($event->cover_image)
                        <img src="{{ asset('storage/' . $event->cover_image) }}"
                             class="w-full h-48 object-cover transition-transform duration-500 hover:scale-105"
                             alt="{{ $event->title }}">
                    @else
                        <div class="w-full h-48 bg-gradient-to-r from-primary to-secondary flex items-center justify-center">
                            <span class="text-white text-4xl font-bold">HB</span>
                        </div>
                    @endif

                    <!-- Category Badge -->
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-primary text-white text-xs font-semibold rounded-full">
                            {{ $event->type ?? 'News' }}
                        </span>
                    </div>

                    <!-- Date -->
                    <div class="absolute top-4 right-4 bg-white text-primary text-xs font-semibold px-2 py-1 rounded-md shadow-sm">
                        {{ $event->created_at->format('M d, Y') }}
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-primary mb-3 leading-tight">{{ $event->title }}</h3>

                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>By {{ $event->user->name }}</span>
                    </div>

                    <p class="text-gray-600 mb-5 line-clamp-3">
                        {!! Str::limit(strip_tags($event->content), 120) !!}
                    </p>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('newsandevent.show', $event->slug) }}"
                           class="inline-flex items-center text-primary font-semibold hover:text-secondary transition-colors">
                            Read More
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>

                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <span>{{ rand(50, 300) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if(count($newsEvents) === 0)
        <div class="text-center py-16">
            <div class="inline-flex items-center justify-center rounded-full bg-blue-100 p-6 mb-6">
                <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-semibold text-gray-700 mb-3">No News & Events Yet</h3>
            <p class="text-gray-500 max-w-md mx-auto">Check back later for the latest updates, announcements, and events from Hewitt And Bennet International College.</p>
        </div>
        @endif

        <!-- Pagination -->
        @if($newsEvents->hasPages())
        <div class="flex justify-center mt-12">
            <div class="flex items-center space-x-2">
                @if($newsEvents->onFirstPage())
                <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                    Previous
                </span>
                @else
                <a href="{{ $newsEvents->previousPageUrl() }}" class="px-4 py-2 text-primary bg-white border border-primary rounded-lg hover:bg-primary hover:text-white transition-colors">
                    Previous
                </a>
                @endif

                @foreach(range(1, $newsEvents->lastPage()) as $page)
                    @if($page == $newsEvents->currentPage())
                    <span class="px-4 py-2 text-white bg-primary rounded-lg">{{ $page }}</span>
                    @else
                    <a href="{{ $newsEvents->url($page) }}" class="px-4 py-2 text-primary bg-white border border-primary rounded-lg hover:bg-primary hover:text-white transition-colors">{{ $page }}</a>
                    @endif
                @endforeach

                @if($newsEvents->hasMorePages())
                <a href="{{ $newsEvents->nextPageUrl() }}" class="px-4 py-2 text-primary bg-white border border-primary rounded-lg hover:bg-primary hover:text-white transition-colors">
                    Next
                </a>
                @else
                <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                    Next
                </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const newsItems = document.querySelectorAll('.bg-white.rounded-xl');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Update active state
                filterButtons.forEach(btn => btn.classList.remove('active', 'bg-primary', 'text-white'));
                button.classList.add('active', 'bg-primary', 'text-white');

                // Filter items (this would need server-side implementation for real filtering)
                // For now, this is just a UI demonstration
                const filterValue = button.getAttribute('data-filter');

                // In a real implementation, you would fetch filtered content from the server
                console.log('Filtering by:', filterValue);
            });
        });
    });
</script>

<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .filter-btn.active {
        background-color: #1E3A8A;
        color: white;
    }
</style>
@endsection
