@extends('layouts.welcomelayout')

@section('meta-title', 'Verify Email - Hewitt Bennet International College')
@section('meta-description', 'Verify your email address to access your Hewitt Bennet International College student account and resources.')
@section('meta-keywords', 'Verify Email, Account Verification, Student Portal, Hewitt Bennet, College, Education')
@section('meta-author', 'Hewitt Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/hbiclogo.jpeg'))
@section('meta-date', now()->toIso8601String())

@section('og:type', 'website')
@section('og:title', 'Verify Email - Hewitt Bennet International College')
@section('og:description', 'Verify your email address to access your Hewitt Bennet International College student account and resources.')
@section('og:image', asset('assets/img/hbiclogo.jpeg'))
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt Bennet International College')
@section('og:published_time', now()->toIso8601String())

@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Verify Email - Hewitt Bennet International College')
@section('twitter:description', 'Verify your email address to access your Hewitt Bennet International College student account and resources.')
@section('twitter:image', asset('assets/img/hbiclogo.jpeg'))
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white rounded-xl shadow-lg p-8">
        <!-- Header Section -->
        <div class="text-center">
            <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="Hewitt Bennet International College Logo" class="mx-auto h-24 w-auto">
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Verify Your Email Address
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Complete your registration to access student resources
            </p>
        </div>

        <!-- Success Message -->
        @if (session('resent'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            A fresh verification link has been sent to your email address.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Content Section -->
        <div class="text-gray-700 text-center">
            <div class="mb-6">
                <svg class="w-16 h-16 text-indigo-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>

            <p class="mb-4">
                Before proceeding, please check your email for a verification link.
            </p>
            <p class="mb-6">
                If you didn't receive the email, we'll be glad to send you another one.
            </p>

            <!-- Resend Form -->
            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    Resend Verification Email
                </button>
            </form>
        </div>

        <!-- Support Section -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
            <p class="text-xs text-gray-600 text-center">
                Need help? Contact our
                <a href="mailto:support@hbic.edu" class="text-indigo-600 hover:text-indigo-500 font-medium">support team</a>
                or check your spam folder.
            </p>
        </div>
    </div>
</div>
@endsection
