<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EconomicData extends Model
{

    protected $table = 'economic_data';


    protected $fillable = [

        'country',
        'country_code',
        'gdp',
        'inflation',
        'population',
        'exports',
        'imports'

    ];

}