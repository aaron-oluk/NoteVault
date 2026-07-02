<?php
// app/Models/Department.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'institution_id',
        'name',
        'code',
    ];

    /**
     * Get the institution this department belongs to.
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Get the courses belonging to this department.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get the research works belonging to this department.
     */
    public function researchWorks()
    {
        return $this->hasMany(ResearchWork::class);
    }
}
