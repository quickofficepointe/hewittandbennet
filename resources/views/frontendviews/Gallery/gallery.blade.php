@extends('layouts.welcomelayout')

@section('meta-title', 'Gallery - Hewitt Bennet International College')
@section('meta-description', 'Explore our stunning gallery showcasing images, videos, and more from our events and adventures at Hewitt Bennet International College.')
@section('meta-keywords', 'Gallery, Images, Videos, Events, Hewitt Bennet, Adventure, College')
@section('meta-author', 'Hewitt Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/gallery-cover.jpg'))
@section('meta-date', now()->toIso8601String())

@section('og:type', 'website')
@section('og:title', 'Gallery - Hewitt Bennet International College')
@section('og:description', 'Explore our stunning gallery showcasing images, videos, and more from our events and adventures at Hewitt Bennet International College.')
@section('og:image', asset('assets/img/gallery-cover.jpg'))
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt Bennet International College')
@section('og:published_time', now()->toIso8601String())

@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Gallery - Hewitt Bennet International College')
@section('twitter:description', 'Explore our stunning gallery showcasing images, videos, and more from our events and adventures at Hewitt Bennet International College.')
@section('twitter:image', asset('assets/img/gallery-cover.jpg'))
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<!-- Gallery Section -->
<section class="py-16 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h5 class="text-lg font-semibold text-primary uppercase tracking-wider">Our Gallery</h5>
            <h1 class="text-4xl md:text-5xl font-bold text-primary mt-2 mb-4">Campus Life Gallery</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Explore our collection of images, videos, and memories from events and activities at Hewitt Bennet International College.</p>
        </div>

        <!-- Filter Buttons -->
        <div class="flex flex-wrap justify-center gap-3 mb-10">
            <button class="filter-btn active px-4 py-2 rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition-colors" data-filter="all">
                All Media
            </button>
            <button class="filter-btn px-4 py-2 rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition-colors" data-filter="image">
                Images
            </button>
            <button class="filter-btn px-4 py-2 rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition-colors" data-filter="video">
                Videos
            </button>
            <button class="filter-btn px-4 py-2 rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition-colors" data-filter="youtube">
                YouTube
            </button>
            <button class="filter-btn px-4 py-2 rounded-full border border-primary text-primary hover:bg-primary hover:text-white transition-colors" data-filter="tiktok">
                TikTok
            </button>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($galleryItems as $media)
                <div class="gallery-item" data-type="{{ $media->file_type }}">
                    <div class="relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                        @if($media->file_type === 'video')
                            <!-- Video -->
                            <video class="w-full h-64 object-cover" controls>
                                <source src="{{ Storage::url($media->file_path) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @elseif($media->file_type === 'youtube')
                            <!-- YouTube Embed -->
                            <div class="relative pb-[56.25%] h-0 overflow-hidden rounded-lg">
                                <iframe class="absolute top-0 left-0 w-full h-full"
                                    src="https://www.youtube.com/embed/{{ $media->youtube_url }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @elseif($media->file_type === 'tiktok')
                            <!-- TikTok Embed -->
                            <div class="relative pb-[125%] h-0 overflow-hidden rounded-lg">
                                <blockquote class="tiktok-embed absolute top-0 left-0 w-full h-full"
                                    cite="{{ $media->tiktok_url }}"
                                    data-video-id="{{ $media->tiktok_url }}">
                                    <section></section>
                                </blockquote>
                            </div>
                        @else
                            <!-- Image -->
                            <img src="{{ Storage::url($media->file_path) }}"
                                 class="w-full h-64 object-cover"
                                 alt="{{ $media->title }}"/>
                        @endif

                        <!-- Overlay with title and description -->
                        <div class="gallery-overlay absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                            <div class="text-white">
                                <h3 class="font-bold text-lg">{{ $media->title }}</h3>
                                <p class="text-sm">{{ Str::limit($media->description, 100) }}</p>
                                @if($media->file_type === 'image')
                                    <a href="{{ Storage::url($media->file_path) }}"
                                       class="inline-block mt-2 text-xs bg-primary bg-opacity-70 hover:bg-opacity-100 px-3 py-1 rounded-full transition-colors"
                                       data-lightbox="gallery"
                                       data-title="{{ $media->title }}">
                                        <i class="fas fa-expand mr-1"></i> View Full Size
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if(count($galleryItems) === 0)
            <div class="text-center py-12">
                <div class="inline-flex items-center justify-center rounded-full bg-blue-100 p-4 mb-4">
                    <i class="fas fa-camera text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No gallery items yet</h3>
                <p class="text-gray-500">Check back later for updates to our gallery.</p>
            </div>
        @endif
    </div>
</section>

<!-- TikTok Embed Script -->
<script async src="https://www.tiktok.com/embed.js"></script>

<!-- Lightbox2 Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

<!-- Custom Gallery Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-item');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Update active state
                filterButtons.forEach(btn => btn.classList.remove('active', 'bg-primary', 'text-white'));
                button.classList.add('active', 'bg-primary', 'text-white');

                // Filter items
                const filterValue = button.getAttribute('data-filter');

                galleryItems.forEach(item => {
                    if (filterValue === 'all' || item.getAttribute('data-type') === filterValue) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            });
        });

        // Lightbox configuration
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'showImageNumberLabel': true,
            'positionFromTop': 100,
            'fadeDuration': 300
        });
    });
</script>

<style>
    .gallery-item {
        transition: transform 0.3s ease;
    }

    .gallery-item:hover {
        transform: translateY(-5px);
    }

    .filter-btn.active {
        background-color: #1E3A8A;
        color: white;
    }
</style>
@endsection
