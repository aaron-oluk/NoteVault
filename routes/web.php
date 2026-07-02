<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EndorsementController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResearchWorkController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public pages
Route::get('/', [PageController::class, 'home'])->name('index');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search');

// People (lecturers and researchers directory)
Route::get('/creators', [UserController::class, 'index'])->name('creators.index');

// Resources (formerly poetry/academics)
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/create', [ResourceController::class, 'create'])->middleware('auth')->name('resources.create');
Route::post('/resources', [ResourceController::class, 'store'])->middleware('auth')->name('resources.store');
Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('resources.show');
Route::get('/resources/{resource}/edit', [ResourceController::class, 'edit'])->middleware('auth')->name('resources.edit');
Route::put('/resources/{resource}', [ResourceController::class, 'update'])->middleware('auth')->name('resources.update');
Route::get('/resources/{resource}/download', [ResourceController::class, 'download'])->name('resources.download');

// Departments
Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');

// Courses
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

// Research works
Route::get('/research', [ResearchWorkController::class, 'index'])->name('research.index');
Route::get('/research/create', [ResearchWorkController::class, 'create'])->middleware('auth')->name('research.create');
Route::post('/research', [ResearchWorkController::class, 'store'])->middleware('auth')->name('research.store');
Route::get('/research/{researchWork}', [ResearchWorkController::class, 'show'])->name('research.show');
Route::get('/research/{researchWork}/edit', [ResearchWorkController::class, 'edit'])->middleware('auth')->name('research.edit');
Route::put('/research/{researchWork}', [ResearchWorkController::class, 'update'])->middleware('auth')->name('research.update');

// API - Current user
Route::get('/api/user', [UserController::class, 'currentUser'])->middleware('auth')->name('api.user');

// Public API routes (no auth required)
Route::get('/api/config/frontend', [ConfigController::class, 'getFrontendConfig'])->name('api.config.frontend');
Route::get('/api/config/environment', [ConfigController::class, 'getEnvironmentConfig'])->name('api.config.environment');
Route::get('/api/resources', [ResourceController::class, 'index'])->name('api.resources.index');
Route::get('/api/research-works', [ResearchWorkController::class, 'index'])->name('api.research-works.index');
Route::get('/api/people/featured', [UserController::class, 'index'])->name('api.people.featured');
Route::get('/api/tags', [TagController::class, 'index'])->name('api.tags.index');

