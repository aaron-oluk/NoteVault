<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Engagement;
use App\Models\Follow;
use App\Models\Resource;
use App\Models\ResearchWork;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function dashboard(): View
    {
        $user = Auth::user();

        // Recent/recommended resources for the user's institution and course units.
        $recentResources = Resource::where('approved', true)
            ->when($user->institution_id, fn ($q) => $q->where('institution_id', $user->institution_id))
            ->latest()
            ->take(4)
            ->get();

        $courseUnitIds = $user->resources()->pluck('course_unit_id')->filter()->unique();
        $recommendedResources = Resource::where('approved', true)
            ->when($courseUnitIds->isNotEmpty(), fn ($q) => $q->whereIn('course_unit_id', $courseUnitIds))
            ->when($user->institution_id, fn ($q) => $q->where('institution_id', $user->institution_id))
            ->latest()
            ->take(4)
            ->get();

        // Latest content from followed lecturers, researchers, and courses.
        $followedUserIds = Follow::where('follower_id', $user->id)
            ->where('followable_type', User::class)
            ->pluck('followable_id');

        $followedContent = Resource::whereIn('user_id', $followedUserIds)
            ->where('approved', true)
            ->latest()
            ->take(5)
            ->get();

        $followedCreators = User::whereIn('id', $followedUserIds)->take(2)->get();

        // Researcher specific: own research works plus pending reviews/endorsements.
        $researchWorks = collect();
        $pendingReviews = collect();
        $pendingEndorsements = collect();

        if ($user->isResearcher()) {
            $researchWorks = $user->researchWorks()->latest()->take(5)->get();
            $pendingReviews = $user->reviews()->where('status', 'pending')->with('researchWork')->latest()->take(5)->get();
            $pendingEndorsements = $user->endorsements()->where('status', 'pending')->with('researchWork')->latest()->take(5)->get();
        }

        // Stats
        $resourcesUploaded = $user->resources()->count();
        $totalUpvotesReceived = Engagement::where('engageable_type', Resource::class)
            ->whereIn('engageable_id', $user->resources()->pluck('id'))
            ->where('type', 'upvote')
            ->count();
        $followingCount = $user->following()->count();

        $hour = now()->hour;
        $greeting = match (true) {
            $hour < 12 => 'Good morning',
            $hour < 17 => 'Good afternoon',
            default => 'Good evening',
        };

        return view('dashboard', compact(
            'user',
            'recentResources',
            'recommendedResources',
            'followedContent',
            'followedCreators',
            'researchWorks',
            'pendingReviews',
            'pendingEndorsements',
            'resourcesUploaded',
            'totalUpvotesReceived',
            'followingCount',
            'greeting'
        ));
    }

    /**
     * Display the settings page.
     */
    public function settings(): View
    {
        return view('settings.index');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        $user = $request->user();

        $resourcesUploaded = $user->resources()->count();
        $totalUpvotesReceived = Engagement::where('engageable_type', Resource::class)
            ->whereIn('engageable_id', $user->resources()->pluck('id'))
            ->where('type', 'upvote')
            ->count();
        $followingCount = $user->following()->count();

        $recentResources = Resource::where('approved', true)
            ->when($user->institution_id, fn ($q) => $q->where('institution_id', $user->institution_id))
            ->take(3)
            ->get();

        $followedCreators = User::whereIn('id', Follow::where('follower_id', $user->id)
            ->where('followable_type', User::class)
            ->pluck('followable_id'))
            ->take(3)
            ->get();

        return view('profile.show', compact(
            'user',
            'resourcesUploaded',
            'totalUpvotesReceived',
            'followingCount',
            'recentResources',
            'followedCreators'
        ));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
