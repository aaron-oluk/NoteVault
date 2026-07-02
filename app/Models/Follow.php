<?php
// app/Models/Follow.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Follow extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'follower_id',
        'followable_type',
        'followable_id',
    ];

    /**
     * Get the user who is following.
     */
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    /**
     * Get the followable model (User or Course).
     */
    public function followable()
    {
        return $this->morphTo();
    }
}
