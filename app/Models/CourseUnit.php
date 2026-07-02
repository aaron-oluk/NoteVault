<?php
// app/Models/CourseUnit.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'institution_id',
        'course_id',
        'name',
        'code',
        'semester',
    ];

    /**
     * Get the institution this course unit belongs to.
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Get the course this course unit belongs to.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the resources belonging to this course unit.
     */
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
}
