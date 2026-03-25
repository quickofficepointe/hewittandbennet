@extends('layouts.welcomelayout')

@section('meta-title', 'Reset Password - Hewitt Bennet International College')
@section('meta-description', 'Reset your Hewitt Bennet International College account password to regain access to student resources.')
@section('meta-keywords', 'Reset Password, Account Recovery, Student Portal, Hewitt Bennet, College, Education')
@section('meta-author', 'Hewitt Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/hbiclogo.jpeg'))
@section('meta-date', now()->toIso8601String())

@section('og:type', 'website')
@section('og:title', 'Reset Password - Hewitt Bennet International College')
@section('og:description', 'Reset your Hewitt Bennet International College account password to regain access to student resources.')
@section('og:image', asset('assets/img/hbiclogo.jpeg'))
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt Bennet International College')
@section('og:published_time', now()->toIso8601String())

@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Reset Password - Hewitt Bennet International College')
@section('twitter:description', 'Reset your Hewitt Bennet International College account password to regain access to student resources.')
@section('twitter:image', asset('assets/img/hbiclogo.jpeg'))
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white rounded-xl shadow-lg p-8">
        <!-- Header Section -->
        <div class="text-center">
            <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="Hewitt Bennet International College Logo" class="mx-auto h-24 w-auto">
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Reset Your Password
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Enter your email address and we'll send you a password reset link.
            </p>
        </div>

        <!-- Success Message -->
        @if (session('status'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            {{ session('status') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Password Reset Form -->
        <form class="mt-8 space-y-6" method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="space-y-4">
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Enter your email address" value="{{ old('email') }}">

                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    Send Password Reset Link
                </button>
            </div>

            <!-- Back to Login Link -->
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                    Back to Login
                </a>
            </div>
        </form>

        <!-- Support Notice -->
        <div class="mt-6 p-3 bg-blue-50 rounded-lg border border-blue-100">
            <p class="text-xs text-blue-700 text-center">
                <i class="fas fa-envelope mr-1"></i>
                Check your spam folder if you don't receive the email within a few minutes.
            </p>
        </div>
    </div>
</div>
@endsection
