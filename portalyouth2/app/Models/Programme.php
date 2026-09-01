<?php

namespace App\Models;

use App\Enums\ProgrammeCategory;
use App\Models\Concerns\PublishesContent;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Programme extends Model
{
    use HasUuids, PublishesContent, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'summary',
        'description',
        'icon',
        'image_url',
        'status',
        'is_featured',
        'sort_order',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'category' => ProgrammeCategory::class,
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function successStories(): HasMany
    {
        return $this->hasMany(SuccessStory::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Programme $programme) {
            if (empty($programme->slug)) {
                $programme->slug = Str::slug($programme->title);
            }
        });
    }
}
