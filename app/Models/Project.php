<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'project_category_id',
        'title',
        'slug',
        'location',
        'status',
        'image_path',
        'hero_image_path',
        'summary',
        'description',
        'facts',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'facts' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function media(): HasMany
    {
        return $this->hasMany(ProjectMedia::class)->orderBy('sort_order')->orderBy('id');
    }

    public function getThumbnailPathAttribute(): string
    {
        if ($this->slug === 'aurum-residences') {
            return '/images/luxury-homes/aurum-thumbnail.jpeg';
        }

        return $this->image_path ?: '/images/luxury-homes/landing-project-card.png';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
