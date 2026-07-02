<?php
// app/Models/Tag.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
    ];

    /**
     * Get the resources tagged with this tag.
     */
    public function resources()
    {
        return $this->morphedByMany(Resource::class, 'taggable');
    }

    /**
     * Get the research works tagged with this tag.
     */
    public function researchWorks()
    {
        return $this->morphedByMany(ResearchWork::class, 'taggable');
    }
}
