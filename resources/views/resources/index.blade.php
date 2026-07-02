@extends('layouts.app')

@section('title', 'Resources - NoteVault')
@section('pageTitle', 'Resources')

@section('content')
    <div class="min-h-screen bg-white dark:bg-gray-900 flex flex-col">
        <!-- Clean Header -->
        <div class="border-b border-gray-200 dark:border-gray-800 py-6 sm:py-8">
            <div class="px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2">Resources</h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Notes, past papers, and study guides shared by your course community</p>
                </div>
                @auth
                    <a href="{{ route('resources.create') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors whitespace-nowrap">
                        <i class="bx bx-plus mr-1.5"></i>
                        Add Resource
                    </a>
                @endauth
            </div>
        </div>

        <div class="px-4 sm:px-6 lg:px-8 py-6 sm:py-8 flex-1">
            <!-- Search Bar -->
            <form action="{{ route('resources.index') }}" method="GET" class="mb-8 sm:mb-12 max-w-2xl">
                <div class="relative">
                    <i class="bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search resources by title or description..."
                        class="w-full pl-11 pr-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm">
                </div>
            </form>

            <!-- Recent Resources -->
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-6">Recent Resources</h2>
                @if ($resources->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
                        @foreach ($resources as $resource)
                            <a href="{{ route('resources.show', $resource) }}"
                                class="group p-4 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-800 hover:border-blue-500 dark:hover:border-blue-400 hover:shadow-md dark:hover:shadow-lg transition-all">
                                <div class="flex items-start gap-3 mb-3">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-100 dark:group-hover:bg-blue-800/40 transition-colors">
                                        <i class="bx bx-file-pdf text-lg text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3
                                            class="font-semibold text-gray-900 dark:text-white line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors text-sm">
                                            {{ $resource->title }}</h3>
                                    </div>
                                    @if ($resource->is_lecturer_content)
                                        <span class="flex-shrink-0 px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-2xs font-semibold rounded-full">Lecturer</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">
                                    {{ $resource->courseUnit->name ?? ucfirst(str_replace('_', ' ', $resource->type)) }}
                                </p>
                                <p class="text-xs text-gray-700 dark:text-gray-300 mb-3 line-clamp-2">
                                    {{ $resource->description ?? 'No description available' }}</p>
                                <div
                                    class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <span
                                        class="text-xs text-gray-500 dark:text-gray-500">{{ $resource->created_at->format('M d, Y') }}</span>
                                    <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">View</span>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center my-8">
                        {{ $resources->links() }}
                    </div>
                @else
                    <div
                        class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-800">
                        <i class="bx bx-file text-6xl text-gray-300 dark:text-gray-600 mb-4 block"></i>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">No resources found</h3>
                        <p class="text-gray-600 dark:text-gray-400">Try adjusting your search or be the first to share one</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
