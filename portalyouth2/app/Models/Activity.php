<?php

namespace App\Models;

use App\Enums\ActivityType;
use App\Models\Concerns\PublishesContent;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Activity extends Model
{
    use HasUuids, PublishesContent, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'summary',
        'description',
        'venue',
        'location',
        'province_id',
        'starts_at',
        'ends_at',
        'capacity',
        'image_url',
        'status',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'type' => ActivityType::class,
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_featured' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (Activity $activity) {
            if (empty($activity->slug)) {
                $activity->slug = Str::slug($activity->title);
            }
        });
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function isUpcoming(): bool
    {
        return $this->starts_at !== null && $this->starts_at->isFuture();
    }
}
