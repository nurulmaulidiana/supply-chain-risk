<?php

namespace App\Http\Controllers;

use App\Models\RiskScore;
use App\Models\EconomicData;

class VisualizationController extends Controller
{
    public function index()
    {

        // =========================
        // RISK DATA
        // =========================

        $riskScores = RiskScore::orderBy('created_at','desc')->get();


        $countries = $riskScores->pluck('country');

        $scores = $riskScores->pluck('total_score');



        // =========================
        // ECONOMIC DATA
        // =========================

        $economicData = EconomicData::all();



        $economicCountries = $economicData->pluck('country');


        $gdp = $economicData->pluck('gdp');


        $inflation = $economicData->pluck('inflation');



        // =========================
        // CURRENCY DATA
        // =========================

        $currency = $riskScores->pluck('currency_score');



        return view('user.visualization', compact(

            'riskScores',

            'countries',
            'scores',

            'economicCountries',
            'gdp',
            'inflation',

            'currency'

        ));

    }
}