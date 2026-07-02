<?php
// app/Http/Controllers/EndorsementController.php

namespace App\Http\Controllers;

use App\Models\ResearchWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EndorsementController extends Controller
{
    /**
     * Create or update a supervisor's endorsement decision for a research
     * work. When the decision is set to endorsed, flip the parent
     * ResearchWork's publicly_visible flag to true, per the plan.
     */
    public function store(Request $request, ResearchWork $researchWork)
    {
        $user = Auth::user();
        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['pending', 'endorsed', 'rejected'])],
            'notes' => 'nullable|string|max:5000',
        ]);

        $endorsement = $researchWork->endorsements()->updateOrCreate(
            ['supervisor_id' => $user->id],
            [
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
                'endorsed_at' => $validated['status'] === 'endorsed' ? now() : null,
            ]
        );

        if ($validated['status'] === 'endorsed') {
            $researchWork->update(['publicly_visible' => true]);
        }

        return response()->json($endorsement->fresh(), $endorsement->wasRecentlyCreated ? 201 : 200);
    }
}
