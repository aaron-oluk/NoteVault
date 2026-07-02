@extends('layouts.app')

@section('title', 'Lecturers and Researchers - NoteVault')
@section('pageTitle', 'Lecturers and Researchers')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Lecturers and Researchers</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Find and follow lecturers and researchers at your institution</p>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <form action="{{ route('creators.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <i class="bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by name..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                </div>
            </div>
            <div class="flex gap-2">
                <select name="role" onchange="this.form.submit()"
                        class="px-4 py-2.5 pr-10 text-sm border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 dark:hover:border-gray-600 transition-colors cursor-pointer font-medium appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%236B7280%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27m6 8 4 4 4-4%27/%3E%3C/svg%3E')] bg-[length:1.25rem] bg-[center_right_0.5rem] bg-no-repeat">
                    <option value="" {{ request('role') == '' ? 'selected' : '' }}>All Roles</option>
                    <option value="lecturer" {{ request('role') == 'lecturer' ? 'selected' : '' }}>Lecturers</option>
                    <option value="researcher" {{ request('role') == 'researcher' ? 'selected' : '' }}>Researchers</option>
                </select>
                <select name="sort" onchange="this.form.submit()"
                        class="px-4 py-2.5 pr-10 text-sm border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 dark:hover:border-gray-600 transition-colors cursor-pointer font-medium appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%236B7280%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27m6 8 4 4 4-4%27/%3E%3C/svg%3E')] bg-[length:1.25rem] bg-[center_right_0.5rem] bg-no-repeat">
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                    <option value="most_resources" {{ request('sort') == 'most_resources' ? 'selected' : '' }}>Most Resources</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                    Search
                </button>
            </div>
        </form>
    </div>

    <!-- People Grid -->
    @if($people->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($people as $person)
                <div class="bg-white dark:bg-blue-400 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-white text-xl font-bold">
                                {{ strtoupper(substr($person->first_name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white truncate">
                                    {{ $person->first_name ?? 'User' }}
                                    @if($person->last_name) {{ $person->last_name }} @endif
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($person->role) }}</p>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center space-x-4">
                                <span class="flex items-center">
                                    <i class="bx bx-file mr-1"></i>
                                    {{ $person->resources_count }} resources
                                </span>
                                <span class="flex items-center">
                                    <i class="bx bx-group mr-1"></i>
                                    {{ $person->followers_count ?? 0 }} followers
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('profile.creator', $person->id) }}"
                               class="flex-1 text-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                                View Profile
                            </a>
                            @auth
                                @if(auth()->id() !== $person->id)
                                    <button onclick="toggleFollow({{ $person->id }}, this)"
                                            class="px-4 py-2 rounded-lg transition-colors text-sm font-medium bg-blue-600 text-white hover:bg-blue-700"
                                            data-following="false"
                                            data-user-id="{{ $person->id }}">
                                        <i class="bx bx-user-plus"></i>
                                    </button>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $people->links() }}
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
            <i class="bx bx-user-circle text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No lecturers or researchers found</h3>
            <p class="text-gray-500 dark:text-gray-400">Try adjusting your search criteria</p>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-user-id]').forEach(function(button) {
        fetch(`/api/people/${button.dataset.userId}/following-status`, {
            headers: { 'Accept': 'application/json' },
            credentials: 'same-origin'
        })
        .then(response => response.ok ? response.json() : null)
        .then(data => {
            if (data && data.isFollowing) {
                setFollowingState(button, true);
            }
        })
        .catch(() => {});
    });
});

function setFollowingState(button, isFollowing) {
    button.dataset.following = isFollowing ? 'true' : 'false';
    button.classList.toggle('bg-gray-200', isFollowing);
    button.classList.toggle('text-gray-700', isFollowing);
    button.classList.toggle('hover:bg-gray-300', isFollowing);
    button.classList.toggle('bg-blue-600', !isFollowing);
    button.classList.toggle('text-white', !isFollowing);
    button.classList.toggle('hover:bg-blue-700', !isFollowing);
    button.innerHTML = isFollowing ? '<i class="bx bx-user-check"></i>' : '<i class="bx bx-user-plus"></i>';
}

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
        setFollowingState(button, !isFollowing);
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection
