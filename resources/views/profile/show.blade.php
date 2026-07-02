@extends('layouts.app')

@section('title', 'Profile - NoteVault')
@section('pageTitle', 'My Profile')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Profile Header -->
        <div
            class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 sm:p-6 mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div class="flex items-center sm:items-start gap-3 sm:gap-5">
                    <div class="relative flex-shrink-0">
                        <div
                            class="w-14 h-14 sm:w-20 sm:h-20 bg-blue-500 rounded-full flex items-center justify-center text-white text-lg sm:text-2xl font-semibold">
                            {{ strtoupper(substr($user->first_name ?? 'U', 0, 1)) }}
                        </div>
                        <div
                            class="absolute bottom-0 right-0 w-3.5 h-3.5 sm:w-5 sm:h-5 bg-green-500 rounded-full border-2 border-white dark:border-gray-900">
                        </div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-0.5 truncate">
                            {{ $user->first_name ?? 'User' }} {{ $user->last_name ?? '' }}
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                            {{ ucfirst($user->role) }}</p>
                        @if ($user->institution)
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mt-1">{{ $user->institution->name }}</p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center justify-center gap-2 px-3 sm:px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-200 text-xs sm:text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors w-full sm:w-auto">
                    <i class="bx bx-cog text-base sm:text-lg"></i>
                    <span>Settings</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-3 gap-2 sm:gap-4 mb-4 sm:mb-6">
            <div
                class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-200 dark:border-gray-800 p-2.5 sm:p-4 text-center sm:text-left">
                <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400 uppercase mb-0.5 sm:mb-1">Resources</p>
                <p class="text-base sm:text-2xl font-semibold text-gray-900 dark:text-white">{{ $resourcesUploaded }}</p>
            </div>
            <div
                class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-200 dark:border-gray-800 p-2.5 sm:p-4 text-center sm:text-left">
                <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400 uppercase mb-0.5 sm:mb-1">Upvotes</p>
                <p class="text-base sm:text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalUpvotesReceived }}</p>
            </div>
            <div
                class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-200 dark:border-gray-800 p-2.5 sm:p-4 text-center sm:text-left">
                <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400 uppercase mb-0.5 sm:mb-1">Following</p>
                <p class="text-base sm:text-2xl font-semibold text-gray-900 dark:text-white">{{ $followingCount }}</p>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Main Content -->
            <main class="flex-1 min-w-0">
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 mb-4 sm:mb-6 p-4 sm:p-6">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">Recent Resources</h2>
                        <a href="{{ route('resources.index') }}"
                            class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">View
                            All</a>
                    </div>
                    @forelse ($recentResources as $resource)
                        <a href="{{ route('resources.show', $resource) }}"
                            class="flex items-start gap-3 {{ !$loop->last ? 'mb-3 pb-3 border-b border-gray-100 dark:border-gray-800' : '' }} hover:bg-gray-50 dark:hover:bg-gray-800 -mx-2 px-2 py-2 rounded-lg transition-colors">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="bx bx-file text-sm sm:text-base text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white block truncate">{{ $resource->title }}</span>
                                <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400">{{ $resource->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-8 sm:py-12">
                            <i class="bx bx-file text-4xl sm:text-5xl text-gray-300 dark:text-gray-600 mb-3"></i>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-2">No resources available yet.</p>
                            <a href="{{ route('resources.create') }}"
                                class="inline-block text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:underline">Add a resource</a>
                        </div>
                    @endforelse
                </div>
            </main>

            <!-- Right Sidebar -->
            <aside class="lg:w-72 flex-shrink-0 space-y-5">
                <!-- Following -->
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Following</h2>
                        <a href="{{ route('creators.index') }}"
                            class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 font-medium">View All</a>
                    </div>
                    @if ($followedCreators->count() > 0)
                        <div class="space-y-3">
                            @foreach ($followedCreators as $creator)
                                <a href="{{ route('profile.creator', $creator) }}" class="flex items-center gap-3 group">
                                    <div
                                        class="w-9 h-9 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-xs font-medium">
                                        {{ strtoupper(substr($creator->first_name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3
                                            class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 truncate">
                                            {{ $creator->first_name ?? 'User' }}
                                        </h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst($creator->role) }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-500 dark:text-gray-400">You are not following anyone yet.</p>
                    @endif
                    <a href="{{ route('creators.index') }}"
                        class="block w-full mt-4 px-3 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors text-center">
                        Discover Lecturers and Researchers
                    </a>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Quick Actions</h2>
                    <div class="space-y-1">
                        <a href="{{ route('resources.create') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                            <i class="bx bx-upload text-gray-400"></i>
                            Add a Resource
                        </a>
                        <a href="{{ route('research.create') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                            <i class="bx bx-file-find text-gray-400"></i>
                            Submit Research
                        </a>
                        <a href="{{ route('departments.index') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                            <i class="bx bx-buildings text-gray-400"></i>
                            Browse Departments
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
