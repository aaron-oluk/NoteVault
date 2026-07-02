<?php
// app/Models/ResourceVersion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceVersion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'resource_id',
        'user_id',
        'version_number',
        'changelog',
        'file_url',
    ];

    /**
     * Get the resource this version belongs to.
     */
    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Get the user who created this version.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
