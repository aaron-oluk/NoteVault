@extends('layouts.app')

@section('title', ($resource->title ?? 'Resource') . ' - NoteVault')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-950">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('resources.index') }}"
               class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-normal">
                <i class="bx bx-arrow-back text-base mr-1"></i>
                Back to resources
            </a>
        </div>

        <div class="max-w-4xl mx-auto"
             id="resource-detail"
             data-resource-detail
             data-resource-uuid="{{ $resource->uuid }}"
             data-has-upvoted="{{ $hasUpvoted ? 'true' : 'false' }}"
             data-is-authenticated="{{ auth()->check() ? 'true' : 'false' }}">
            <div class="bg-white dark:bg-gray-900 shadow-sm rounded-md border border-gray-200 dark:border-gray-800">
                <!-- Header -->
                <div class="p-6 sm:p-8 border-b border-gray-200 dark:border-gray-800">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-3 flex-wrap">
                                <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs font-semibold rounded-full">{{ ucfirst(str_replace('_', ' ', $resource->type)) }}</span>
                                @if ($resource->is_lecturer_content)
                                    <span class="px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">
                                        <i class="bx bx-check-shield mr-0.5"></i> Lecturer content
                                    </span>
                                @endif
                            </div>
                            <h1 class="text-2xl md:text-3xl font-semibold text-gray-900 dark:text-white mb-3">{{ $resource->title }}</h1>
                            <div class="flex items-center flex-wrap gap-x-3 gap-y-1 text-gray-600 dark:text-gray-400">
                                <span class="text-sm">{{ optional($resource->user)->first_name ?? 'Unknown' }} {{ optional($resource->user)->last_name ?? '' }}</span>
                                @if ($resource->courseUnit)
                                    <span class="text-gray-400 dark:text-gray-600">&middot;</span>
                                    <span class="text-sm">{{ $resource->courseUnit->name }}</span>
                                @endif
                                @if ($resource->semester)
                                    <span class="text-gray-400 dark:text-gray-600">&middot;</span>
                                    <span class="text-sm">{{ $resource->semester }}</span>
                                @endif
                                @if ($resource->academic_year)
                                    <span class="text-gray-400 dark:text-gray-600">&middot;</span>
                                    <span class="text-sm">{{ $resource->academic_year }}</span>
                                @endif
                            </div>
                        </div>
                        @if (auth()->check() && auth()->id() === $resource->user_id)
                            <a href="{{ route('resources.edit', $resource) }}"
                               class="flex-shrink-0 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <i class="bx bx-edit mr-1"></i> Edit
                            </a>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-4 mt-6">
                        <button type="button" data-upvote-button
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ $hasUpvoted ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                            <i class="bx {{ $hasUpvoted ? 'bxs-upvote' : 'bx-upvote' }}"></i>
                            <span data-upvote-count>{{ $upvoteCount }}</span> Upvotes
                        </button>
                        <a href="{{ route('resources.download', $resource) }}" data-download-link
                            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-medium bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                            <i class="bx bx-download"></i>
                            <span data-download-count>{{ $downloadCount }}</span> Downloads
                        </a>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 sm:p-8">
                    <div class="prose dark:prose-invert max-w-none">
                        <div class="whitespace-pre-line text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $resource->description ?? 'No description available.' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Version History (lecturer content only) -->
            @if ($resource->is_lecturer_content)
                <div class="mt-6 bg-white dark:bg-gray-900 shadow-sm rounded-md border border-gray-200 dark:border-gray-800 p-6 sm:p-8">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <i class="bx bx-history mr-1"></i> Version History
                    </h2>
                    @forelse ($resource->versions()->latest('version_number')->get() as $version)
                        <div class="flex items-start gap-3 py-3 border-b border-gray-100 dark:border-gray-800 last:border-0">
                            <div class="w-8 h-8 rounded-full bg-green-50 dark:bg-green-900/20 flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-semibold text-green-700 dark:text-green-400">v{{ $version->version_number }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-700 dark:text-gray-300">{{ $version->changelog ?? 'No changelog provided.' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ optional($version->user)->first_name ?? 'Unknown' }} &middot; {{ $version->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">No version history yet.</p>
                    @endforelse
                </div>
            @endif

            <!-- Comments -->
            <div class="mt-6 bg-white dark:bg-gray-900 shadow-sm rounded-md border border-gray-200 dark:border-gray-800 p-6 sm:p-8">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="bx bx-comment mr-1"></i> Comments
                </h2>

                @auth
                    <form data-comment-form class="mb-6">
                        <textarea name="body" rows="3" required maxlength="1000" placeholder="Add a comment..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm"></textarea>
                        <div class="flex justify-end mt-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                                Post Comment
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                        <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Log in</a> to leave a comment.
                    </p>
                @endauth

                <div data-comments-list class="space-y-4">
                    @forelse ($resource->comments as $comment)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-medium flex-shrink-0">
                                {{ strtoupper(substr(optional($comment->user)->first_name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ optional($comment->user)->first_name ?? 'Unknown' }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">{{ $comment->body }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">No comments yet. Be the first to say something.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('resource-detail');
    if (container && window.ResourceDetail) {
        new ResourceDetail(container, {
            resourceUuid: container.getAttribute('data-resource-uuid'),
            hasUpvoted: container.getAttribute('data-has-upvoted') === 'true',
            isAuthenticated: container.getAttribute('data-is-authenticated') === 'true',
        });
    }
});
</script>
@endsection
