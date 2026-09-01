<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class NewsletterSubscription extends Model
{
    use HasUuids;

    protected $fillable = ['email', 'first_name', 'is_active', 'subscribed_at'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'subscribed_at' => 'datetime',
        ];
    }
}
