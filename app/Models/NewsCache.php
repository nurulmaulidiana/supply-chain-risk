<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCache extends Model
{
    protected $table = 'news_cache';

    protected $fillable = [
        'country',
        'title',
        'description',
        'source',
        'url',
        'image',
        'published_at',
        'sentiment',
    ];
}