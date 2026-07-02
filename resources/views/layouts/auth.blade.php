<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'NoteVault'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .fade-in-up { opacity: 0; transform: translateY(16px); animation: fadeInUp 0.7s ease-out forwards; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
    </style>
    @yield('head')
</head>

<body class="antialiased bg-white dark:bg-gray-900">
    <div class="min-h-screen flex">
        <!-- Left Section - Auth Form -->
        <div class="flex-1 flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('index') }}" class="flex items-center gap-2 mb-8 lg:hidden">
                <div class="w-8 h-8 bg-blue-300 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                    <i class="bx bx-book-open text-gray-900 dark:text-white text-lg"></i>
                </div>
                <span class="text-lg font-semibold tracking-tight text-gray-900 dark:text-white">NoteVault</span>
            </a>
            <div class="w-full max-w-md">
                @yield('auth-content')
            </div>
        </div>

        <!-- Right Section - Feature Promotion, themed to match the landing page -->
        <div class="hidden lg:flex lg:flex-1 relative overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-cyan-600">
            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>

            <div class="relative z-10 flex flex-col justify-center px-12 xl:px-16 text-white">
                <a href="{{ route('index') }}" class="flex items-center gap-2 mb-10">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <i class="bx bx-book-open text-blue-700 text-lg"></i>
                    </div>
                    <span class="text-lg font-semibold tracking-tight">NoteVault</span>
                </a>

                <span class="fade-in-up inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/10 rounded-full text-xs font-medium text-white/90 uppercase tracking-wider mb-6 w-fit">
                    <span class="w-1.5 h-1.5 bg-emerald-300 rounded-full"></span>
                    Built for university communities
                </span>

                @if(request()->routeIs('login'))
                    <h2 class="fade-in-up delay-100 text-3xl xl:text-4xl font-semibold leading-tight tracking-tight mb-4">Welcome back to your institution's academic home</h2>
                    <p class="fade-in-up delay-200 text-base xl:text-lg font-light text-white/80 leading-relaxed mb-10 max-w-md">
                        Sign in to pick up where you left off, browse new course resources, and check in on your research.
                    </p>
                @elseif(request()->routeIs('register'))
                    <h2 class="fade-in-up delay-100 text-3xl xl:text-4xl font-semibold leading-tight tracking-tight mb-4">Discover, publish, and collaborate</h2>
                    <p class="fade-in-up delay-200 text-base xl:text-lg font-light text-white/80 leading-relaxed mb-10 max-w-md">
                        Access course notes, publish research, and follow lecturers and researchers at your institution. Your academic work, organized in one place.
                    </p>
                @else
                    <h2 class="fade-in-up delay-100 text-3xl xl:text-4xl font-semibold leading-tight tracking-tight mb-4">Notes and research, organized by institution</h2>
                    <p class="fade-in-up delay-200 text-base xl:text-lg font-light text-white/80 leading-relaxed mb-10 max-w-md">
                        Join your university community. Share course notes, publish research, and follow lecturers and researchers in your department.
                    </p>
                @endif

                <div class="fade-in-up delay-200 space-y-3 max-w-md">
                    <div class="flex items-center gap-4 px-5 py-4 bg-white/10 backdrop-blur-md border border-white/10 rounded-2xl">
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bx bx-upload text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold mb-0.5">Share your resources</h3>
                            <p class="text-xs text-white/70">Upload notes and study guides for your course units</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 px-5 py-4 bg-white/10 backdrop-blur-md border border-white/10 rounded-2xl">
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bx bx-file-find text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold mb-0.5">Publish and review research</h3>
                            <p class="text-xs text-white/70">Submit research works for review and supervisor endorsement</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 px-5 py-4 bg-white/10 backdrop-blur-md border border-white/10 rounded-2xl">
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="bx bx-buildings text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold mb-0.5">Browse by department and course</h3>
                            <p class="text-xs text-white/70">Find resources scoped to your institution and field of study</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
</body>

</html>
