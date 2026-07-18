<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'code',
        'name',
        'symbol'
    ];

    public function countries()
    {
        return $this->hasMany(Country::class);
    }
}