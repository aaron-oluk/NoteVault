@extends('layouts.auth')

@section('title', 'Login - NoteVault')

@section('auth-content')
<div>
    <!-- Header -->
    <div class="mb-8 text-center">
        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Welcome Back</h2>
        <p class="text-gray-600 dark:text-gray-400">Sign in to your account to continue your work</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Session Status -->
        @if (session('status'))
            <div class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-800 dark:text-green-300">{{ session('status') }}</p>
            </div>
        @endif

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Email Address</label>
            <div class="relative">
                <i class="bx bx-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                       class="w-full pl-11 pr-4 py-2.5 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 transition-colors"
                       placeholder="name@example.com">
            </div>
            @error('email')
                <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                        Forgot password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <i class="bx bx-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="w-full pl-11 pr-11 py-2.5 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 transition-colors"
                       placeholder="Enter your password">
                <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400">
                    <i class="bx bx-hide"></i>
                </button>
            </div>
            @error('password')
                <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center gap-2">
            <input id="remember_me" type="checkbox" name="remember" 
                   class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded focus:ring-0">
            <label for="remember_me" class="text-sm text-gray-700 dark:text-gray-300">
                Remember me for 30 days
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 font-semibold rounded-lg transition-colors">
            Sign In
        </button>
    </form>

    <!-- Divider -->
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white dark:bg-gray-900 text-gray-500 dark:text-gray-400">Don't have an account?</span>
        </div>
    </div>

    <!-- Register Link -->
    <a href="{{ route('register') }}" 
       class="block w-full text-center px-4 py-2.5 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
        Create Account
    </a>

    <!-- Legal Text -->
    <p class="mt-6 text-xs text-gray-500 dark:text-gray-400 text-center">
        By signing in, you agree to our <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Privacy Policy</a>
    </p>
</div>

<script>
function togglePasswordVisibility(fieldId, button) {
    const field = document.getElementById(fieldId);
    const icon = button.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bx-hide');
        icon.classList.add('bx-show');
    } else {
        field.type = 'password';
        icon.classList.remove('bx-show');
        icon.classList.add('bx-hide');
    }
}
</script>
@endsection
