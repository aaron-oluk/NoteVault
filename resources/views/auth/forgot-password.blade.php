@extends('layouts.auth')

@section('title', 'Forgot Password - NoteVault')

@section('auth-content')
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-8">
        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="bx bx-refresh text-3xl text-blue-600"></i>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Reset your password</h2>
            <p class="text-sm text-gray-600">Don't worry, it happens. Please enter the email address linked to your account.</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">{{ session('status') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <div class="relative">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                           class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:border-blue-600 focus:outline-none placeholder-gray-400"
                           placeholder="name@university.edu">
                    <i class="bx bx-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('email')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-blue-600 text-white py-2.5 px-4 font-medium hover:bg-blue-700 transition-colors rounded-lg">
                Send Reset Instructions
            </button>

            <!-- Back to Login -->
            <div class="text-center">
                <a href="{{ route('login') }}" 
                   class="text-sm text-gray-600 hover:text-gray-900 inline-flex items-center">
                    <i class="bx bx-arrow-back mr-1"></i>
                    Back to Log in
                </a>
            </div>
        </form>

        <!-- Help Link -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600">
                Need help? <a href="#" class="text-blue-600 hover:underline">Contact Support</a>
            </p>
        </div>
    </div>
</div>
@endsection