// Authentication API Routes
Route::post('/api/register', [RegisteredUserController::class, 'store'])->middleware('guest')->name('api.register');
Route::post('/api/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest')->name('api.login');
Route::post('/api/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest')->name('api.password.email');
Route::post('/api/reset-password', [NewPasswordController::class, 'store'])->middleware('guest')->name('api.password.store');
Route::get('/api/verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['auth', 'signed', 'throttle:6,1'])->name('api.verification.verify');
Route::post('/api/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['auth', 'throttle:6,1'])->name('api.verification.send');
Route::post('/api/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('api.logout');

// Protected Routes (require authentication)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Pages
    Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'usersPage'])->name('admin.users');
    Route::get('/admin/reports', [AdminController::class, 'reportsPage'])->name('admin.reports');

    // Notifications API
    Route::get('/api/notifications', [AdminController::class, 'getNotifications'])->name('api.notifications');
    Route::post('/api/notifications/{id}/read', [AdminController::class, 'markNotificationRead'])->name('api.notifications.read');
    Route::post('/api/notifications/read-all', [AdminController::class, 'markAllNotificationsRead'])->name('api.notifications.read-all');

    // Creator Profile
    Route::get('/creators/{user}', [UserController::class, 'showCreator'])->name('profile.creator');

    // Settings
    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings.index');
    Route::patch('/settings/profile', [ProfileController::class, 'update'])->name('settings.profile.update');
    Route::patch('/settings/password', [ProfileController::class, 'updatePassword'])->name('settings.password.update');

    // API-style routes (returning JSON) - Authenticated routes
    // Resources
    Route::get('/api/resources/user', [ResourceController::class, 'userResources'])->name('api.resources.user');
    Route::post('/api/resources', [ResourceController::class, 'store'])->name('api.resources.store');
    Route::patch('/api/resources/{resource}', [ResourceController::class, 'update'])->name('api.resources.update');
    Route::get('/api/resources/{resource}', [ResourceController::class, 'show'])->name('api.resources.show');
    Route::delete('/api/resources/{resource}', [ResourceController::class, 'destroy'])->name('api.resources.destroy');
    Route::post('/api/resources/{resource}/upvote', [ResourceController::class, 'upvote'])->name('api.resources.upvote');
    Route::post('/api/resources/{resource}/remove-upvote', [ResourceController::class, 'removeUpvote'])->name('api.resources.remove-upvote');
    Route::get('/api/resources/{resource}/user-status', [ResourceController::class, 'getUserStatus'])->name('api.resources.user-status');
    Route::post('/api/resources/{resource}/upload-file', [ResourceController::class, 'uploadFile'])->name('api.resources.upload-file');

    // Resource Comments
    Route::get('/api/resources/{resource}/comments', [CommentController::class, 'resourceIndex'])->name('api.resources.comments.index');
    Route::post('/api/resources/{resource}/comments', [CommentController::class, 'resourceStore'])->name('api.resources.comments.store');

    // Research Works
    Route::post('/api/research-works', [ResearchWorkController::class, 'store'])->name('api.research-works.store');
    Route::get('/api/research-works/{researchWork}', [ResearchWorkController::class, 'show'])->name('api.research-works.show');
    Route::patch('/api/research-works/{researchWork}', [ResearchWorkController::class, 'update'])->name('api.research-works.update');
    Route::delete('/api/research-works/{researchWork}', [ResearchWorkController::class, 'destroy'])->name('api.research-works.destroy');
    Route::post('/api/research-works/{researchWork}/submit-for-review', [ResearchWorkController::class, 'submitForReview'])->name('api.research-works.submit-for-review');

    // Research Work Comments
    Route::get('/api/research-works/{researchWork}/comments', [CommentController::class, 'researchWorkIndex'])->name('api.research-works.comments.index');
    Route::post('/api/research-works/{researchWork}/comments', [CommentController::class, 'researchWorkStore'])->name('api.research-works.comments.store');

    // Comments (shared destroy, works for comments on either a resource or a research work)
    Route::delete('/api/comments/{comment}', [CommentController::class, 'destroy'])->name('api.comments.destroy');

    // Reviews
    Route::get('/api/research-works/{researchWork}/reviews', [ReviewController::class, 'index'])->name('api.research-works.reviews.index');
    Route::post('/api/research-works/{researchWork}/reviews', [ReviewController::class, 'store'])->name('api.research-works.reviews.store');
    Route::patch('/api/research-works/{researchWork}/reviews/{review}', [ReviewController::class, 'update'])->name('api.research-works.reviews.update');

    // Endorsements
    Route::post('/api/research-works/{researchWork}/endorsements', [EndorsementController::class, 'store'])->name('api.research-works.endorsements.store');

    // People & Following
    Route::post('/api/people/{user}/follow', [UserController::class, 'follow'])->name('api.people.follow');
    Route::post('/api/people/{user}/unfollow', [UserController::class, 'unfollow'])->name('api.people.unfollow');
    Route::get('/api/user/following', [UserController::class, 'following'])->name('api.user.following');
    Route::get('/api/people/{user}/following-status', [UserController::class, 'followingStatus'])->name('api.people.following-status');
    Route::get('/api/people/{user}/followers', [UserController::class, 'followers'])->name('api.people.followers');
});

// Admin Routes
Route::middleware(['auth'])->prefix('api/admin')->group(function () {
    Route::get('users', [AdminController::class, 'getUsers'])->name('api.admin.users');
    Route::patch('users/{user}', [AdminController::class, 'updateUser'])->name('api.admin.users.update');
    Route::delete('users/{user}', [AdminController::class, 'deleteUser'])->name('api.admin.users.delete');

    Route::get('pending/resources', [AdminController::class, 'getPendingResources'])->name('api.admin.pending.resources');
    Route::patch('resources/{resource}/approve', [AdminController::class, 'approveResource'])->name('api.admin.resources.approve');
    Route::delete('resources/{resource}', [AdminController::class, 'deleteResource'])->name('api.admin.resources.delete');

    Route::get('pending/research-works', [AdminController::class, 'getPendingResearchWorks'])->name('api.admin.pending.research-works');
    Route::patch('research-works/{researchWork}/approve', [AdminController::class, 'approveResearchWork'])->name('api.admin.research-works.approve');
    Route::delete('research-works/{researchWork}', [AdminController::class, 'deleteResearchWork'])->name('api.admin.research-works.delete');

    Route::get('institutions', [InstitutionController::class, 'index'])->name('api.admin.institutions.index');
    Route::post('institutions', [InstitutionController::class, 'store'])->name('api.admin.institutions.store');
    Route::patch('institutions/{institution}', [InstitutionController::class, 'update'])->name('api.admin.institutions.update');
    Route::delete('institutions/{institution}', [InstitutionController::class, 'destroy'])->name('api.admin.institutions.delete');
});

// Auth Routes
require __DIR__.'/auth.php';
