@extends('layouts.app')

@section('title', ($researchWork->title ?? 'Research Work') . ' - NoteVault')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-950">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('research.index') }}"
               class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-normal">
                <i class="bx bx-arrow-back text-base mr-1"></i>
                Back to research
            </a>
        </div>

        <div class="max-w-4xl mx-auto"
             id="research-work-detail"
             data-research-work-detail
             data-research-work-uuid="{{ $researchWork->uuid }}"
             data-is-authenticated="{{ auth()->check() ? 'true' : 'false' }}">
            <div class="bg-white dark:bg-gray-900 shadow-sm rounded-md border-t-4 border-purple-500 border-x border-b border-gray-200 dark:border-gray-800">
                <!-- Header -->
                <div class="p-6 sm:p-8 border-b border-gray-200 dark:border-gray-800">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-3 flex-wrap">
                                <span class="px-2 py-0.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 text-xs font-semibold rounded-full">
                                    <i class="bx bx-file-find mr-0.5"></i> Research
                                </span>
                                @if ($researchWork->publicly_visible)
                                    <span class="px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">Endorsed &amp; Public</span>
                                @else
                                    <span class="px-2 py-0.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-semibold rounded-full">{{ ucfirst(str_replace('_', ' ', $researchWork->status)) }}</span>
                                @endif
                            </div>
                            <h1 class="text-2xl md:text-3xl font-semibold text-gray-900 dark:text-white mb-3">{{ $researchWork->title }}</h1>
                            <div class="flex items-center flex-wrap gap-x-3 gap-y-1 text-gray-600 dark:text-gray-400">
                                <span class="text-sm">{{ optional($researchWork->user)->first_name ?? 'Unknown' }} {{ optional($researchWork->user)->last_name ?? '' }}</span>
                                @if ($researchWork->department)
                                    <span class="text-gray-400 dark:text-gray-600">&middot;</span>
                                    <span class="text-sm">{{ $researchWork->department->name }}</span>
                                @endif
                                @if ($researchWork->field_of_study)
                                    <span class="text-gray-400 dark:text-gray-600">&middot;</span>
                                    <span class="text-sm">{{ $researchWork->field_of_study }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex-shrink-0 flex flex-col items-end gap-2">
                            @if (auth()->check() && auth()->id() === $researchWork->user_id)
                                <a href="{{ route('research.edit', $researchWork) }}"
                                   class="px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="bx bx-edit mr-1"></i> Edit
                                </a>
                                @if ($researchWork->status === 'draft')
                                    <button type="button" data-submit-for-review
                                        class="px-3 py-1.5 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700 transition-colors">
                                        <i class="bx bx-send mr-1"></i> Submit for Review
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 sm:p-8">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wide mb-3">Abstract</h2>
                    <div class="prose dark:prose-invert max-w-none mb-6">
                        <div class="whitespace-pre-line text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $researchWork->description ?? 'No abstract available.' }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        @if ($researchWork->license_type)
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">License</span>
                                <p class="text-gray-900 dark:text-white font-medium">{{ ucwords(str_replace('_', ' ', $researchWork->license_type)) }}</p>
                            </div>
                        @endif
                        @if ($researchWork->citation)
                            <div class="sm:col-span-2">
                                <span class="text-gray-500 dark:text-gray-400">Citation</span>
                                <p class="text-gray-900 dark:text-white font-mono text-xs mt-1">{{ $researchWork->citation }}</p>
                            </div>
                        @endif
                    </div>

                    @if ($researchWork->file_url)
                        <div class="mt-6">
                            <a href="{{ $researchWork->file_url }}" target="_blank" rel="noopener"
                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
                                <i class="bx bx-download"></i> Download File
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reviews -->
            <div class="mt-6 bg-white dark:bg-gray-900 shadow-sm rounded-md border border-gray-200 dark:border-gray-800 p-6 sm:p-8">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="bx bx-clipboard mr-1 text-purple-500"></i> Reviews
                </h2>

                @auth
                    <form data-review-form class="mb-6 space-y-3">
                        <div>
                            <label for="review-status" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select id="review-status" name="status" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="changes_requested">Changes Requested</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label for="review-comments" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Comments</label>
                            <textarea id="review-comments" name="comments" rows="3" maxlength="5000" placeholder="Share your review comments..."
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"></textarea>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="review-blind" name="blind_review" class="rounded border-gray-300 dark:border-gray-700 text-purple-600">
                            <label for="review-blind" class="text-xs text-gray-600 dark:text-gray-400">Blind review</label>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md hover:bg-purple-700 transition-colors">
                                Submit Review
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                        <a href="{{ route('login') }}" class="text-purple-600 dark:text-purple-400 hover:underline">Log in</a> to leave a review.
                    </p>
                @endauth

                <div data-reviews-list class="space-y-4">
                    @forelse ($researchWork->reviews as $review)
                        <div class="flex items-start gap-3 py-3 border-b border-gray-100 dark:border-gray-800 last:border-0">
                            <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center text-white text-xs font-medium flex-shrink-0">
                                {{ strtoupper(substr(optional($review->reviewer)->first_name ?? 'U', 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $review->blind_review ? 'Anonymous reviewer' : (optional($review->reviewer)->first_name ?? 'Unknown') }}</span>
                                    <span class="px-2 py-0.5 text-2xs font-semibold rounded-full {{ $review->status === 'approved' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : ($review->status === 'rejected' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400') }}">{{ ucfirst(str_replace('_', ' ', $review->status)) }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                @if ($review->comments)
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">{{ $review->comments }}</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">No reviews yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Endorsement -->
            <div class="mt-6 bg-white dark:bg-gray-900 shadow-sm rounded-md border border-gray-200 dark:border-gray-800 p-6 sm:p-8">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="bx bx-badge-check mr-1 text-purple-500"></i> Endorsement
                </h2>

                @if ($researchWork->publicly_visible)
                    <div class="flex items-center gap-2 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg mb-4">
                        <i class="bx bx-check-circle text-green-600 dark:text-green-400 text-lg"></i>
                        <p class="text-sm text-green-800 dark:text-green-300">This research work has been endorsed and is publicly visible.</p>
                    </div>
                @else
                    <div class="flex items-center gap-2 p-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg mb-4">
                        <i class="bx bx-time text-amber-600 dark:text-amber-400 text-lg"></i>
                        <p class="text-sm text-amber-800 dark:text-amber-300">Not yet endorsed, this work stays private to its author until a supervisor endorses it.</p>
                    </div>
                @endif

                @auth
                    <form data-endorsement-form class="space-y-3">
                        <div>
                            <label for="endorsement-status" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Supervisor decision</label>
                            <select id="endorsement-status" name="status" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                                <option value="pending">Pending</option>
                                <option value="endorsed">Endorsed</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div>
                            <label for="endorsement-notes" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Notes</label>
                            <textarea id="endorsement-notes" name="notes" rows="2" maxlength="5000" placeholder="Optional notes for the author..."
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-md text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md hover:bg-purple-700 transition-colors">
                                Save Endorsement
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        <a href="{{ route('login') }}" class="text-purple-600 dark:text-purple-400 hover:underline">Log in</a> as a supervisor to endorse this work.
                    </p>
                @endauth

                @if ($researchWork->endorsements->isNotEmpty())
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800 space-y-3">
                        @foreach ($researchWork->endorsements as $endorsement)
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center text-white text-xs font-medium flex-shrink-0">
                                    {{ strtoupper(substr(optional($endorsement->supervisor)->first_name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ optional($endorsement->supervisor)->first_name ?? 'Unknown' }}</span>
                                        <span class="px-2 py-0.5 text-2xs font-semibold rounded-full {{ $endorsement->status === 'endorsed' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : ($endorsement->status === 'rejected' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400') }}">{{ ucfirst($endorsement->status) }}</span>
                                    </div>
                                    @if ($endorsement->notes)
                                        <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">{{ $endorsement->notes }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Comments -->
            <div class="mt-6 bg-white dark:bg-gray-900 shadow-sm rounded-md border border-gray-200 dark:border-gray-800 p-6 sm:p-8">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <i class="bx bx-comment mr-1"></i> Comments
                </h2>

                @auth
                    <form data-comment-form class="mb-6">
                        <textarea name="body" rows="3" required maxlength="1000" placeholder="Add a comment..."
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm"></textarea>
                        <div class="flex justify-end mt-2">
                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md hover:bg-purple-700 transition-colors">
                                Post Comment
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                        <a href="{{ route('login') }}" class="text-purple-600 dark:text-purple-400 hover:underline">Log in</a> to leave a comment.
                    </p>
                @endauth

                <div data-comments-list class="space-y-4">
                    @forelse ($researchWork->comments as $comment)
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
                        <p class="text-sm text-gray-500 dark:text-gray-400">No comments yet.</p>
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
    const container = document.getElementById('research-work-detail');
    if (container && window.ResearchWorkManager) {
        new ResearchWorkManager(container, {
            researchWorkUuid: container.getAttribute('data-research-work-uuid'),
            isAuthenticated: container.getAttribute('data-is-authenticated') === 'true',
        });
    }
});
</script>
@endsection
