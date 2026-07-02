<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'institution_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the institution this user belongs to.
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Get the resources created by this user.
     */
    public function resources()
    {
        return $this->hasMany(Resource::class, 'user_id');
    }

    /**
     * Get the research works authored by this user.
     */
    public function researchWorks()
    {
        return $this->hasMany(ResearchWork::class, 'user_id');
    }

    /**
     * Get the comments made by this user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the engagement records (downloads, upvotes) made by this user.
     */
    public function engagements()
    {
        return $this->hasMany(Engagement::class);
    }

    /**
     * Get the reviews written by this user.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    /**
     * Get the endorsements given by this user as a supervisor.
     */
    public function endorsements()
    {
        return $this->hasMany(Endorsement::class, 'supervisor_id');
    }

    /**
     * Get the users, lecturers, researchers, or courses this user follows.
     */
    public function following()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    /**
     * Get the follow records where this user is the one being followed.
     */
    public function followers()
    {
        return $this->morphMany(Follow::class, 'followable');
    }

    /**
     * Check if the user is a student.
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * Check if the user is a lecturer.
     */
    public function isLecturer(): bool
    {
        return $this->role === 'lecturer';
    }

    /**
     * Check if the user is a researcher.
     */
    public function isResearcher(): bool
    {
        return $this->role === 'researcher';
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
