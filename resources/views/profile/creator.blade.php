@extends('layouts.app')

@section('title', ($creator->first_name ?? 'User') . ' - Profile - NoteVault')
@section('pageTitle', 'Profile')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-950">
    <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-8 py-6 sm:py-8">
        <!-- Profile Header Card -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5 sm:p-8 mb-6">
            <div class="flex flex-col sm:flex-row gap-6">
                <!-- Avatar -->
                <div class="w-24 h-24 sm:w-32 sm:h-32 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center overflow-hidden flex-shrink-0">
                    <div class="w-full h-full bg-blue-600 dark:bg-blue-500 flex items-center justify-center">
                        <span class="text-3xl sm:text-4xl font-bold text-white">{{ strtoupper(substr($creator->first_name ?? 'U', 0, 1)) }}</span>
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                                {{ $creator->first_name ?? 'User' }}
                                @if($creator->last_name) {{ $creator->last_name }} @endif
                            </h1>
                            <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">{{ ucfirst($creator->role) }}</p>
                        </div>
                        <div class="flex gap-2 flex-shrink-0">
                            @auth
                                @if(auth()->id() !== $creator->id)
                                    <button id="follow-toggle-btn" onclick="toggleFollow({{ $creator->id }}, this)"
                                            class="px-4 sm:px-5 py-2 rounded-lg text-sm font-medium transition-colors {{ $isFollowing ? 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' : 'bg-blue-600 text-white hover:bg-blue-700' }}"
                                            data-following="{{ $isFollowing ? 'true' : 'false' }}">
                                        {{ $isFollowing ? 'Following' : 'Follow' }}
                                    </button>
                                @else
                                    <a href="{{ route('profile.edit') }}" class="px-4 sm:px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                        Edit Profile
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="px-4 sm:px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    Follow
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="flex flex-wrap items-center gap-4 sm:gap-6 text-sm">
                        <div>
                            <span class="font-bold text-gray-900 dark:text-white" id="followerCount">{{ number_format($followerCount) }}</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-1">Followers</span>
                        </div>
                        <div>
                            <span class="font-bold text-gray-900 dark:text-white">{{ number_format($followingCount) }}</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-1">Following</span>
                        </div>
                        <div>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $resources->total() }}</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-1">Resources</span>
                        </div>
                        <div>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $researchWorks->count() }}</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-1">Research Works</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mb-6">
            <nav class="flex gap-2">
                <button class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 dark:bg-blue-500 rounded-lg transition-all hover:bg-blue-700 dark:hover:bg-blue-600" data-tab="resources">
                    <i class="bx bx-file mr-1.5"></i>
                    Resources
                </button>
                <button class="px-4 py-2 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-all" data-tab="research">
                    <i class="bx bx-file-find mr-1.5"></i>
                    Research
                </button>
            </nav>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Resources Tab -->
                <div id="resources-tab">
                    @if($resources->count() > 0)
                        <div class="space-y-4">
                            @foreach($resources as $resource)
                            <a href="{{ route('resources.show', $resource) }}" class="block bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5 sm:p-6 hover:shadow-lg dark:hover:shadow-xl transition-all group">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $resource->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">{{ Str::limit($resource->description ?? 'No description available', 200) }}</p>
                                <div class="flex items-center gap-4 sm:gap-6 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center gap-1.5">
                                        <i class="bx bx-upvote text-base"></i>
                                        {{ $resource->engagements()->where('type', 'upvote')->count() }} upvotes
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <i class="bx bx-comment text-base"></i>
                                        {{ $resource->comments()->count() }} comments
                                    </span>
                                    <span>{{ $resource->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $resources->links() }}
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-12 sm:p-16 text-center">
                            <i class="bx bx-file text-6xl text-gray-300 dark:text-gray-700 mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No resources yet</h3>
                            <p class="text-gray-500 dark:text-gray-400">This person hasn't shared any resources.</p>
                        </div>
                    @endif
                </div>

                <!-- Research Tab (hidden by default) -->
                <div id="research-tab" class="hidden">
                    @if($researchWorks->count() > 0)
                        <div class="space-y-4">
                            @foreach($researchWorks as $researchWork)
                            <a href="{{ route('research.show', $researchWork) }}" class="block bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5 sm:p-6 hover:shadow-lg dark:hover:shadow-xl transition-all group">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">{{ $researchWork->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2 line-clamp-3">{{ Str::limit($researchWork->description ?? 'No description available', 200) }}</p>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ $researchWork->field_of_study ?? 'General' }} &middot; {{ $researchWork->created_at->diffForHumans() }}</p>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-12 sm:p-16 text-center">
                            <i class="bx bx-file-find text-6xl text-gray-300 dark:text-gray-700 mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No research works yet</h3>
                            <p class="text-gray-500 dark:text-gray-400">This person hasn't published any research works.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="space-y-5 sm:space-y-6">
                <!-- About -->
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">About</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                            <i class="bx bx-calendar text-lg"></i>
                            <span>Joined {{ $creator->created_at->format('F Y') }}</span>
                        </div>
                        @if($creator->institution)
                        <div class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                            <i class="bx bx-buildings text-lg"></i>
                            <span>{{ $creator->institution->name }}</span>
                        </div>
                        @endif
                        @if($creator->email && auth()->check() && (auth()->id() === $creator->id || auth()->user()->role === 'admin'))
                        <div class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                            <i class="bx bx-envelope text-lg"></i>
                            <span class="break-all">{{ $creator->email }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Similar People -->
                @php
                    $similarPeople = \App\Models\User::where('id', '!=', $creator->id)
                        ->where('role', $creator->role)
                        ->withCount('resources')
                        ->orderBy('resources_count', 'desc')
                        ->take(3)
                        ->get();
                @endphp
                @if($similarPeople->count() > 0)
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Similar People</h2>
                    <div class="space-y-3">
                        @foreach($similarPeople as $similar)
                        <a href="{{ route('profile.creator', $similar->id) }}" class="flex items-center gap-3 hover:bg-gray-50 dark:hover:bg-gray-800 -mx-2 px-2 py-2 rounded-lg transition-colors">
                            <div class="w-10 h-10 bg-blue-600 dark:bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                                {{ strtoupper(substr($similar->first_name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 dark:text-white truncate">{{ $similar->first_name ?? 'User' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $similar->resources_count }} resources</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </aside>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Tab switching
document.querySelectorAll('[data-tab]').forEach(tab => {
    tab.addEventListener('click', function() {
        const tabName = this.dataset.tab;

        // Update tab styles
        document.querySelectorAll('[data-tab]').forEach(t => {
            t.classList.remove('bg-blue-600', 'dark:bg-blue-500', 'text-white', 'hover:bg-blue-700', 'dark:hover:bg-blue-600');
            t.classList.add('text-gray-600', 'dark:text-gray-400', 'hover:text-gray-900', 'dark:hover:text-white', 'hover:bg-gray-100', 'dark:hover:bg-gray-800');
        });
        this.classList.remove('text-gray-600', 'dark:text-gray-400', 'hover:text-gray-900', 'dark:hover:text-white', 'hover:bg-gray-100', 'dark:hover:bg-gray-800');
        this.classList.add('bg-blue-600', 'dark:bg-blue-500', 'text-white', 'hover:bg-blue-700', 'dark:hover:bg-blue-600');

        // Show/hide content
        document.getElementById('resources-tab').classList.toggle('hidden', tabName !== 'resources');
        document.getElementById('research-tab').classList.toggle('hidden', tabName !== 'research');
    });
});

// Follow/Unfollow
function toggleFollow(userId, button) {
    const isFollowing = button.dataset.following === 'true';
    const url = isFollowing
        ? `/api/people/${userId}/unfollow`
        : `/api/people/${userId}/follow`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(() => {
        const followerCountEl = document.getElementById('followerCount');
        let count = parseInt(followerCountEl.textContent.replace(/,/g, ''));

        if (isFollowing) {
            button.dataset.following = 'false';
            button.textContent = 'Follow';
            button.classList.remove('bg-gray-100', 'dark:bg-gray-800', 'text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-200', 'dark:hover:bg-gray-700');
            button.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');
            followerCountEl.textContent = (count - 1).toLocaleString();
        } else {
            button.dataset.following = 'true';
            button.textContent = 'Following';
            button.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');
            button.classList.add('bg-gray-100', 'dark:bg-gray-800', 'text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-200', 'dark:hover:bg-gray-700');
            followerCountEl.textContent = (count + 1).toLocaleString();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection
