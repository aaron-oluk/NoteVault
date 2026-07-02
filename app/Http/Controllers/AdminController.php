<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resource;
use App\Models\ResearchWork;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // All methods in this controller should implicitly be protected by an 'isAdmin' middleware
    // or a policy that checks for admin role.

    /**
     * Show the admin dashboard.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Admin access required.');
        }

        $status = $request->query('status', 'all');
        $type = $request->query('type', 'all');
        $perPage = 15;

        $applyStatus = function ($query) use ($status) {
            if ($status === 'pending') {
                $query->where('approved', false);
            } elseif ($status === 'approved') {
                $query->where('approved', true);
            }
        };

        $contentItems = collect();

        if ($type === 'all' || $type === 'resource') {
            $resourcesQuery = Resource::query()->with('user:id,first_name,last_name');
            $applyStatus($resourcesQuery);

            $contentItems = $contentItems->concat(
                $resourcesQuery->latest()
                    ->get()
                    ->map(function ($resource) {
                        return [
                            'uuid' => $resource->uuid,
                            'title' => $resource->title,
                            'author' => optional($resource->user)->first_name ?? 'Unknown',
                            'type' => 'resource',
                            'status' => $resource->approved ? 'approved' : 'pending',
                            'created_at' => $resource->created_at,
                            'model' => $resource,
                        ];
                    })
            );
        }

        if ($type === 'all' || $type === 'research_work') {
            $researchWorksQuery = ResearchWork::query()->with('user:id,first_name,last_name');
            if ($status === 'pending') {
                $researchWorksQuery->where('status', 'in_review');
            } elseif ($status === 'approved') {
                $researchWorksQuery->where('publicly_visible', true);
            }

            $contentItems = $contentItems->concat(
                $researchWorksQuery->latest()
                    ->get()
                    ->map(function ($researchWork) {
                        return [
                            'uuid' => $researchWork->uuid,
                            'title' => $researchWork->title,
                            'author' => optional($researchWork->user)->first_name ?? 'Unknown',
                            'type' => 'research_work',
                            'status' => $researchWork->publicly_visible ? 'approved' : 'pending',
                            'created_at' => $researchWork->created_at,
                            'model' => $researchWork,
                        ];
                    })
            );
        }

        $contentItems = $contentItems
            ->sortByDesc('created_at')
            ->values();

        // Paginate the collection
        $currentPage = $request->query('page', 1);
        $contentItemsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $contentItems->forPage($currentPage, $perPage),
            $contentItems->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $stats = [
            'total_users' => User::count(),
            'active_contributors' => User::where('role', '!=', 'admin')->count(),
            'pending_resources' => Resource::where('approved', false)->count(),
            'pending_research_works' => ResearchWork::where('status', 'in_review')->count(),
            'pending_submissions' => Resource::where('approved', false)->count() + ResearchWork::where('status', 'in_review')->count(),
        ];

        return view('admin.dashboard', [
            'stats' => $stats,
            'contentItems' => $contentItemsPaginated,
            'statusFilter' => $status,
            'typeFilter' => $type,
        ]);
    }

    /**
     * Retrieve a list of all registered users.
     */
    public function getUsers()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }
        // Exclude sensitive data like password hash
        $users = \App\Models\User::all(['id', 'first_name', 'last_name', 'email', 'role', 'institution_id', 'created_at']);
        return response()->json($users);
    }

    /**
     * Update a user's information.
     */
    public function updateUser(Request $request, User $user)
    {
        $currentUser = Auth::user();
        if (!$currentUser || $currentUser->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }

        $validatedData = $request->validate([
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['sometimes', 'string', Rule::in(['student', 'lecturer', 'researcher', 'admin'])],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'], // 'confirmed' checks for password_confirmation
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json($user->only(['id', 'first_name', 'last_name', 'email', 'role']));
    }

    /**
     * Delete a user account.
     */
    public function deleteUser(User $user)
    {
        $currentUser = Auth::user();
        if (!$currentUser || $currentUser->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }

        if ($currentUser->id === $user->id) {
            return response()->json(['message' => 'Admins cannot delete their own account via this endpoint.'], 403);
        }

        $user->delete();
        return response()->json(null, 204);
    }

    /**
     * Retrieve a list of resources that are awaiting administrative approval.
     */
    public function getPendingResources()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }
        $resources = Resource::where('approved', false)->get();
        return response()->json($resources);
    }

    /**
     * Approve a resource.
     */
    public function approveResource(Resource $resource)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }
        $resource->approved = true;
        $resource->save();
        return response()->json($resource);
    }

    /**
     * Delete a resource.
     * Note: ResourceController also has a destroy method, this is for admin to delete any resource.
     */
    public function deleteResource(Resource $resource)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }
        $resource->delete();
        return response()->json(null, 204);
    }

    /**
     * Retrieve a list of research works that are awaiting administrative approval.
     */
    public function getPendingResearchWorks()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }
        $researchWorks = ResearchWork::where('status', 'in_review')->get();
        return response()->json($researchWorks);
    }

    /**
     * Approve a research work (marks it publicly visible directly, bypassing
     * the normal endorsement flow, for admin moderation purposes).
     */
    public function approveResearchWork(ResearchWork $researchWork)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }
        $researchWork->update(['status' => 'published', 'publicly_visible' => true]);
        return response()->json($researchWork);
    }

    /**
     * Delete a research work.
     */
    public function deleteResearchWork(ResearchWork $researchWork)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden. Admin access required.'], 403);
        }
        $researchWork->delete();
        return response()->json(null, 204);
    }

    /**
     * Show the admin users management page.
     */
    public function usersPage(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Admin access required.');
        }

        $search = $request->query('search');
        $role = $request->query('role', 'all');

        $usersQuery = User::query()
            ->select('id', 'first_name', 'last_name', 'email', 'role', 'institution_id', 'created_at')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($role !== 'all', function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->latest();

        $users = $usersQuery->paginate(20);

        $stats = [
            'total_users' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'lecturers' => User::where('role', 'lecturer')->count(),
            'researchers' => User::where('role', 'researcher')->count(),
            'students' => User::where('role', 'student')->count(),
        ];

        return view('admin.users', compact('users', 'stats', 'search', 'role'));
    }

    /**
     * Show the admin reports and analytics page.
     */
    public function reportsPage(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Admin access required.');
        }

        $period = $request->query('period', '30');
        $startDate = now()->subDays((int)$period);

        // User growth
        $userGrowth = User::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Content stats
        $contentStats = [
            'total_resources' => Resource::count(),
            'new_resources' => Resource::where('created_at', '>=', $startDate)->count(),
            'pending_resources' => Resource::where('approved', false)->count(),
            'total_research_works' => ResearchWork::count(),
            'new_research_works' => ResearchWork::where('created_at', '>=', $startDate)->count(),
            'pending_research_works' => ResearchWork::where('status', 'in_review')->count(),
        ];

        // Top contributors - use subqueries for PostgreSQL compatibility
        $topContributors = User::withCount(['resources', 'researchWorks'])
            ->whereHas('resources')
            ->orWhereHas('researchWorks')
            ->get()
            ->sortByDesc(fn($user) => $user->resources_count + $user->research_works_count)
            ->take(10)
            ->values();

        return view('admin.reports', compact(
            'period',
            'userGrowth',
            'contentStats',
            'topContributors'
        ));
    }

    /**
     * Get notifications for the current user.
     */
    public function getNotifications(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $limit = $request->query('limit', 10);
        $unreadOnly = $request->query('unread_only', false);

        $query = Notification::where('user_id', $user->id)
            ->orderByDesc('created_at');

        if ($unreadOnly) {
            $query->unread();
        }

        $notifications = $query->take($limit)->get();
        $unreadCount = Notification::where('user_id', $user->id)->unread()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markNotificationRead($id)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $notification = Notification::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$notification) {
            return response()->json(['message' => 'Notification not found.'], 404);
        }

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllNotificationsRead()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
