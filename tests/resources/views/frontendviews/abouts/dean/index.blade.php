@extends('layouts.welcomelayout')

@section('title', 'Dean\'s Message - Hewitt and Bennet International College')
@section('meta-description', 'Read the inspiring message from the Dean of Hewitt and Bennet International College. Discover how we help students achieve their dreams through quality education and support.')
@section('meta-keywords', 'Dean\'s Message, Hewitt and Bennet, Education, Success, College')
@section('meta-author', 'Hewitt and Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/deanimg.jpeg')) <!-- Replace with a relevant image -->
@section('meta-date', now()->toIso8601String())

<!-- Open Graph Tags for Social Sharing -->
@section('og:type', 'website')
@section('og:title', 'Dean\'s Message - Hewitt and Bennet International College')
@section('og:description', 'Read the inspiring message from the Dean of Hewitt and Bennet International College. Discover how we help students achieve their dreams through quality education and support.')
@section('og:image', asset('assets/img/deanimg.jpeg')) <!-- Replace with a relevant image -->
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt and Bennet International College')
@section('og:published_time', now()->toIso8601String())

<!-- Twitter Card Tags -->
@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Dean\'s Message - Hewitt and Bennet International College')
@section('twitter:description', 'Read the inspiring message from the Dean of Hewitt and Bennet International College. Discover how we help students achieve their dreams through quality education and support.')
@section('twitter:image', asset('assets/img/deanimg.jpeg')) <!-- Replace with a relevant image -->
@section('twitter:site', '@HewittBennetIntl')

@section('content')

<div class="container mx-auto mt-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Dean's Image Section -->
        <div class="flex flex-col items-center bg-gray-100 p-6 rounded-lg shadow-lg">
            <img src="{{ asset('assets/img/deanimg.jpeg') }}" alt="Dean" class="w-full h-auto rounded-lg mb-4">
            <p class="font-semibold text-xl text-center">Dean</p>
        </div>

        <!-- Dean's Message Section -->
        <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold text-center mb-6">Dean's Message</h2>
            <div class="text-lg text-gray-700 space-y-4">
                <p class="italic text-blue-600"><i class="fas fa-quote-left"></i></p>
                <p class="text-justify">
                    Welcome to Hewitt and Bennet International College. Come and discuss your dream with us. At Hewitt and Bennet International College, we don’t wait for success to happen — we make it happen!
                </p>
                <p class="text-justify">
                    We are committed to making your dreams valid. It has worked for our alumni, and it can work for you too. Enroll today and let our friendly, supportive staff welcome you officially.
                </p>
                <p class="italic text-blue-600"><i class="fas fa-quote-right"></i></p>
            </div>
        </div>
    </div>
</div>

@endsection
