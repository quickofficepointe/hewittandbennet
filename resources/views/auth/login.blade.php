@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-500 to-purple-600">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8 space-y-6">
        <div class="text-center mb-6">
            <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="Logo" class="mx-auto mb-4" style="max-width: 100px;">
            <h2 class="text-2xl font-semibold text-gray-800">{{ __('Login') }}</h2>
            <p class="text-sm text-gray-600">{{ __('Please enter your email and password to access your account. If you don\'t have an account, you can register below.') }}</p>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
            <div class="font-bold">{{ __('Oops! Something went wrong.') }}</div>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="login-form" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                <input id="password" type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" name="password" required autocomplete="current-password">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="ml-2 block text-sm text-gray-900">{{ __('Remember Me') }}</label>
                </div>
                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">{{ __('Forgot Your Password?') }}</a>
                </div>
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-bold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">{{ __('Login') }}</button>
        </form>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">{{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">{{ __('Register') }}</a>
            </p>
            <p class="text-sm text-gray-600">
                <a href="{{ url('/') }}" class="font-medium text-indigo-600 hover:text-indigo-500">{{ __('Home') }}</a>
            </p>
        </div>
    </div>
</div>

<script>
    // Display errors in the alert box
    @if ($errors->any())
        var errorMessage = document.querySelector('.alert-danger');
        errorMessage.style.display = 'block';
    @endif
</script>
@endsection
