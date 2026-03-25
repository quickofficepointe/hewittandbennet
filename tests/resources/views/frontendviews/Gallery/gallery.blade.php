@extends('layouts.welcomelayout')

@section('meta-title', 'Gallery - Hewitt Bennet International College')
@section('meta-description', 'Explore our stunning gallery showcasing images, videos, and more from our events and adventures at Hewitt Bennet International College.')
@section('meta-keywords', 'Gallery, Images, Videos, Events, Hewitt Bennet, Adventure, College')
@section('meta-author', 'Hewitt Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/gallery-cover.jpg')) <!-- Replace with a relevant image -->
@section('meta-date', now()->toIso8601String())

<!-- Open Graph Tags for Social Sharing -->
@section('og:type', 'website')
@section('og:title', 'Gallery - Hewitt Bennet International College')
@section('og:description', 'Explore our stunning gallery showcasing images, videos, and more from our events and adventures at Hewitt Bennet International College.')
@section('og:image', asset('assets/img/gallery-cover.jpg')) <!-- Replace with a relevant image -->
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt Bennet International College')
@section('og:published_time', now()->toIso8601String())

<!-- Twitter Card Tags -->
@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Gallery - Hewitt Bennet International College')
@section('twitter:description', 'Explore our stunning gallery showcasing images, videos, and more from our events and adventures at Hewitt Bennet International College.')
@section('twitter:image', asset('assets/img/gallery-cover.jpg')) <!-- Replace with a relevant image -->
@section('twitter:site', '@HewittBennetIntl')

@section('content')

<!-- Gallery Start -->
<div class="container-fluid gallery py-5">
    <div class="text-center mb-5">
        <h5 class="section-title">Our Gallery</h5>
        <h1 class="mb-4">Gallery</h1>
        <p>Explore our collection of images, videos, and more.</p>
    </div>

    <div class="row g-2">
        @foreach ($galleryItems as $media)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="gallery-item position-relative">
                    @if($media->file_type === 'video')
                        <!-- Video -->
                        <video src="{{ Storage::url($media->file_path) }}" class="img-fluid rounded gallery-media" controls></video>
                    @elseif($media->file_type === 'youtube')
                        <!-- YouTube Embed -->
                        <iframe src="https://www.youtube.com/embed/{{ $media->youtube_url }}" class="img-fluid rounded gallery-media" frameborder="0"></iframe>
                    @elseif($media->file_type === 'tiktok')
                        <!-- TikTok Embed -->
                        <blockquote class="tiktok-embed img-fluid rounded gallery-media" cite="{{ $media->tiktok_url }}" data-video-id="{{ $media->tiktok_url }}">
                            <a href="{{ $media->tiktok_url }}" target="_blank">View on TikTok</a>
                        </blockquote>
                    @else
                        <!-- Image -->
                        <img src="{{ Storage::url($media->file_path) }}" class="img-fluid rounded gallery-media" alt="{{ $media->title }}"/>
                    @endif

                    <!-- Overlay with title and description -->
                    <div class="gallery-overlay position-absolute w-100 h-100 d-flex align-items-center justify-content-center">
                        <div class="text-center text-white">
                            <h5>{{ $media->title }}</h5>
                            <p>{{ $media->description }}</p>
                            <a href="{{ Storage::url($media->file_path) }}" class="btn btn-outline-light btn-sm" data-lightbox="gallery">
                                <i class="fas fa-expand"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- End Gallery -->

@endsection

<!-- TikTok Embed Script -->
<script async src="https://www.tiktok.com/embed.js"></script>
