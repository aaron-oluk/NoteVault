<?php
// app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'research_work_id',
        'reviewer_id',
        'status',
        'comments',
        'blind_review',
    ];

    protected $casts = [
        'blind_review' => 'boolean',
    ];

    /**
     * Get the research work this review belongs to.
     */
    public function researchWork()
    {
        return $this->belongsTo(ResearchWork::class);
    }

    /**
     * Get the user who wrote this review.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
