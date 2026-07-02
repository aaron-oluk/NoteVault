<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of lecturers and researchers.
     */
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['lecturer', 'researcher'])
            ->withCount(['resources', 'researchWorks']);

        $currentUser = Auth::user();
        if ($currentUser && $currentUser->institution_id) {
            $query->where('institution_id', $currentUser->institution_id);
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->string('role'));
        }

        $sort = $request->get('sort', 'popular');
        switch ($sort) {
            case 'newest':
                $query->latest();
                break;
            case 'most_resources':
                $query->orderBy('resources_count', 'desc');
                break;
            case 'popular':
            default:
                $query->withCount('followers')->orderBy('followers_count', 'desc');
                break;
        }

        $people = $query->paginate(12)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($people);
        }

        return view('creators.index', compact('people'));
    }

    /**
     * Follow another user (at minimum). Supporting following a Course is a
     * nice to have per the plan; not wired up here since there is no
     * dedicated course follow route yet.
     */
    public function follow(User $user)
    {
        $follower = Auth::user();
        if (! $follower) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if ($follower->id === $user->id) {
            return response()->json(['message' => 'You cannot follow yourself.'], 400);
        }

        $exists = Follow::where('follower_id', $follower->id)
            ->where('followable_type', User::class)
            ->where('followable_id', $user->id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Already following this user.'], 409);
        }

        Follow::create([
            'follower_id' => $follower->id,
            'followable_type' => User::class,
            'followable_id' => $user->id,
        ]);

        return response()->json(['message' => 'Successfully followed user.'], 200);
    }

    /**
     * Unfollow another user.
     */
    public function unfollow(User $user)
    {
        $follower = Auth::user();
        if (! $follower) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $deleted = Follow::where('follower_id', $follower->id)
            ->where('followable_type', User::class)
            ->where('followable_id', $user->id)
            ->delete();

        if (! $deleted) {
            return response()->json(['message' => 'Not following this user.'], 409);
        }

        return response()->json(['message' => 'Successfully unfollowed user.'], 200);
    }

    /**
     * Retrieve a list of users who are following a specific user.
     */
    public function followers(User $user)
    {
        $followers = Follow::where('followable_type', User::class)
            ->where('followable_id', $user->id)
            ->with('follower:id,first_name,last_name,email')
            ->get()
            ->pluck('follower');

        return response()->json($followers);
    }

    /**
     * Retrieve the users that the currently authenticated user is following.
     */
    public function following(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $following = $user->following()
            ->where('followable_type', User::class)
            ->with('followable')
            ->get()
            ->pluck('followable');

        return response()->json($following);
    }

    /**
     * Check if the authenticated user is following a specific user.
     */
    public function followingStatus(User $user)
    {
        $currentUser = Auth::user();
        if (! $currentUser) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $isFollowing = Follow::where('follower_id', $currentUser->id)
            ->where('followable_type', User::class)
            ->where('followable_id', $user->id)
            ->exists();

        return response()->json(['isFollowing' => $isFollowing]);
    }

    /**
     * Display a lecturer or researcher's public profile page.
     */
    public function showCreator(User $user)
    {
        $creator = User::withCount(['resources', 'researchWorks'])
            ->find($user->id);

        $resources = $user->resources()->where('approved', true)->latest()->paginate(12);
        $researchWorks = $user->researchWorks()->where('publicly_visible', true)->latest()->get();

        $followerCount = Follow::where('followable_type', User::class)
            ->where('followable_id', $user->id)
            ->count();

        $followingCount = $user->following()->count();

        $isFollowing = false;
        if (Auth::check()) {
            $isFollowing = Follow::where('follower_id', Auth::id())
                ->where('followable_type', User::class)
                ->where('followable_id', $user->id)
                ->exists();
        }

        return view('profile.creator', compact(
            'creator',
            'resources',
            'researchWorks',
            'followerCount',
            'followingCount',
            'isFollowing'
        ));
    }

    /**
     * Get current authenticated user data (API).
     */
    public function currentUser()
    {
        $user = Auth::user();

        return response()->json([
            'user_id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'role' => $user->role,
            'institution_id' => $user->institution_id,
        ]);
    }
}
