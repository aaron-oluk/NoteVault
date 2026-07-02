<?php
// app/Models/Institution.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email_domain',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the users belonging to this institution.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the departments belonging to this institution.
     */
    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get the courses belonging to this institution.
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get the course units belonging to this institution.
     */
    public function courseUnits()
    {
        return $this->hasMany(CourseUnit::class);
    }

    /**
     * Get the resources belonging to this institution.
     */
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }

    /**
     * Get the research works belonging to this institution.
     */
    public function researchWorks()
    {
        return $this->hasMany(ResearchWork::class);
    }
}
