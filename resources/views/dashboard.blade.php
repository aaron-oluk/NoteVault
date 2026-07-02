@extends('layouts.app')

@section('title', 'Dashboard - NoteVault')
@section('pageTitle', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Greeting Section -->
        <div class="mb-4 sm:mb-6">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white mb-1">{{ $greeting }},
                {{ $user->first_name ?? 'there' }}</h2>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Here is what is happening at your institution
                today.</p>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Left Column - Main Content -->
            <div class="lg:col-span-2 space-y-4 sm:space-y-5">
                <!-- Recommended for You -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-4 sm:p-5 border border-gray-100 dark:border-gray-800">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">Recommended for You
                        </h2>
                        <a href="{{ route('resources.index') }}"
                            class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">View
                            All</a>
                    </div>
                    @if ($recommendedResources->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                            @foreach ($recommendedResources as $resource)
                                <a href="{{ route('resources.show', $resource) }}" class="flex-shrink-0 group">
                                    <div
                                        class="w-full aspect-[2/3] bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-lg mb-2 overflow-hidden shadow-sm group-hover:shadow-md transition-shadow flex items-center justify-center">
                                        <i class="bx bx-file-pdf text-xl sm:text-2xl text-gray-400"></i>
                                    </div>
                                    <h3
                                        class="text-2xs sm:text-xs font-medium text-gray-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $resource->title }}</h3>
                                    <p class="text-2xs text-gray-500 dark:text-gray-400 truncate">{{ optional($resource->user)->first_name ?? 'Unknown' }}</p>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center py-6 sm:py-8">No
                            recommendations yet. Check back soon!</p>
                    @endif
                </div>

                <!-- Two Column Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    <!-- Recent Resources -->
                    <div
                        class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-4 sm:p-5 border border-gray-100 dark:border-gray-800">
                        <div class="flex items-center justify-between mb-3 sm:mb-4">
                            <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">Recent Resources
                            </h2>
                            <a href="{{ route('resources.index') }}"
                                class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 font-medium">View
                                All</a>
                        </div>
                        @forelse($recentResources as $resource)
                            <a href="{{ route('resources.show', $resource) }}"
                                class="flex items-start gap-3 {{ !$loop->last ? 'mb-3 pb-3 sm:mb-4 sm:pb-4 border-b border-gray-100 dark:border-gray-800' : '' }} hover:bg-gray-50 dark:hover:bg-gray-800 -mx-2 px-2 py-2 rounded-lg transition-colors">
                                <div
                                    class="w-9 h-9 sm:w-10 sm:h-10 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="bx bx-file text-sm sm:text-base text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span
                                        class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white block truncate">{{ $resource->title }}</span>
                                    <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400">by
                                        {{ optional($resource->user)->first_name ?? 'Unknown' }}</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center py-4">No recent
                                resources yet.</p>
                        @endforelse
                    </div>

                    <!-- Following -->
                    <div
                        class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-4 sm:p-5 border border-gray-100 dark:border-gray-800">
                        <div class="flex items-center justify-between mb-3 sm:mb-4">
                            <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">Following</h2>
                            <a href="{{ route('creators.index') }}"
                                class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 font-medium">Find
                                More</a>
                        </div>
                        @forelse($followedCreators as $creator)
                            <a href="{{ route('profile.creator', $creator->id) }}"
                                class="flex items-start gap-3 {{ !$loop->last ? 'mb-3 pb-3 sm:mb-4 sm:pb-4 border-b border-gray-100 dark:border-gray-800' : '' }} hover:bg-gray-50 dark:hover:bg-gray-800 -mx-2 px-2 py-2 rounded-lg transition-colors">
                                <div
                                    class="w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-br from-pink-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    <span
                                        class="text-white text-xs sm:text-sm font-medium">{{ strtoupper(substr($creator->first_name ?? 'U', 0, 2)) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span
                                        class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white block truncate">{{ $creator->first_name ?? 'User' }}
                                        {{ $creator->last_name ?? '' }}</span>
                                    <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400">
                                        {{ ucfirst($creator->role) }}</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center py-4">You are not
                                following anyone yet.</p>
                            <a href="{{ route('creators.index') }}"
                                class="block text-center text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 font-medium mt-2">Discover
                                Lecturers and Researchers</a>
                        @endforelse
                    </div>
                </div>

                <!-- Researcher section: own research plus pending reviews/endorsements -->
                @if ($researchWorks->count() > 0 || $pendingReviews->count() > 0 || $pendingEndorsements->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-4 sm:p-5 border border-purple-100 dark:border-purple-900/30">
                        <div class="flex items-center justify-between mb-3 sm:mb-4">
                            <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white flex items-center gap-1.5">
                                <i class="bx bx-file-find text-purple-600 dark:text-purple-400"></i>
                                My Research
                            </h2>
                            <a href="{{ route('research.index') }}" class="text-xs text-purple-600 dark:text-purple-400 hover:text-purple-700 font-medium">View All</a>
                        </div>
                        @forelse ($researchWorks as $researchWork)
                            <a href="{{ route('research.show', $researchWork) }}"
                                class="block {{ !$loop->last ? 'mb-3 pb-3 sm:mb-4 sm:pb-4 border-b border-gray-100 dark:border-gray-800' : '' }} hover:bg-purple-50 dark:hover:bg-purple-900/10 -mx-2 px-2 py-2 rounded-lg transition-colors">
                                <span class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white block truncate">{{ $researchWork->title }}</span>
                                <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $researchWork->status)) }}</p>
                            </a>
                        @empty
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center py-4">No research works yet.</p>
                        @endforelse
                    </div>

                    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-4 sm:p-5 border border-purple-100 dark:border-purple-900/30">
                        <div class="flex items-center justify-between mb-3 sm:mb-4">
                            <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">Pending Reviews &amp; Endorsements</h2>
                        </div>
                        @forelse ($pendingReviews->concat($pendingEndorsements) as $item)
                            <a href="{{ route('research.show', $item->researchWork) }}"
                                class="block {{ !$loop->last ? 'mb-3 pb-3 sm:mb-4 sm:pb-4 border-b border-gray-100 dark:border-gray-800' : '' }} hover:bg-purple-50 dark:hover:bg-purple-900/10 -mx-2 px-2 py-2 rounded-lg transition-colors">
                                <span class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white block truncate">{{ optional($item->researchWork)->title }}</span>
                                <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400">Pending</p>
                            </a>
                        @empty
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center py-4">Nothing pending.</p>
                        @endforelse
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-4 sm:space-y-5">
                <!-- Quick Actions -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-4 sm:p-5 border border-gray-100 dark:border-gray-800">
                    <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4">Quick Actions
                    </h2>
                    <div class="space-y-2">
                        <a href="{{ route('resources.create') }}"
                            class="flex items-center gap-3 px-3 sm:px-4 py-2.5 sm:py-3 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors">
                            <i class="bx bx-upload text-lg sm:text-xl"></i>
                            <span class="text-xs sm:text-sm font-medium">Add a Resource</span>
                        </a>
                        <a href="{{ route('research.create') }}"
                            class="flex items-center gap-3 px-3 sm:px-4 py-2.5 sm:py-3 bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/50 transition-colors">
                            <i class="bx bx-file-find text-lg sm:text-xl"></i>
                            <span class="text-xs sm:text-sm font-medium">Submit Research</span>
                        </a>
                        <a href="{{ route('departments.index') }}"
                            class="flex items-center gap-3 px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="bx bx-buildings text-lg sm:text-xl"></i>
                            <span class="text-xs sm:text-sm font-medium">Browse Departments</span>
                        </a>
                    </div>
                </div>

                <!-- Stats -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-4 sm:p-5 border border-gray-100 dark:border-gray-800">
                    <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4">Your Stats</h2>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Resources uploaded</span>
                            <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">{{ $resourcesUploaded }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Upvotes received</span>
                            <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">{{ $totalUpvotesReceived }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Following</span>
                            <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">{{ $followingCount }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
