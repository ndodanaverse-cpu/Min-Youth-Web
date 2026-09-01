<?php

namespace App\Models;

use App\Models\Concerns\PublishesContent;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuccessStory extends Model
{
    use HasUuids, PublishesContent, SoftDeletes;

    protected $fillable = [
        'name',
        'age',
        'province_id',
        'programme_id',
        'role',
        'photo',
        'testimonial',
        'status',
        'is_featured',
        'sort_order',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class);
    }
}
