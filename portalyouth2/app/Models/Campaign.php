<?php

namespace App\Models;

use App\Enums\CampaignType;
use App\Models\Concerns\PublishesContent;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Campaign extends Model
{
    use HasUuids, PublishesContent, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'is_flagship',
        'summary',
        'content',
        'hero_image',
        'stats',
        'videos',
        'support_services',
        'emergency_contacts',
        'status',
        'sort_order',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'type' => CampaignType::class,
            'is_flagship' => 'boolean',
            'stats' => 'array',
            'videos' => 'array',
            'support_services' => 'array',
            'emergency_contacts' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (Campaign $campaign) {
            if (empty($campaign->slug)) {
                $campaign->slug = Str::slug($campaign->title);
            }
        });
    }
}
