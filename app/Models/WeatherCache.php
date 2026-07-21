<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherCache extends Model
{
    protected $table = 'weather_cache';

    protected $fillable = [
        'country',
        'temperature',
        'wind_speed',
        'rainfall',
        'weather_condition',
        'last_updated'
    ];
}