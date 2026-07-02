<?php
// app/Http/Controllers/TagController.php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of tags, optionally filtered by category.
     * Store/update/destroy are omitted for now, no admin taxonomy
     * management UI is in scope for this pass; tags are seeded and read
     * only from the application's perspective.
     */
    public function index(Request $request)
    {
        $query = Tag::query();

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        $tags = $query->orderBy('name')->get();

        return response()->json($tags);
    }
}
