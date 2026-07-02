<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResearchWork;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function home(): View
    {
        $user = Auth::user();
        $institutionId = $user->institution_id ?? null;

        // Recent and popular resources, scoped to the visitor's institution when known.
        $recentResources = Resource::with(['user', 'courseUnit'])
            ->where('approved', true)
            ->when($institutionId, fn ($q) => $q->where('institution_id', $institutionId))
            ->latest()
            ->limit(8)
            ->get();

        $popularResources = Resource::with(['user', 'courseUnit'])
            ->where('approved', true)
            ->when($institutionId, fn ($q) => $q->where('institution_id', $institutionId))
            ->withCount(['engagements as upvotes_count' => function ($q) {
                $q->where('type', 'upvote');
            }])
            ->orderByDesc('upvotes_count')
            ->limit(4)
            ->get();

        // Recently endorsed/published research works, kept visually separate
        // from the casual resources feed per the design principle.
        $recentResearchWorks = ResearchWork::with(['user', 'department'])
            ->where('publicly_visible', true)
            ->when($institutionId, fn ($q) => $q->where('institution_id', $institutionId))
            ->latest()
            ->limit(5)
            ->get();

        // Users the visitor follows, with their latest resources.
        $followedCreators = collect();
        if ($user) {
            $followedUserIds = $user->following()
                ->where('followable_type', User::class)
                ->pluck('followable_id');

            $followedCreators = User::whereIn('id', $followedUserIds)
                ->with('resources')
                ->limit(3)
                ->get();
        }

        return view('index', compact(
            'user',
            'recentResources',
            'popularResources',
            'recentResearchWorks',
            'followedCreators'
        ));
    }
}
