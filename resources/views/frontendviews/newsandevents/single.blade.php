@extends('layouts.welcomelayout')

@section('meta-title', $event->title . ' - Hewitt And Bennet International College')
@section('meta-description', Str::limit(strip_tags($event->content), 160))
@section('meta-keywords', 'News, Events, Hewitt And Bennet, ' . $event->title)
@section('meta-author', $event->user->name ?? 'Hewitt And Bennet International College')
@section('meta-url', route('newsandevent.show', $event->slug))
@section('meta-image', asset('storage/' . ($event->cover_image ?? 'assets/img/default-image.jpg')))
@section('meta-date', $event->created_at->toIso8601String())

@section('og:type', 'article')
@section('og:title', $event->title . ' - Hewitt And Bennet International College')
@section('og:description', Str::limit(strip_tags($event->content), 160))
@section('og:image', asset('storage/' . ($event->cover_image ?? 'assets/img/default-image.jpg')))
@section('og:url', route('newsandevent.show', $event->slug))
@section('og:site_name', 'Hewitt And Bennet International College')
@section('og:published_time', $event->created_at->toIso8601String())

@section('twitter:card', 'summary_large_image')
@section('twitter:title', $event->title . ' - Hewitt And Bennet International College')
@section('twitter:description', Str::limit(strip_tags($event->content), 160))
@section('twitter:image', asset('storage/' . ($event->cover_image ?? 'assets/img/default-image.jpg')))
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<section class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Breadcrumb Navigation -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('newsandevent.index') }}" class="hover:text-primary transition-colors">News & Events</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-primary font-medium">{{ Str::limit($event->title, 30) }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content Area -->
            <div class="lg:col-span-3">
                <article class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <!-- Article Header -->
                    <div class="p-8 border-b border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-4 py-1 bg-primary text-white text-sm font-semibold rounded-full">
                                {{ $event->type ?? 'News' }}
                            </span>
                            <span class="text-sm text-gray-500">
                                <i class="far fa-clock mr-1"></i>
                                {{ $event->created_at->format('F j, Y') }}
                            </span>
                        </div>

                        <h1 class="text-3xl md:text-4xl font-bold text-primary mb-4 leading-tight">
                            {{ $event->title }}
                        </h1>

                        <div class="flex items-center text-gray-600">
                            <div class="flex items-center mr-6">
                                <i class="far fa-user mr-2"></i>
                                <span>By {{ $event->user->name ?? 'Admin' }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="far fa-eye mr-2"></i>
                                <span>{{ rand(150, 500) }} Views</span>
                            </div>
                        </div>
                    </div>

                    <!-- Cover Image -->
                    <div class="relative">
                        @if ($event->cover_image)
                            <img src="{{ asset('storage/' . $event->cover_image) }}"
                                 class="w-full h-96 object-cover"
                                 alt="{{ $event->title }}">
                        @else
                            <div class="w-full h-96 bg-gradient-to-r from-primary to-secondary flex items-center justify-center">
                                <span class="text-white text-5xl font-bold">HB</span>
                            </div>
                        @endif
                    </div>

                    <!-- Article Content -->
                    <div class="p-8 prose max-w-none">
                        <div class="text-gray-700 text-lg leading-relaxed">
                            {!! $event->content !!}
                        </div>

                        <!-- Tags -->
                        @if($event->tags)
                        <div class="mt-10 pt-6 border-t border-gray-100">
                            <h3 class="text-lg font-semibold text-primary mb-3">Tags:</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $event->tags) as $tag)
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                    {{ trim($tag) }}
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Social Sharing -->
                        <div class="mt-10 pt-6 border-t border-gray-100">
                            <h3 class="text-lg font-semibold text-primary mb-4">Share this article:</h3>
                            <div class="flex flex-wrap gap-3">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('newsandevent.show', $event->slug) }}"
                                   target="_blank"
                                   class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="fab fa-facebook-f mr-2"></i> Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ route('newsandevent.show', $event->slug) }}&text={{ urlencode($event->title) }}"
                                   target="_blank"
                                   class="flex items-center px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-colors">
                                    <i class="fab fa-twitter mr-2"></i> Twitter
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('newsandevent.show', $event->slug) }}"
                                   target="_blank"
                                   class="flex items-center px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition-colors">
                                    <i class="fab fa-linkedin-in mr-2"></i> LinkedIn
                                </a>
                                <a href="https://wa.me/?text={{ urlencode(route('newsandevent.show', $event->slug) . ' ' . $event->title) }}"
                                   target="_blank"
                                   class="flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                    <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Navigation Between Articles -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($previous)
                    <a href="{{ route('newsandevent.show', $previous->slug) }}"
                       class="flex items-center p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow">
                        <div class="mr-4 text-primary">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Previous Article</span>
                            <h3 class="font-semibold text-primary">{{ Str::limit($previous->title, 40) }}</h3>
                        </div>
                    </a>
                    @endif

                    @if($next)
                    <a href="{{ route('newsandevent.show', $next->slug) }}"
                       class="flex items-center p-4 bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow md:text-right md:flex-row-reverse">
                        <div class="md:mr-4 md:ml-0 ml-4 text-primary">
                            <i class="fas fa-arrow-right text-xl"></i>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Next Article</span>
                            <h3 class="font-semibold text-primary">{{ Str::limit($next->title, 40) }}</h3>
                        </div>
                    </a>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Latest News -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-primary mb-6 pb-3 border-b border-gray-100">Latest News</h3>
                    <ul class="space-y-5">
                        @foreach ($latestNews as $latestEvent)
                        <li class="pb-4 border-b border-gray-100 last:border-b-0 last:pb-0">
                            <a href="{{ route('newsandevent.show', $latestEvent->slug) }}"
                               class="block group">
                                <h4 class="font-semibold text-primary group-hover:text-secondary transition-colors mb-1">
                                    {{ Str::limit($latestEvent->title, 50) }}
                                </h4>
                                <p class="text-sm text-gray-500 flex items-center">
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $latestEvent->created_at->format('M j, Y') }}
                                </p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <a href="{{ route('newsandevent.index') }}"
                           class="text-primary font-semibold hover:text-secondary transition-colors flex items-center">
                            View All News
                            <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-primary mb-6 pb-3 border-b border-gray-100">Categories</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('newsandevent.index', ['category' => 'news']) }}"
                               class="flex justify-between items-center py-2 text-gray-700 hover:text-primary transition-colors">
                                <span>News</span>
                                <span class="bg-primary text-white text-xs px-2 py-1 rounded-full">14</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('newsandevent.index', ['category' => 'events']) }}"
                               class="flex justify-between items-center py-2 text-gray-700 hover:text-primary transition-colors">
                                <span>Events</span>
                                <span class="bg-primary text-white text-xs px-2 py-1 rounded-full">8</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('newsandevent.index', ['category' => 'announcements']) }}"
                               class="flex justify-between items-center py-2 text-gray-700 hover:text-primary transition-colors">
                                <span>Announcements</span>
                                <span class="bg-primary text-white text-xs px-2 py-1 rounded-full">5</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Newsletter Subscription -->
                <div class="bg-gradient-to-r from-primary to-secondary rounded-xl shadow-lg p-6 text-white">
                    <h3 class="text-xl font-bold mb-3">Stay Updated</h3>
                    <p class="text-blue-100 mb-4">Subscribe to our newsletter for the latest news and updates.</p>
                    <form class="space-y-3">
                        <input type="email" placeholder="Your email address"
                               class="w-full px-4 py-3 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-white">
                        <button type="submit"
                                class="w-full bg-white text-primary font-semibold py-3 rounded-lg hover:bg-gray-100 transition-colors">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .prose {
        line-height: 1.8;
    }
    .prose p {
        margin-bottom: 1.5rem;
    }
    .prose h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1E3A8A;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .prose h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1E3A8A;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    .prose ul, .prose ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    .prose li {
        margin-bottom: 0.5rem;
    }
</style>
@endsection
