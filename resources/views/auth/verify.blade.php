@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-500 to-purple-600">
    <div class="w-full max-w-lg bg-white rounded-lg shadow-lg p-8 space-y-6">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">{{ __('Verify Your Email Address') }}</h2>
        </div>

        <div class="text-gray-700">
            @if (session('resent'))
                <div class="alert alert-success mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
            <p>{{ __('If you did not receive the email') }},
                <form class="inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="text-indigo-600 font-medium hover:text-indigo-500">{{ __('click here to request another') }}</button>.
                </form>
            </p>
        </div>
    </div>
</div>
@endsection
