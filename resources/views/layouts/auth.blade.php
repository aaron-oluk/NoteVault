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
    @yield('head')
</head>

<body class="antialiased bg-white dark:bg-gray-900">
    <div class="min-h-screen flex">
        <!-- Left Section - Auth Form -->
        <div class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md">
                @yield('auth-content')
            </div>
        </div>

        <!-- Right Section - Feature Promotion -->
        @if(request()->routeIs('login'))
        <div class="hidden lg:flex lg:flex-1 bg-white dark:bg-gray-800 items-center justify-center px-12">
            <div class="max-w-md">
                <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">Notes and research, organized by institution</h2>
                <p class="text-base text-gray-600 dark:text-gray-400 mb-8">
                    Join your university community. Share course notes, publish research, and follow lecturers and researchers in your department.
                </p>
                <div class="space-y-4">
                    <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-6 hover:shadow-md dark:hover:shadow-lg transition-shadow">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bx bx-upload text-2xl text-gray-600 dark:text-gray-300"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">Share your resources</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Upload notes and study guides for your course units</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-6 hover:shadow-md dark:hover:shadow-lg transition-shadow">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bx bx-file-find text-2xl text-gray-600 dark:text-gray-300"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">Publish and review research</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Submit research works for review and supervisor endorsement</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-6 hover:shadow-md dark:hover:shadow-lg transition-shadow">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bx bx-buildings text-2xl text-gray-600 dark:text-gray-300"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">Browse by department and course</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Find resources scoped to your institution and field of study</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif(request()->routeIs('register'))
        <!-- Register page - Dark blue background with buttons -->
        <div class="hidden lg:flex lg:flex-1 bg-gradient-to-br from-blue-900 via-purple-900 to-blue-800 relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="relative z-10 flex flex-col justify-center px-12 text-white">
                <h2 class="text-4xl font-semibold mb-4">Discover. Publish. Collaborate.</h2>
                <p class="text-lg mb-8 opacity-90">
                    Access course notes, publish research, and follow lecturers and researchers at your institution. Your academic work, organized in one place.
                </p>
                <div class="flex gap-3">
                    <a href="/resources" class="px-4 py-2 border-2 border-white rounded-lg text-sm font-medium hover:bg-white hover:text-blue-900 transition-colors flex items-center gap-2">
                        <i class="bx bx-book-bookmark"></i>
                        Resources
                    </a>
                    <a href="/research" class="px-4 py-2 border-2 border-white rounded-lg text-sm font-medium hover:bg-white hover:text-blue-900 transition-colors flex items-center gap-2">
                        <i class="bx bx-file-find"></i>
                        Research
                    </a>
                    <a href="/creators" class="px-4 py-2 border-2 border-white rounded-lg text-sm font-medium hover:bg-white hover:text-blue-900 transition-colors flex items-center gap-2">
                        <i class="bx bx-user-circle"></i>
                        People
                    </a>
                </div>
            </div>
        </div>
        @else
        <!-- For other auth pages (password reset, etc.) -->
        <div class="hidden lg:flex lg:flex-1 bg-gradient-to-br from-blue-900 via-purple-900 to-blue-800 relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="relative z-10 flex flex-col justify-center px-12 text-white">
                <h2 class="text-4xl font-semibold mb-4">Discover. Publish. Collaborate.</h2>
                <p class="text-lg mb-8 opacity-90">
                    Access course notes, publish research, and follow lecturers and researchers at your institution. Your academic work, organized in one place.
                </p>
                <div class="flex gap-3">
                    <button class="px-4 py-2 border-2 border-white rounded-lg text-sm font-medium hover:bg-white hover:text-blue-900 transition-colors flex items-center gap-2">
                        <i class="bx bx-book-bookmark"></i>
                        Resources
                    </button>
                    <button class="px-4 py-2 border-2 border-white rounded-lg text-sm font-medium hover:bg-white hover:text-blue-900 transition-colors flex items-center gap-2">
                        <i class="bx bx-file-find"></i>
                        Research
                    </button>
                    <button class="px-4 py-2 border-2 border-white rounded-lg text-sm font-medium hover:bg-white hover:text-blue-900 transition-colors flex items-center gap-2">
                        <i class="bx bx-user-circle"></i>
                        People
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>

    @yield('scripts')
</body>

</html>
