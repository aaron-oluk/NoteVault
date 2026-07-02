<?php
// app/Http/Controllers/ResearchWorkController.php

namespace App\Http\Controllers;

use App\Models\ResearchWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResearchWorkController extends Controller
{
    /**
     * Display a listing of research works (Blade view). Publicly visible
     * works are shown to everyone; a user's own not yet visible works are
     * folded into their view as well.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = ResearchWork::with(['user', 'department'])
            ->where(function ($q) use ($user) {
                $q->where('publicly_visible', true);
                if ($user) {
                    $q->orWhere('user_id', $user->id);
                }
            });

        if ($user && $user->institution_id) {
            $query->where('institution_id', $user->institution_id);
        }

        if ($request->filled('field_of_study')) {
            $query->where('field_of_study', $request->string('field_of_study'));
        }
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }
        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->wantsJson()) {
            return response()->json($query->latest()->paginate(12));
        }

        $researchWorks = $query->latest()->paginate(12)->withQueryString();

        return view('research.index', compact('researchWorks'));
    }

    /**
     * Show the form for creating a new research work.
     */
    public function create()
    {
        return view('research.create');
    }

    /**
     * Store a newly created research work as a draft.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:20000',
            'field_of_study' => 'nullable|string|max:255',
            'license_type' => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'file_url' => 'nullable|url',
            'citation' => 'nullable|string|max:2000',
        ]);

        $researchWork = ResearchWork::create([
            'institution_id' => $user->institution_id,
            'department_id' => $validated['department_id'] ?? null,
            'user_id' => $user->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'field_of_study' => $validated['field_of_study'] ?? null,
            'license_type' => $validated['license_type'] ?? null,
            'status' => 'draft',
            'file_url' => $validated['file_url'] ?? null,
            'citation' => $validated['citation'] ?? null,
            'publicly_visible' => false,
        ]);

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json($researchWork, 201);
        }

        return redirect()->route('research.show', $researchWork)
            ->with('success', 'Research work created successfully!');
    }

    /**
     * Display the specified research work.
     */
    public function show(Request $request, ResearchWork $researchWork)
    {
        $researchWork->load(['user', 'department', 'reviews.reviewer', 'endorsements.supervisor', 'comments.user']);

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json($researchWork);
        }

        return view('research.show', compact('researchWork'));
    }

    /**
     * Show the form for editing the specified research work.
     */
    public function edit(ResearchWork $researchWork)
    {
        if (Auth::id() !== $researchWork->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('research.edit', compact('researchWork'));
    }

    /**
     * Update the specified research work.
     */
    public function update(Request $request, ResearchWork $researchWork)
    {
        if (Auth::id() !== $researchWork->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:20000',
            'field_of_study' => 'nullable|string|max:255',
            'license_type' => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'file_url' => 'nullable|url',
            'citation' => 'nullable|string|max:2000',
        ]);

        $researchWork->update($validated);

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json($researchWork->fresh());
        }

        return redirect()->route('research.show', $researchWork)
            ->with('success', 'Research work updated successfully!');
    }

    /**
     * Remove the specified research work.
     */
    public function destroy(ResearchWork $researchWork)
    {
        if (Auth::id() !== $researchWork->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $researchWork->delete();

        if (request()->wantsJson() || request()->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('research.index')
            ->with('success', 'Research work deleted successfully!');
    }

    /**
     * Transition a research work from draft to in_review.
     */
    public function submitForReview(ResearchWork $researchWork)
    {
        if (Auth::id() !== $researchWork->user_id) {
            return response()->json(['message' => 'Forbidden. You do not own this research work.'], 403);
        }

        if ($researchWork->status !== 'draft') {
            return response()->json(['message' => 'Only draft research works can be submitted for review.'], 409);
        }

        $researchWork->update(['status' => 'in_review']);

        return response()->json($researchWork->fresh());
    }
}
