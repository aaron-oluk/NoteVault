<?php
// app/Models/ResearchWork.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ResearchWork extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'institution_id',
        'department_id',
        'user_id',
        'title',
        'description',
        'field_of_study',
        'license_type',
        'status',
        'file_url',
        'citation',
        'publicly_visible',
    ];

    protected $casts = [
        'publicly_visible' => 'boolean',
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
     * Get the institution this research work belongs to.
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Get the department this research work belongs to.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the user who authored this research work.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reviews for this research work.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the endorsements for this research work.
     */
    public function endorsements()
    {
        return $this->hasMany(Endorsement::class);
    }

    /**
     * Get the comments on this research work.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get the engagement records (downloads, upvotes) on this research work.
     */
    public function engagements()
    {
        return $this->morphMany(Engagement::class, 'engageable');
    }

    /**
     * Get the tags attached to this research work.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
