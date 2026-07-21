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
        $riskScores = RiskScore::orderBy('created_at', 'desc')->get();

        $countries = $riskScores->pluck('country');
        $scores    = $riskScores->pluck('total_score');

        // dipakai buat kasih warna beda-beda tiap bar sesuai level risiko
        $riskColors = $riskScores->map(function ($item) {
            return match ($item->risk_level) {
                'High Risk'   => '#dc3545', // merah
                'Medium Risk' => '#ffc107', // kuning
                default       => '#198754', // hijau
            };
        });

        // =========================
        // ECONOMIC DATA
        // =========================
        $economicData = EconomicData::orderBy('country')->get();

        $economicCountries = $economicData->pluck('country');
        $gdp        = $economicData->pluck('gdp');
        $inflation  = $economicData->pluck('inflation');

        // =========================
        // CURRENCY DATA
        // =========================
        $currency = $riskScores->pluck('currency_score');

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