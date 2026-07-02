<?php
// app/Http/Controllers/ResourceController.php

namespace App\Http\Controllers;

use App\Models\Engagement;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResourceController extends Controller
{
    /**
     * Display a listing of resources (Blade view), scoped to the current
     * user's institution when authenticated.
     */
    public function index(Request $request)
    {
        $query = Resource::with(['user', 'courseUnit', 'comments'])
            ->where('approved', true);

        $user = Auth::user();
        if ($user && $user->institution_id) {
            $query->where('institution_id', $user->institution_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->string('type'));
        }
        if ($request->filled('course_unit_id')) {
            $query->where('course_unit_id', $request->input('course_unit_id'));
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->string('semester'));
        }
        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->string('academic_year'));
        }
        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // If API request (wants JSON), return JSON
        if ($request->wantsJson() || $request->expectsJson()) {
            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);

            $resources = $query->offset($offset)->limit($limit)->get();

            return response()->json($resources);
        }

        $resources = $query->latest()->paginate(12)->withQueryString();

        return view('resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource (Blade view).
     */
    public function create()
    {
        return view('resources.create');
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'type' => 'required|string|max:255',
            'course_unit_id' => 'nullable|exists:course_units,id',
            'semester' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,txt,rtf,ppt,pptx|max:10240',
            'file_url' => 'nullable|url',
        ]);

        $fileUrl = $validated['file_url'] ?? null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = $file->storeAs('resources', $filename, 'public');
            $fileUrl = Storage::url($path);
        }

        $resource = Resource::create([
            'institution_id' => $user->institution_id,
            'course_unit_id' => $validated['course_unit_id'] ?? null,
            'user_id' => $user->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'file_url' => $fileUrl,
            'semester' => $validated['semester'] ?? null,
            'academic_year' => $validated['academic_year'] ?? null,
            'status' => 'published',
            'approved' => true,
            'is_lecturer_content' => $user->isLecturer(),
        ]);

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json($resource, 201);
        }

        return redirect()->route('resources.show', $resource)
            ->with('success', 'Resource created successfully!');
    }

    /**
     * Display the specified resource (Blade view).
     */
    public function show(Request $request, Resource $resource)
    {
        $resource->load(['user', 'courseUnit', 'comments.user', 'versions']);

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json($resource);
        }

        $upvoteCount = $resource->engagements()->where('type', 'upvote')->count();
        $downloadCount = $resource->engagements()->where('type', 'download')->count();
        $hasUpvoted = false;

        if (Auth::check()) {
            $hasUpvoted = $resource->engagements()
                ->where('type', 'upvote')
                ->where('user_id', Auth::id())
                ->exists();
        }

        return view('resources.show', compact('resource', 'upvoteCount', 'downloadCount', 'hasUpvoted'));
    }

    /**
     * Show the form for editing the specified resource (Blade view).
     */
    public function edit(Resource $resource)
    {
        if (Auth::id() !== $resource->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('resources.edit', compact('resource'));
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Resource $resource)
    {
        if (Auth::id() !== $resource->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:10000',
            'type' => 'required|string|max:255',
            'course_unit_id' => 'nullable|exists:course_units,id',
            'semester' => 'nullable|string|max:255',
            'academic_year' => 'nullable|string|max:255',
            'changelog' => 'nullable|string|max:2000',
        ]);

        $resource->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'course_unit_id' => $validated['course_unit_id'] ?? $resource->course_unit_id,
            'semester' => $validated['semester'] ?? $resource->semester,
            'academic_year' => $validated['academic_year'] ?? $resource->academic_year,
        ]);

        // Lecturer content is versioned, log a changelog entry per update.
        if ($resource->is_lecturer_content) {
            $nextVersion = $resource->versions()->max('version_number') + 1;
            $resource->versions()->create([
                'user_id' => Auth::id(),
                'version_number' => $nextVersion,
                'changelog' => $validated['changelog'] ?? null,
                'file_url' => $resource->file_url,
            ]);
        }

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json($resource->fresh());
        }

        return redirect()->route('resources.show', $resource)
            ->with('success', 'Resource updated successfully!');
    }

    /**
     * Remove the specified resource.
     */
    public function destroy(Resource $resource)
    {
        if (Auth::id() !== $resource->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $resource->delete();

        if (request()->wantsJson() || request()->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('resources.index')
            ->with('success', 'Resource deleted successfully!');
    }

    // API Methods (for JavaScript interactions)

    /**
     * Approve a resource (Admin only).
     */
    public function approve(Resource $resource)
    {
        $resource->update(['approved' => true]);

        return response()->json(['message' => 'Resource approved successfully']);
    }

    /**
     * Get the current user's resources (API).
     */
    public function userResources()
    {
        $resources = Resource::where('user_id', Auth::id())
            ->with(['comments', 'courseUnit'])
            ->latest()
            ->get();

        return response()->json($resources);
    }

    /**
     * Upvote a resource (API).
     */
    public function upvote(Resource $resource)
    {
        $user = Auth::user();

        Engagement::firstOrCreate([
            'user_id' => $user->id,
            'engageable_type' => Resource::class,
            'engageable_id' => $resource->id,
            'type' => 'upvote',
        ]);

        return response()->json([
            'upvoted' => true,
            'upvote_count' => $this->getUpvoteCount($resource),
        ]);
    }

    /**
     * Remove an upvote from a resource (API).
     */
    public function removeUpvote(Resource $resource)
    {
        $user = Auth::user();

        Engagement::where([
            'user_id' => $user->id,
            'engageable_type' => Resource::class,
            'engageable_id' => $resource->id,
            'type' => 'upvote',
        ])->delete();

        return response()->json([
            'upvoted' => false,
            'upvote_count' => $this->getUpvoteCount($resource),
        ]);
    }

    /**
     * Get upvote count for a resource.
     */
    protected function getUpvoteCount(Resource $resource): int
    {
        return Engagement::where('engageable_type', Resource::class)
            ->where('engageable_id', $resource->id)
            ->where('type', 'upvote')
            ->count();
    }

    /**
     * Get the authenticated user's upvote/download status plus counts for a resource (API).
     */
    public function getUserStatus(Resource $resource)
    {
        $user = Auth::user();

        $hasUpvoted = false;
        $hasDownloaded = false;
        if ($user) {
            $hasUpvoted = Engagement::where('user_id', $user->id)
                ->where('engageable_type', Resource::class)
                ->where('engageable_id', $resource->id)
                ->where('type', 'upvote')
                ->exists();

            $hasDownloaded = Engagement::where('user_id', $user->id)
                ->where('engageable_type', Resource::class)
                ->where('engageable_id', $resource->id)
                ->where('type', 'download')
                ->exists();
        }

        return response()->json([
            'upvoted' => $hasUpvoted,
            'downloaded' => $hasDownloaded,
            'upvote_count' => $this->getUpvoteCount($resource),
            'download_count' => Engagement::where('engageable_type', Resource::class)
                ->where('engageable_id', $resource->id)
                ->where('type', 'download')
                ->count(),
        ]);
    }

    /**
     * Download the resource file. Logs an engagement of type download.
     * Absorbed from the old AcademicResourceController.
     */
    public function download(Resource $resource)
    {
        if (Auth::check()) {
            Engagement::firstOrCreate([
                'user_id' => Auth::id(),
                'engageable_type' => Resource::class,
                'engageable_id' => $resource->id,
                'type' => 'download',
            ]);
        }

        if ($resource->file_url) {
            if (filter_var($resource->file_url, FILTER_VALIDATE_URL)) {
                return redirect($resource->file_url);
            }

            $filePath = storage_path('app/public/'.ltrim($resource->file_url, '/'));
            if (file_exists($filePath)) {
                return response()->download($filePath);
            }

            $publicPath = public_path('storage/'.ltrim($resource->file_url, '/'));
            if (file_exists($publicPath)) {
                return response()->download($publicPath);
            }
        }

        $filename = str_replace(' ', '_', $resource->title).'.pdf';

        $content = 'Title: '.$resource->title."\n\n";
        $content .= 'Type: '.ucfirst(str_replace('_', ' ', $resource->type ?? 'Document'))."\n";
        $content .= 'Semester: '.($resource->semester ?? 'N/A')."\n";
        $content .= 'Academic Year: '.($resource->academic_year ?? 'N/A')."\n\n";
        $content .= "---\n\n";
        $content .= ($resource->description ?? 'No content available.');

        return response($content)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    /**
     * Upload or replace the file for an existing resource.
     * Absorbed from the old AcademicResourceController.
     */
    public function uploadFile(Request $request, Resource $resource)
    {
        if (Auth::id() !== $resource->user_id) {
            return response()->json(['message' => 'Forbidden. You do not own this resource.'], 403);
        }

        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,txt,rtf,ppt,pptx|max:10240',
        ]);

        $file = $request->file('file');
        $filename = time().'_'.$file->getClientOriginalName();
        $path = $file->storeAs('resources', $filename, 'public');

        $resource->update([
            'file_url' => Storage::url($path),
        ]);

        return response()->json([
            'message' => 'File uploaded successfully',
            'file_url' => Storage::url($path),
            'resource' => $resource->fresh(),
        ]);
    }
}
