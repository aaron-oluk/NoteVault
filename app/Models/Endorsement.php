<?php
// app/Models/Endorsement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endorsement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'research_work_id',
        'supervisor_id',
        'status',
        'notes',
        'endorsed_at',
    ];

    protected $casts = [
        'endorsed_at' => 'datetime',
    ];

    /**
     * Get the research work this endorsement belongs to.
     */
    public function researchWork()
    {
        return $this->belongsTo(ResearchWork::class);
    }

    /**
     * Get the supervisor who gave this endorsement.
     */
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}
