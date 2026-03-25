@extends('layouts.app')

@section('content')
<div class="bg-light min-h-screen flex items-center justify-center">
    <div class="w-full md:w-3/4 lg:w-1/2 bg-white rounded-lg shadow-lg p-8">
        <!-- Header Section -->
        <div class="text-center mb-6">
            <img src="{{ asset('assets/img/hbiclogo.jpeg') }}" alt="Logo" class="mx-auto mb-4" style="max-width: 100px;">
            <h2 class="text-2xl font-bold text-gray-800">{{ __('Register') }}</h2>
            <p class="text-sm text-gray-600">{{ __('Create an account to join us and access exclusive features.') }}</p>
        </div>

        <!-- Error Alert -->
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="error-message"></div>
        </div>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name Input -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                <input id="name" type="text" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Username Input -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">{{ __('Username') }}</label>
                <input id="username" type="text" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('username') border-red-500 @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">
                @error('username')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="mb-4 relative">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                <input id="password" type="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
                <i id="toggle-password" class="fas fa-eye absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer"></i>
                @error('password')
                    <div class="text-sm text-red-500 mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password Input -->
            <div class="mb-4 relative">
                <label for="password-confirm" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" name="password_confirmation" required autocomplete="new-password">
                <i id="toggle-password-confirm" class="fas fa-eye absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer"></i>
            </div>

            <!-- Register Button -->
            <div class="mb-0">
                <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-bold rounded-md hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">{{ __('Register') }}</button>
            </div>
        </form>

        <!-- Login Link -->
        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">{{ __('Already have an account?') }} <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800">{{ __('Login') }}</a></p>
        </div>
    </div>
</div>

<script>
    // Display errors in the alert box
    @if ($errors->any())
        var errorMessage = document.querySelector('.error-message');
        var errorBox = document.querySelector('.alert-danger');
        var errorList = document.createElement('ul');

        @foreach ($errors->all() as $error)
            var errorItem = document.createElement('li');
            errorItem.textContent = "{{ $error }}";
            errorList.appendChild(errorItem);
        @endforeach

        errorMessage.appendChild(errorList);
        errorBox.style.display = 'block';
    @endif

    // Toggle password visibility
    document.getElementById('toggle-password').addEventListener('click', function () {
        var passwordField = document.getElementById('password');
        var icon = this;

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

    // Toggle confirm password visibility
    document.getElementById('toggle-password-confirm').addEventListener('click', function () {
        var confirmPasswordField = document.getElementById('password-confirm');
        var icon = this;

        if (confirmPasswordField.type === 'password') {
            confirmPasswordField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            confirmPasswordField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
</script>
@endsection
