<?php
// app/Http/Controllers/InstitutionController.php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InstitutionController extends Controller
{
    /**
     * Display a listing of institutions (Admin only).
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (! $user || ! $user->isAdmin()) {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }

        $institutions = Institution::withCount(['users', 'departments', 'courses'])
            ->latest()
            ->paginate(20);

        return response()->json($institutions);
    }

    /**
     * Store a newly created institution (Admin only).
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (! $user || ! $user->isAdmin()) {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email_domain' => 'required|string|max:255|unique:institutions,email_domain',
            'active' => 'boolean',
        ]);

        $institution = Institution::create([
            'name' => $validated['name'],
            'email_domain' => $validated['email_domain'],
            'active' => $validated['active'] ?? true,
        ]);

        return response()->json($institution, 201);
    }

    /**
     * Update the specified institution (Admin only).
     */
    public function update(Request $request, Institution $institution)
    {
        $user = Auth::user();
        if (! $user || ! $user->isAdmin()) {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email_domain' => ['sometimes', 'string', 'max:255', Rule::unique('institutions', 'email_domain')->ignore($institution->id)],
            'active' => 'sometimes|boolean',
        ]);

        $institution->update($validated);

        return response()->json($institution);
    }

    /**
     * Remove the specified institution (Admin only).
     */
    public function destroy(Institution $institution)
    {
        $user = Auth::user();
        if (! $user || ! $user->isAdmin()) {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }

        $institution->delete();

        return response()->json(null, 204);
    }
}
