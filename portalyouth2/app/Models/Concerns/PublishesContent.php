<?php

namespace App\Models\Concerns;

use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Builder;

trait PublishesContent
{
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', ContentStatus::Published->value);
    }

    public function isPublished(): bool
    {
        return ($this->status ?? null) === ContentStatus::Published->value;
    }
}
