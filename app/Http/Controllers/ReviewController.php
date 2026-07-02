<?php
// app/Http/Controllers/ReviewController.php

namespace App\Http\Controllers;

use App\Models\ResearchWork;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{
    /**
     * Retrieve all reviews for a research work.
     */
    public function index(ResearchWork $researchWork)
    {
        $reviews = $researchWork->reviews()->with('reviewer:id,first_name,last_name')->latest()->get();

        return response()->json($reviews);
    }

    /**
     * Add a new review to a research work. Reviewer must be authenticated.
     */
    public function store(Request $request, ResearchWork $researchWork)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['pending', 'approved', 'changes_requested', 'rejected'])],
            'comments' => 'nullable|string|max:5000',
            'blind_review' => 'boolean',
        ]);

        $review = $researchWork->reviews()->create([
            'reviewer_id' => $user->id,
            'status' => $validated['status'],
            'comments' => $validated['comments'] ?? null,
            'blind_review' => $validated['blind_review'] ?? false,
        ]);

        return response()->json($review->load('reviewer:id,first_name,last_name'), 201);
    }

    /**
     * Update an existing review. Only the reviewer who wrote it may update it.
     */
    public function update(Request $request, ResearchWork $researchWork, Review $review)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if ($user->id !== $review->reviewer_id && ! $user->isAdmin()) {
            return response()->json(['message' => 'Forbidden. You do not own this review.'], 403);
        }

        $validated = $request->validate([
            'status' => ['sometimes', 'string', Rule::in(['pending', 'approved', 'changes_requested', 'rejected'])],
            'comments' => 'nullable|string|max:5000',
            'blind_review' => 'boolean',
        ]);

        $review->update($validated);

        return response()->json($review->fresh());
    }
}
