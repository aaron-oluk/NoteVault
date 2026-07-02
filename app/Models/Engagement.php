<?php
// app/Models/Engagement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Engagement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'engageable_type',
        'engageable_id',
        'type',
    ];

    /**
     * Get the user who performed this engagement.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the engageable model (Resource or ResearchWork).
     */
    public function engageable()
    {
        return $this->morphTo();
    }
}
