<?php
// app/Http/Controllers/CourseController.php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of courses, scoped to the current user's
     * institution when authenticated.
     */
    public function index(Request $request)
    {
        $query = Course::with('department')->withCount('courseUnits');

        $user = Auth::user();
        if ($user && $user->institution_id) {
            $query->where('institution_id', $user->institution_id);
        } elseif ($request->filled('institution_id')) {
            $query->where('institution_id', $request->input('institution_id'));
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $courses = $query->orderBy('name')->paginate(20)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($courses);
        }

        return view('courses.index', compact('courses'));
    }

    /**
     * Display the specified course, surfacing its course units and
     * each unit's resources.
     */
    public function show(Request $request, Course $course)
    {
        $course->load(['institution', 'department', 'courseUnits.resources' => function ($query) {
            $query->where('approved', true)->latest();
        }]);

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json($course);
        }

        return view('courses.show', compact('course'));
    }
}
