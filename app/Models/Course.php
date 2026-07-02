<?php
// app/Models/Course.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'institution_id',
        'department_id',
        'name',
        'code',
    ];

    /**
     * Get the institution this course belongs to.
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Get the department this course belongs to.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the course units belonging to this course.
     */
    public function courseUnits()
    {
        return $this->hasMany(CourseUnit::class);
    }

    /**
     * Get the follows targeting this course.
     */
    public function follows()
    {
        return $this->morphMany(Follow::class, 'followable');
    }
}
