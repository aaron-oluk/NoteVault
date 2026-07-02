@extends('layouts.app')

@section('title', 'Research - NoteVault')
@section('pageTitle', 'Research')

@section('content')
    <div class="min-h-screen bg-white dark:bg-gray-900 flex flex-col">
        <!-- Header -->
        <div class="border-b border-gray-200 dark:border-gray-800 py-6 sm:py-8 bg-gradient-to-r from-purple-50 dark:from-purple-900/10 to-white dark:to-gray-900">
            <div class="px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                        <i class="bx bx-file-find text-purple-600 dark:text-purple-400"></i>
                        Research
                    </h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Papers and theses, reviewed and endorsed by supervisors</p>
                </div>
                @auth
                    <a href="{{ route('research.create') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors whitespace-nowrap">
                        <i class="bx bx-plus mr-1.5"></i>
                        Submit Research
                    </a>
                @endauth
            </div>
        </div>

        <div class="px-4 sm:px-6 lg:px-8 py-6 sm:py-8 flex-1">
            <!-- Search Bar -->
            <form action="{{ route('research.index') }}" method="GET" class="mb-8 sm:mb-12 max-w-2xl">
                <div class="relative">
                    <i class="bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search research by title, description, or field of study..."
                        class="w-full pl-11 pr-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm">
                </div>
            </form>

            <div>
                @if ($researchWorks->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        @foreach ($researchWorks as $researchWork)
                            <a href="{{ route('research.show', $researchWork) }}"
                                class="group p-5 rounded-lg border border-purple-100 dark:border-purple-900/30 bg-white dark:bg-gray-800 hover:border-purple-400 dark:hover:border-purple-500 hover:shadow-md dark:hover:shadow-lg transition-all">
                                <div class="flex items-start gap-3 mb-3">
                                    <div class="w-10 h-10 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-100 dark:group-hover:bg-purple-800/40 transition-colors">
                                        <i class="bx bx-file-find text-lg text-purple-600 dark:text-purple-400"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 dark:text-white line-clamp-2 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors text-sm">
                                            {{ $researchWork->title }}</h3>
                                    </div>
                                    @if ($researchWork->publicly_visible)
                                        <span class="flex-shrink-0 px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-2xs font-semibold rounded-full">Endorsed</span>
                                    @else
                                        <span class="flex-shrink-0 px-2 py-0.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-2xs font-semibold rounded-full">{{ ucfirst(str_replace('_', ' ', $researchWork->status)) }}</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">
                                    {{ optional($researchWork->user)->first_name ?? 'Unknown' }} &middot; {{ $researchWork->field_of_study ?? ($researchWork->department->name ?? 'General') }}
                                </p>
                                <p class="text-xs text-gray-700 dark:text-gray-300 mb-3 line-clamp-3">
                                    {{ $researchWork->description ?? 'No description available' }}</p>
                                <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-700">
                                    <span class="text-xs text-gray-500 dark:text-gray-500">{{ $researchWork->created_at->format('M d, Y') }}</span>
                                    <span class="text-xs font-semibold text-purple-600 dark:text-purple-400">View</span>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="flex justify-center my-8">
                        {{ $researchWorks->links() }}
                    </div>
                @else
                    <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-800">
                        <i class="bx bx-file-find text-6xl text-gray-300 dark:text-gray-600 mb-4 block"></i>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">No research works found</h3>
                        <p class="text-gray-600 dark:text-gray-400">Try adjusting your search or be the first to submit one</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
