@extends('layouts.app')

@section('title', 'Welcome - NoteVault')
@section('pageTitle', 'Home')

@section('content')
<div class="min-h-screen bg-white dark:bg-gray-900">
    <div class="w-full grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 px-4 sm:px-6 lg:px-8 py-6">
        <!-- Main Content Area -->
        <main class="lg:col-span-2 space-y-4 sm:space-y-6">
            <!-- Page Header -->
            <div class="mb-6 sm:mb-8">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3">Welcome to NoteVault</h1>
                <p class="text-sm sm:text-base lg:text-lg text-gray-600 dark:text-gray-400 leading-relaxed max-w-2xl">
                    @auth
                        Good {{ date('H') < 12 ? 'morning' : (date('H') < 18 ? 'afternoon' : 'evening') }}, <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $user->first_name ?? 'there' }}</span>. Here is what is happening in your institution today.
                    @else
                        Notes, research, and academic resources, organized by institution, department, and course. Connect with lecturers and researchers in your community.
                    @endauth
                </p>
            </div>

            <!-- Popular Resources -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Popular Resources</h2>
                    <a href="{{ route('resources.index') }}" class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold whitespace-nowrap">View All &rarr;</a>
                </div>
                @if($popularResources->count() > 0)
                <div class="flex gap-3 sm:gap-4 overflow-x-auto pb-2">
                    @foreach($popularResources as $resource)
                    <a href="{{ route('resources.show', $resource) }}" class="flex-shrink-0 w-40 sm:w-48 group">
                        <div class="w-40 sm:w-48 h-28 sm:h-32 bg-gradient-to-br from-blue-100 dark:from-blue-900/40 to-cyan-100 dark:to-cyan-900/40 rounded-lg flex items-center justify-center mb-2 sm:mb-3 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                            <i class="bx bx-file-pdf text-3xl sm:text-4xl text-blue-600 dark:text-blue-400 opacity-60"></i>
                        </div>
                        <h3 class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $resource->title }}</h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400 truncate">{{ optional($resource->user)->first_name ?? 'Unknown' }}</p>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 sm:py-12">
                    <i class="bx bx-file text-4xl sm:text-5xl text-gray-300 dark:text-gray-600 mb-4"></i>
                    <p class="text-sm text-gray-500 dark:text-gray-400">No resources available yet</p>
                </div>
                @endif
            </div>

            <!-- Recent Resources -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Recent Resources</h2>
                    <a href="{{ route('resources.index') }}" class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold whitespace-nowrap">View All &rarr;</a>
                </div>
                @if($recentResources->count() > 0)
                <div class="space-y-3 sm:space-y-4">
                    @foreach($recentResources->take(5) as $resource)
                    <a href="{{ route('resources.show', $resource) }}" class="flex items-start gap-3 sm:gap-4 p-3 sm:p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-100 dark:from-blue-900/40 to-blue-50 dark:to-blue-800/40 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="bx bx-file text-base sm:text-lg text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1 sm:mb-2 flex-wrap">
                                <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 truncate">{{ $resource->title }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $resource->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 line-clamp-2">{{ Str::limit($resource->description ?? 'No description', 100) }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 sm:py-12">
                    <i class="bx bx-file text-4xl sm:text-5xl text-gray-300 dark:text-gray-600 mb-4"></i>
                    <p class="text-sm text-gray-500 dark:text-gray-400">No resources available yet</p>
                </div>
                @endif
            </div>

            <!-- Recently Endorsed Research -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md p-4 sm:p-6 border border-purple-100 dark:border-purple-900/30">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="bx bx-file-find text-purple-600 dark:text-purple-400"></i>
                        Recently Endorsed Research
                    </h2>
                    <a href="{{ route('research.index') }}" class="text-xs sm:text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-semibold whitespace-nowrap">View All &rarr;</a>
                </div>
                @if($recentResearchWorks->count() > 0)
                <div class="space-y-3 sm:space-y-4">
                    @foreach($recentResearchWorks as $researchWork)
                    <a href="{{ route('research.show', $researchWork) }}" class="flex items-start gap-3 sm:gap-4 p-3 sm:p-4 rounded-lg hover:bg-purple-50 dark:hover:bg-purple-900/10 transition-colors group">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-purple-100 dark:from-purple-900/40 to-purple-50 dark:to-purple-800/40 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="bx bx-badge-check text-base sm:text-lg text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1 sm:mb-2 flex-wrap">
                                <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 truncate">{{ $researchWork->title }}</span>
                            </div>
                            <p class="text-xs sm:text-sm text-gray-700 dark:text-gray-300">{{ optional($researchWork->user)->first_name ?? 'Unknown' }} &middot; {{ $researchWork->field_of_study ?? ($researchWork->department->name ?? 'General') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 sm:py-12">
                    <i class="bx bx-file-find text-4xl sm:text-5xl text-gray-300 dark:text-gray-600 mb-4"></i>
                    <p class="text-sm text-gray-500 dark:text-gray-400">No endorsed research yet</p>
                </div>
                @endif
            </div>

            <!-- Following (only for authenticated users) -->
            @auth
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Following</h2>
                    <a href="{{ route('creators.index') }}" class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold whitespace-nowrap">View All &rarr;</a>
                </div>
                <div class="space-y-3 sm:space-y-4">
                    @forelse($followedCreators ?? [] as $creator)
                        <a href="{{ route('profile.creator', $creator->id) }}" class="flex items-start gap-3 sm:gap-4 p-3 sm:p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                                <span class="text-white text-xs sm:text-sm font-semibold">{{ strtoupper(substr($creator->first_name ?? 'U', 0, 2)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1 sm:mb-2 flex-wrap">
                                    <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">{{ $creator->first_name ?? 'User' }} {{ $creator->last_name ?? '' }}</span>
                                </div>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ $creator->resources->count() }} {{ Str::plural('resource', $creator->resources->count()) }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-6 sm:py-8">
                            <i class="bx bx-user text-3xl sm:text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-2">You are not following anyone yet</p>
                            <a href="{{ route('creators.index') }}" class="inline-block text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                                Discover lecturers and researchers &rarr;
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
            @endauth
        </main>

        <!-- Right Sidebar -->
        <aside class="space-y-6">
            <!-- Quick Actions -->
            @auth
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-6">Quick Actions</h2>
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
            @endauth

            <!-- Explore -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4 sm:mb-6 gap-2">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Explore</h2>
                </div>
                <div class="space-y-2 sm:space-y-3">
                    <a href="{{ route('resources.index') }}" class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border border-gray-200 dark:border-gray-700">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-blue-100 dark:from-blue-900/40 to-blue-50 dark:to-blue-800/40 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bx bx-book-bookmark text-base sm:text-lg text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white truncate">Resources</h3>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Notes and study guides</p>
                        </div>
                    </a>
                    <a href="{{ route('research.index') }}" class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border border-gray-200 dark:border-gray-700">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-purple-100 dark:from-purple-900/40 to-purple-50 dark:to-purple-800/40 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bx bx-file-find text-base sm:text-lg text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white truncate">Research</h3>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Papers and theses</p>
                        </div>
                    </a>
                    <a href="{{ route('creators.index') }}" class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border border-gray-200 dark:border-gray-700">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-green-100 dark:from-green-900/40 to-green-50 dark:to-green-800/40 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="bx bx-user-circle text-base sm:text-lg text-green-600 dark:text-green-400"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white truncate">People</h3>
                            <p class="text-xs text-gray-600 dark:text-gray-400">Lecturers and researchers</p>
                        </div>
                    </a>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
