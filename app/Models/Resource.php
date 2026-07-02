<?php
// app/Models/Resource.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Resource extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'institution_id',
        'course_unit_id',
        'user_id',
        'title',
        'description',
        'type',
        'file_url',
        'semester',
        'academic_year',
        'status',
        'approved',
        'is_lecturer_content',
    ];

    protected $casts = [
        'approved' => 'boolean',
        'is_lecturer_content' => 'boolean',
    ];

    /**
     * Boot the model and generate UUID on creation.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Get the institution this resource belongs to.
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Get the course unit this resource belongs to.
     */
    public function courseUnit()
    {
        return $this->belongsTo(CourseUnit::class);
    }

    /**
     * Get the user who created this resource.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the version history for this resource.
     */
    public function versions()
    {
        return $this->hasMany(ResourceVersion::class);
    }

    /**
     * Get the comments on this resource.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get the engagement records (downloads, upvotes) on this resource.
     */
    public function engagements()
    {
        return $this->morphMany(Engagement::class, 'engageable');
    }

    /**
     * Get the tags attached to this resource.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
