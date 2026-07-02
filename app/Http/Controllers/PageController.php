<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseUnit;
use App\Models\Institution;
use App\Models\Resource;
use App\Models\ResearchWork;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the marketing landing page for guests. Authenticated users are
     * sent straight to their dashboard, which is the one page with the app
     * sidebar; the rest of the platform's features live behind login.
     */
    public function home(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $institutionCount = Institution::count();
        $courseUnitCount = CourseUnit::count();
        $resourceCount = Resource::count();
        $researchWorkCount = ResearchWork::count();

        // A single real course with published resources, used as a live
        // preview of the browse hierarchy instead of fabricated example data.
        $demoCourse = Course::with(['institution', 'department', 'courseUnits.resources' => function ($q) {
            $q->where('approved', true)->latest();
        }])
            ->whereHas('courseUnits.resources', fn ($q) => $q->where('approved', true))
            ->withCount('courseUnits')
            ->inRandomOrder()
            ->first();

        return view('welcome', compact(
            'institutionCount',
            'courseUnitCount',
            'resourceCount',
            'researchWorkCount',
            'demoCourse'
        ));
    }
}
