<?php
// app/Models/Comment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'commentable_type',
        'commentable_id',
        'body',
    ];

    /**
     * Get the user who made this comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the commentable model (Resource or ResearchWork).
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
