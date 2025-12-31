<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;

class AboutContent extends Model
{
    protected $fillable = ['section', 'title', 'content', 'title_en', 'content_en', 'image', 'order', 'is_active'];

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('is_active', true);
        });
    }

    /**
     * Scope to include inactive content (for admin usage)
     */
    public function scopeWithInactive($query)
    {
        return $query->withoutGlobalScope('active');
    }
}
