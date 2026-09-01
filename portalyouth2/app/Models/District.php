<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class District extends Model
{
    use HasUuids;

    protected $fillable = ['province_id', 'name', 'slug'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
