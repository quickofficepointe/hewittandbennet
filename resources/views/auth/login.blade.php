@extends('layouts.welcomelayout')

@section('meta-title', 'Login - Hewitt Bennet International College')
@section('meta-description', 'Login to your Hewitt Bennet International College account to access student resources, course materials, and academic information.')
@section('meta-keywords', 'Login, Student Portal, Hewitt Bennet, College, Education, Account Access')
@section('meta-author', 'Hewitt Bennet International College')
@section('meta-url', url()->current())
@section('meta-image', asset('assets/img/hbiclogo.jpeg'))
@section('meta-date', now()->toIso8601String())

@section('og:type', 'website')
@section('og:title', 'Login - Hewitt Bennet International College')
@section('og:description', 'Login to your Hewitt Bennet International College account to access student resources and academic information.')
@section('og:image', asset('assets/img/hbiclogo.jpeg'))
@section('og:url', url()->current())
@section('og:site_name', 'Hewitt Bennet International College')
@section('og:published_time', now()->toIso8601String())

@section('twitter:card', 'summary_large_image')
@section('twitter:title', 'Login - Hewitt Bennet International College')
@section('twitter:description', 'Login to your Hewitt Bennet International College account to access student resources and academic information.')
@section('twitter:image', asset('assets/img/hbiclogo.jpeg'))
@section('twitter:site', '@HewittBennetIntl')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white rounded-xl shadow-lg p-8">
        <!-- Header Section -->
        <div class="text-center">
            <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="Hewitt Bennet International College Logo" class="mx-auto h-24 w-auto">
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                Login to Your Account
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Access your student portal, course materials, and academic resources.
            </p>
        </div>

        <!-- Error Alert -->
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        Authentication Error
                    </p>
                    <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Login Form -->
        <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
            @csrf

            <div class="space-y-4">
                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                           class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                           placeholder="Enter your email address" value="{{ old('email') }}">
                </div>

                <!-- Password Input -->
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                           class="mt-1 appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm pr-10"
                           placeholder="Enter your password">
                    <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-3 flex items-center mt-6 text-gray-400 hover:text-gray-600">
                        <i class="far fa-eye"></i>
                    </button>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 block text-sm text-gray-900">Remember Me</label>
                    </div>
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Forgot Password?</a>
                    </div>
                </div>
            </div>

            <!-- Login Button -->
            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    Sign In
                </button>
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 ml-1">
                        Create Account
                    </a>
                </p>
                <p class="mt-2 text-sm text-gray-600">
                    <a href="{{ url('/') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Return to Homepage
                    </a>
                </p>
            </div>
        </form>

        <!-- Security Notice -->
        <div class="mt-6 p-3 bg-blue-50 rounded-lg border border-blue-100">
            <p class="text-xs text-blue-700 text-center">
                <i class="fas fa-shield-alt mr-1"></i>
                Your privacy and security are important to us. This is a secure login portal.
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
