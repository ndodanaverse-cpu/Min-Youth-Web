<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'slug', 'code'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }
}
