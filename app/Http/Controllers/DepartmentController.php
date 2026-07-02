<?php
// app/Http/Controllers/DepartmentController.php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments, scoped to the current user's
     * institution when authenticated.
     */
    public function index(Request $request)
    {
        $query = Department::withCount('courses');

        $user = Auth::user();
        if ($user && $user->institution_id) {
            $query->where('institution_id', $user->institution_id);
        } elseif ($request->filled('institution_id')) {
            $query->where('institution_id', $request->input('institution_id'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $departments = $query->orderBy('name')->paginate(20)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($departments);
        }

        return view('departments.index', compact('departments'));
    }

    /**
     * Display the specified department along with its courses.
     */
    public function show(Request $request, Department $department)
    {
        $department->load(['institution', 'courses.courseUnits']);

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json($department);
        }

        return view('departments.show', compact('department'));
    }
}
