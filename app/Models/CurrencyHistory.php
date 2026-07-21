<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyHistory extends Model
{
    protected $fillable = [
        'currency_code',
        'exchange_rate',
        'recorded_date',
    ];

    protected $casts = [
        'recorded_date' => 'date',
        'exchange_rate' => 'float',
    ];
}