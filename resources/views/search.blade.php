@extends('layouts.app')

@section('title', 'Search Results - NoteVault')
@section('pageTitle', 'Search Results')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Search Results</h1>
    <p class="text-gray-600 dark:text-gray-400 mb-6">Showing results for "<span class="font-medium">{{ $query }}</span>"</p>

    @if($resources->isEmpty() && $researchWorks->isEmpty() && $people->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
            <i class="bx bx-search-alt text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No results found</h3>
            <p class="text-gray-500 dark:text-gray-400">Try searching with different keywords</p>
        </div>
    @else
        <!-- Resources Section -->
        @if($resources->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="bx bx-book-bookmark mr-2 text-blue-600 dark:text-blue-400"></i>
                    Resources ({{ $resources->count() }})
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($resources as $resource)
                        <a href="{{ route('resources.show', $resource) }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-shadow">
                            <h3 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $resource->title }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ optional($resource->user)->first_name ?? 'Unknown' }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">{{ Str::limit($resource->description ?? '', 150) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Research Section -->
        @if($researchWorks->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="bx bx-file-find mr-2 text-purple-600 dark:text-purple-400"></i>
                    Research ({{ $researchWorks->count() }})
                </h2>
                <div class="grid gap-4">
                    @foreach($researchWorks as $researchWork)
                        <a href="{{ route('research.show', $researchWork) }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-shadow">
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $researchWork->title }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">by {{ optional($researchWork->user)->first_name ?? 'Unknown' }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 line-clamp-2">{{ Str::limit($researchWork->description ?? '', 150) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- People Section -->
        @if($people->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                    <i class="bx bx-user-circle mr-2 text-green-600 dark:text-green-400"></i>
                    People ({{ $people->count() }})
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($people as $person)
                        <a href="{{ route('profile.creator', $person->id) }}" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-shadow flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($person->first_name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900 dark:text-white">{{ $person->first_name ?? 'User' }} {{ $person->last_name ?? '' }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($person->role) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
