@extends('layouts.welcomelayout')

@section('meta-title', 'Work Abroad as a Certified Caregiver - Hewitt Bennet International College')
@section('meta-description', 'Train to become a professional caregiver and work abroad in countries like the UK, USA, Canada, and more. Apply now at Hewitt Bennet International College.')
@section('meta-keywords', 'Caregiving, Work Abroad, Hewitt Bennet, Certified Caregiver, Nursing Care, Senior Care')
@section('meta-author', 'Hewitt Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/workabroad.jpg'))
@section('meta-date', now()->toIso8601String())

@section('og:type', 'website')
@section('og:title', 'Work Abroad as a Certified Caregiver - Hewitt Bennet International College')
@section('og:description', 'Train to become a professional caregiver and work abroad in countries like the UK, USA, Canada, and more. Apply now at Hewitt Bennet International College.')
@section('og:image', asset('assets/img/workabroad.jpg'))
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt Bennet International College')
@section('og:published_time', now()->toIso8601String())

@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Work Abroad as a Certified Caregiver - Hewitt Bennet International College')
@section('twitter:description', 'Train to become a professional caregiver and work abroad in countries like the UK, USA, Canada, and more. Apply now at Hewitt Bennet International College.')
@section('twitter:image', asset('assets/img/workabroad.jpg'))
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<div class="bg-gradient-to-r from-blue-500 via-indigo-600 to-purple-700 py-12">
    <div class="container mx-auto text-white text-center">
        <h1 class="text-4xl sm:text-5xl font-bold mb-4">WORK ABROAD</h1>
        <p class="text-lg sm:text-xl mb-4">Caregiving is one of the most in-demand careers globally. Get certified and work abroad as a professional caregiver.</p>
        <p class="mb-8">At Hewitt Bennet International College, we train caregivers who are ready to compete globally.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Country List 1 -->
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-xl font-semibold mb-4">Our students work in:</h2>
                <ul class="space-y-2 text-gray-800">
                    <li>UK</li>
                    <li>USA</li>
                    <li>Finland</li>
                    <li>Poland</li>
                    <li>Turkey</li>
                </ul>
            </div>

            <!-- Country List 2 -->
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-xl font-semibold mb-4">Our students work in:</h2>
                <ul class="space-y-2 text-gray-800">
                    <li>Canada</li>
                    <li>Qatar</li>
                    <li>Dubai</li>
                    <li>Sweden</li>
                    <li>Denmark</li>
                </ul>
            </div>

            <!-- Country List 3 -->
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-xl font-semibold mb-4">Our students work in:</h2>
                <ul class="space-y-2 text-gray-800">
                    <li>Norway</li>
                    <li>Germany</li>
                    <li>Italy</li>
                </ul>
            </div>
        </div>

        <div class="mt-12">
            <h3 class="text-2xl font-semibold text-gray-100 mb-4">Our Caregivers Specialize In:</h3>
            <ul class="list-inside list-disc text-lg text-gray-200 space-y-2">
                <li>Patient Care / Nursing Care</li>
                <li>Child Care & Protection</li>
                <li>Senior Care / Aged Care</li>
                <li>Disability Care & Support</li>
            </ul>
        </div>

        <div class="mt-8 text-lg text-gray-100">
            <p>Our training program is NITA certified and recognized by International Caregiver Associations for its quality training.</p>
        </div>

        <div class="mt-8">
            <a href="{{ route('registration.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-6 rounded-lg shadow-lg text-lg transition duration-300">Apply Now</a>
        </div>
    </div>
</div>
@endsection
