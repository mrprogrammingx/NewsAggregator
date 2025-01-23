<?php

namespace App\Models;

use App\ApiSources;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $casts = [
        'api_source' => ApiSources::class,
    ];
}
