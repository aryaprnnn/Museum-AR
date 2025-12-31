<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'image', 'model_3d', 'category', 'era', 'origin', 'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
