<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'image',
        'title_fr',
        'title_ar',
        'desc_fr',
        'desc_ar',
        'phase',
        'content_fr',
        'content_ar',
        'additional_images',
    ];

    protected $casts = [
        'additional_images' => 'array',
    ];
}
