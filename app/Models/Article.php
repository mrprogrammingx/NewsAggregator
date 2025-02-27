<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'url',
        'title',
        'api_source',
        'source',
        'author',
        'description',
        'category',
        'language',
        'url_to_image',
        'content',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
