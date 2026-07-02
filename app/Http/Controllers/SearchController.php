<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResearchWork;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $institutionId = $request->get('institution_id');
        $departmentId = $request->get('department_id');
        $courseId = $request->get('course_id');
        $semester = $request->get('semester');
        $fieldOfStudy = $request->get('field_of_study');

        $currentUser = Auth::user();
        if (! $institutionId && $currentUser) {
            $institutionId = $currentUser->institution_id;
        }

        $resources = collect();
        $researchWorks = collect();
        $people = collect();

        if ($query || $institutionId || $departmentId || $courseId || $semester || $fieldOfStudy) {
            $searchTerm = "%{$query}%";

            $resourcesQuery = Resource::with(['user', 'courseUnit'])
                ->where('approved', true)
                ->when($institutionId, fn ($q) => $q->where('institution_id', $institutionId))
                ->when($semester, fn ($q) => $q->where('semester', $semester))
                ->when($courseId, fn ($q) => $q->whereHas('courseUnit', fn ($cu) => $cu->where('course_id', $courseId)))
                ->when($query, function ($q) use ($searchTerm) {
                    $q->where(function ($sub) use ($searchTerm) {
                        $sub->where('title', 'like', $searchTerm)
                            ->orWhere('description', 'like', $searchTerm)
                            ->orWhereHas('tags', fn ($t) => $t->where('name', 'like', $searchTerm));
                    });
                });
            $resources = $resourcesQuery->limit(10)->get();

            $researchWorksQuery = ResearchWork::with(['user', 'department'])
                ->where('publicly_visible', true)
                ->when($institutionId, fn ($q) => $q->where('institution_id', $institutionId))
                ->when($departmentId, fn ($q) => $q->where('department_id', $departmentId))
                ->when($fieldOfStudy, fn ($q) => $q->where('field_of_study', $fieldOfStudy))
                ->when($query, function ($q) use ($searchTerm) {
                    $q->where(function ($sub) use ($searchTerm) {
                        $sub->where('title', 'like', $searchTerm)
                            ->orWhere('description', 'like', $searchTerm)
                            ->orWhere('field_of_study', 'like', $searchTerm)
                            ->orWhereHas('tags', fn ($t) => $t->where('name', 'like', $searchTerm));
                    });
                });
            $researchWorks = $researchWorksQuery->limit(10)->get();

            if ($query) {
                $people = User::whereIn('role', ['lecturer', 'researcher'])
                    ->when($institutionId, fn ($q) => $q->where('institution_id', $institutionId))
                    ->where(function ($q) use ($searchTerm) {
                        $q->where('first_name', 'like', $searchTerm)
                            ->orWhere('last_name', 'like', $searchTerm);
                    })
                    ->limit(10)
                    ->get();
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'query' => $query,
                'resources' => $resources,
                'research_works' => $researchWorks,
                'people' => $people,
            ]);
        }

        return view('search', compact('query', 'resources', 'researchWorks', 'people'));
    }
}
