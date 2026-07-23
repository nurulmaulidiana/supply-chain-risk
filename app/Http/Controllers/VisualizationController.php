<?php

namespace App\Http\Controllers;

use App\Models\RiskScore;
use App\Models\EconomicData;

class VisualizationController extends Controller
{
    public function index()
    {
       
        // RISK DATA (sumber utama urutan negara)
       
        $riskScores = RiskScore::orderBy('created_at', 'desc')->get();

        $countries = $riskScores->pluck('country');
        $scores    = $riskScores->pluck('total_score');

        $riskColors = $riskScores->map(function ($item) {
            return match ($item->risk_level) {
                'High Risk'   => '#dc3545',
                'Medium Risk' => '#ffc107',
                default       => '#198754',
            };
        });

       
        // CURRENCY DATA 
        $currency = $riskScores->pluck('currency_score');

        // ECONOMIC DATA — DISAMAKAN ke daftar negara yang sama dengan
        // risk_scores, supaya semua 4 grafik menampilkan negara & urutan
        // yang identik dan bisa dibandingkan langsung.

        $economicByCountry = EconomicData::whereIn('country', $countries)
            ->get()
            ->keyBy('country');

        $economicCountries = $countries;

        $gdp = $countries->map(function ($countryName) use ($economicByCountry) {
            return $economicByCountry->get($countryName)->gdp ?? 0;
        });

        $inflation = $countries->map(function ($countryName) use ($economicByCountry) {
            return $economicByCountry->get($countryName)->inflation ?? 0;
        });

        return view('user.visualization', compact(
            'riskScores',
            'countries',
            'scores',
            'riskColors',
            'economicCountries',
            'gdp',
            'inflation',
            'currency'
        ));
    }
}