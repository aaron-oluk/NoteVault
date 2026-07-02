<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'NoteVault'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
    </style>
    @yield('head')
</head>
<body @class(['antialiased', 'bg-gray-50', 'dark:bg-gray-950', 'overflow-x-hidden'])>
    @php
        $hideNavigation = false;
        $isAdminPage = request()->is('admin*') || request()->is('admin-dashboard*');
    @endphp

    @if(!$hideNavigation)
        @include('partials.sidebar')
        @include('partials.header')
    @endif

    <main class="{{ !$hideNavigation ? 'md:pl-56 pt-14' : '' }} min-h-screen pb-20 md:pb-0 bg-gray-50 dark:bg-gray-950">
        <div class="{{ !$hideNavigation ? 'px-4 sm:px-6 lg:px-8 py-6' : '' }}">
            @yield('content')
        </div>
    </main>

    @if(!$hideNavigation)
        @include('partials.mobile-nav')
        {{-- @if(!$isAdminPage)
            @include('partials.footer')
        @endif --}}
    @endif

    @yield('scripts')
</body>
</html>
