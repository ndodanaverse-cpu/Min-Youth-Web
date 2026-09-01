<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'national_id',
        'date_of_birth',
        'gender',
        'province_id',
        'district_id',
        'education_level',
        'employment_status',
        'occupation',
        'about',
        'interests',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'interests' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function age(): int
    {
        return $this->date_of_birth->age;
    }
}
