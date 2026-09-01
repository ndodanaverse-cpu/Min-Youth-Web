<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryItem extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = [
        'caption',
        'image_url',
        'status',
        'sort_order',
    ];
}
