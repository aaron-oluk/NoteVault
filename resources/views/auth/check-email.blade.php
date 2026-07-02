@extends('layouts.auth')

@section('title', 'Check Your Email - NoteVault')

@php
    $email = $email ?? old('email', '');
    $maskedEmail = $email ? substr($email, 0, 1) . str_repeat('*', max(0, strpos($email, '@') - 1)) . substr($email, strpos($email, '@')) : 'your email address';
@endphp

@section('auth-content')
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-8">
        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center relative">
                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center">
                    <i class="bx bx-envelope text-2xl text-white"></i>
                </div>
                <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center border-2 border-white">
                    <i class="bx bx-check text-white text-sm"></i>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Check your mail</h2>
            <p class="text-sm text-gray-600 mb-2">We have sent password recovery instructions to</p>
            <p class="text-sm font-semibold text-gray-900">{{ $maskedEmail }}</p>
        </div>

        <!-- Primary Action Button -->
        <div class="mb-6">
            <a href="{{ route('login') }}" 
               class="block w-full bg-blue-600 text-white py-2.5 px-4 font-medium hover:bg-blue-700 transition-colors rounded-lg text-center">
                Back to Log In
            </a>
        </div>

        <!-- Resend Instructions -->
        <div class="text-center mb-6">
            <p class="text-sm text-gray-600 mb-2">
                Did not receive the email? Check your spam filter, or
            </p>
            <form method="POST" action="{{ route('password.email') }}" class="inline">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" class="text-sm text-blue-600 hover:underline font-medium">
                    Click to resend email
                </button>
            </form>
        </div>

        <!-- Support Link -->
        <div class="text-center pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                Need further assistance? <a href="#" class="text-blue-600 hover:underline">Contact Support</a>
            </p>
        </div>
    </div>
</div>
@endsection

