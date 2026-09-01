<?php

namespace App\Models;

use App\Enums\OpportunityCategory;
use App\Models\Concerns\PublishesContent;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Opportunity extends Model
{
    use HasUuids, PublishesContent, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'summary',
        'description',
        'eligibility',
        'funding_amount',
        'organizer',
        'province_id',
        'district_id',
        'image_url',
        'apply_url',
        'deadline_at',
        'status',
        'is_featured',
        'created_by',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'category' => OpportunityCategory::class,
            'deadline_at' => 'datetime',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (Opportunity $opportunity) {
            if (empty($opportunity->slug)) {
                $opportunity->slug = Str::slug($opportunity->title);
            }
        });
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(OpportunityApplication::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isClosed(): bool
    {
        return $this->deadline_at !== null && $this->deadline_at->isPast();
    }

    public function isOpen(): bool
    {
        return $this->isPublished() && ! $this->isClosed();
    }
}
