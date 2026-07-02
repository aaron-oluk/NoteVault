<?php
// app/Http/Controllers/CommentController.php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Resource;
use App\Models\ResearchWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Retrieve all comments for a resource.
     */
    public function resourceIndex(Resource $resource)
    {
        return $this->indexFor($resource);
    }

    /**
     * Add a new comment to a resource.
     */
    public function resourceStore(Request $request, Resource $resource)
    {
        return $this->storeFor($request, $resource);
    }

    /**
     * Retrieve all comments for a research work.
     */
    public function researchWorkIndex(ResearchWork $researchWork)
    {
        return $this->indexFor($researchWork);
    }

    /**
     * Add a new comment to a research work.
     */
    public function researchWorkStore(Request $request, ResearchWork $researchWork)
    {
        return $this->storeFor($request, $researchWork);
    }

    /**
     * Delete a specific comment. Shared by both resource and research work routes.
     */
    public function destroy(Comment $comment)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if ($user->id !== $comment->user_id && ! $user->isAdmin()) {
            return response()->json(['message' => 'Forbidden. You do not own this comment or are not an administrator.'], 403);
        }

        $comment->delete();

        return response()->json(null, 204);
    }

    /**
     * Shared index logic for any commentable model.
     */
    protected function indexFor($commentable)
    {
        $comments = $commentable->comments()
            ->with('user:id,first_name,last_name')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($comments);
    }

    /**
     * Shared store logic for any commentable model.
     */
    protected function storeFor(Request $request, $commentable)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment = $commentable->comments()->create([
            'user_id' => $user->id,
            'body' => $request->input('body'),
        ]);

        $comment->load('user:id,first_name,last_name');

        return response()->json($comment, 201);
    }
}
