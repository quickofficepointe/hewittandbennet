@extends('layouts.welcomelayout')

@section('meta-title', 'Confirm Password - Hewitt Bennet International College')
@section('meta-description', 'Confirm your password to access secure student resources at Hewitt Bennet International College.')
@section('meta-keywords', 'Confirm Password, Security, Student Portal, Hewitt Bennet, College, Education')
@section('meta-author', 'Hewitt Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/hbiclogo.jpeg'))
@section('meta-date', now()->toIso8601String())

@section('og:type', 'website')
@section('og:title', 'Confirm Password - Hewitt Bennet International College')
@section('og:description', 'Confirm your password to access secure student resources at Hewitt Bennet International College.')
@section('og:image', asset('assets/img/hbiclogo.jpeg'))
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt Bennet International College')
@section('og:published_time', now()->toIso8601String())

@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Confirm Password - Hewitt Bennet International College')
@section('twitter:description', 'Confirm your password to access secure student resources at Hewitt Bennet International College.')
@section('twitter:image', asset('assets/img/hbiclogo.jpeg'))
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white rounded-xl shadow-lg p-8">
        <!-- Header Section -->
        <div class="text-center">
            <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="Hewitt Bennet International College Logo" class="mx-auto h-24 w-auto">
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Confirm Your Password
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                For your security, please confirm your password to continue.
            </p>
        </div>

        <!-- Password Confirmation Form -->
        <form class="mt-8 space-y-6" method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="space-y-4">
                <!-- Password Field -->
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm pr-10"
                           placeholder="Enter your password">
                    <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-3 flex items-center mt-6 text-gray-400 hover:text-gray-600">
                        <i class="far fa-eye"></i>
                    </button>

                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button and Forgot Password Link -->
            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    Confirm Password
                </button>
            </div>

            @if (Route::has('password.request'))
                <div class="text-center mt-4">
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                        Forgot Your Password?
                    </a>
                </div>
            @endif
        </form>

        <!-- Security Notice -->
        <div class="mt-6 p-3 bg-blue-50 rounded-lg border border-blue-100">
            <p class="text-xs text-blue-700 text-center">
                <i class="fas fa-shield-alt mr-1"></i>
                We take your account security seriously. Your information is protected.
            </p>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    document.getElementById('toggle-password').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const icon = this.querySelector('i');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
@endsection
