@extends('layouts.welcomelayout')

@section('title', 'Director\'s Message - Hewitt and Bennet International College')
@section('meta-description', 'Read the inspiring message from Patric Onyango, Director of Hewitt and Bennet International College. Discover how we help students achieve their dreams through quality education and support.')
@section('meta-keywords', 'Director\'s Message, Hewitt and Bennet, Education, Success, College, Patric Onyango')
@section('meta-author', 'Hewitt and Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/directorimg.jpeg')) <!-- Replace with a relevant image -->
@section('meta-date', now()->toIso8601String())

<!-- Open Graph Tags for Social Sharing -->
@section('og:type', 'website')
@section('og:title', 'Director\'s Message - Hewitt and Bennet International College')
@section('og:description', 'Read the inspiring message from Patric Onyango, Director of Hewitt and Bennet International College. Discover how we help students achieve their dreams through quality education and support.')
@section('og:image', asset('assets/img/directorimg.jpeg')) <!-- Replace with a relevant image -->
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt and Bennet International College')
@section('og:published_time', now()->toIso8601String())

<!-- Twitter Card Tags -->
@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Director\'s Message - Hewitt and Bennet International College')
@section('twitter:description', 'Read the inspiring message from Patric Onyango, Director of Hewitt and Bennet International College. Discover how we help students achieve their dreams through quality education and support.')
@section('twitter:image', asset('assets/img/directorimg.jpeg')) <!-- Replace with a relevant image -->
@section('twitter:site', '@HewittBennetIntl')

@section('content')

<div class="container mx-auto mt-5 px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="message-image-container flex flex-col items-center p-6 bg-gray-100 rounded-lg shadow-md">
            <img src="{{ asset('assets/img/directorimg.jpeg') }}" alt="Director Patric Onyango" class="message-image-large rounded-lg w-full h-auto">
            <p class="image-name mt-4 text-xl font-semibold text-center">Patric Onyango</p>
        </div>
        <div class="message-container p-6 bg-gray-100 rounded-lg shadow-md">
            <h2 class="text-center text-2xl font-semibold mb-4">Director's Message</h2>
            <p class="director-message text-lg text-gray-700 leading-relaxed mt-4 text-justify">
                <i class="fas fa-quote-left text-2xl text-blue-500"></i>
                <p>
                    Welcome to Hewitt and Bennet International College. Come and discuss your dream with us. At Hewitt and Bennet International College, we don’t wait for success to happen — we make it happen!
                </p>
                <p class="mt-4">
                    We are committed to making your dreams valid. It has worked for our alumni, and it can work for you too. Enroll today and let our friendly, supportive staff welcome you officially.
                </p>
                <i class="fas fa-quote-right text-2xl text-blue-500 mt-4"></i>
            </p>
        </div>
    </div>
</div>

@endsection
