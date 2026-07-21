<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Services\CountryService;
use App\Models\Watchlist;
use App\Models\EconomicData;
use App\Models\RiskScore;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index(Request $request)
    {
        // Ambil daftar negara dari database
        $countries = Country::orderBy('name')->get();

        $selectedCountry = $request->country;

        $countryData = null;
        $country = null;
        $currencyCode = null;
        $gdp = null;
        $population = null;
        $inflation = null;
        $weather = null;
        $coordinate = null;
        $isWatchlist = false;
        $riskScore = null;
        $riskLevel = null;

        if ($selectedCountry) {

            // Cari negara berdasarkan ID database
            $countryData = Country::find($selectedCountry);

            if ($countryData) {

                // Ambil detail negara dari REST Countries
                $country = $this->countryService->getCountryDetail($countryData->name);

                if ($country) {
                    $currencyCode = $country['currencies'][0]['code'] ?? null;
                }

                // Ambil koordinat
                $coordinate = $this->countryService->getCoordinate($countryData->name);

                // Data World Bank menggunakan ISO3
                $gdp = $this->countryService->getGDP($countryData->iso3);
                $population = $this->countryService->getPopulation($countryData->iso3);
                $inflation = $this->countryService->getInflation($countryData->iso3);

                EconomicData::updateOrCreate(
                    [
                        'country' => $countryData->name
                    ],
                    [
                        'country_code' => $countryData->iso3,
                        'gdp'          => $gdp,
                        'inflation'    => $inflation,
                        'population'   => $population,
                        'exports'      => null,
                        'imports'      => null,
                    ]
                );

                // Weather
                if ($coordinate) {
                    $weather = $this->countryService->getWeather(
                        $coordinate['latitude'],
                        $coordinate['longitude']
                    );
                }

                $isWatchlist = Watchlist::where('user_id', auth()->id())
                    ->where('country_id', $countryData->id)
                    ->exists();

                // =============================
                // AUTO CREATE RISK SCORE
                // =============================

                $risk = RiskScore::where('country', $countryData->name)
                    ->first();

                if (!$risk) {

                    // contoh bobot sederhana
                    $weatherScore = 20;

                    // inflation
                    if ($inflation !== null && $inflation > 5) {
                        $inflationScore = 60;
                    } else {
                        $inflationScore = 20;
                    }

                    // news sementara dummy
                    $newsScore = 40;

                    // currency sementara
                    $currencyScore = 20;

                    // total
                    $totalScore = (
                        $weatherScore +
                        $inflationScore +
                        $newsScore +
                        $currencyScore
                    ) / 4;

                    if ($totalScore >= 70) {
                        $calculatedRiskLevel = "High Risk";
                    } elseif ($totalScore >= 40) {
                        $calculatedRiskLevel = "Medium Risk";
                    } else {
                        $calculatedRiskLevel = "Low Risk";
                    }

                    $risk = RiskScore::create([
                        'country'        => $countryData->name,
                        'weather_score'  => $weatherScore,
                        'inflation_score'=> $inflationScore,
                        'news_score'     => $newsScore,
                        'currency_score' => $currencyScore,
                        'total_score'    => $totalScore,
                        'risk_level'     => $calculatedRiskLevel
                    ]);
                }

                $riskScore = $risk->total_score;
                $riskLevel = $risk->risk_level;
            }
        }

        return view('user.country', compact(
            'countries',
            'selectedCountry',
            'countryData',
            'gdp',
            'population',
            'inflation',
            'weather',
            'coordinate',
            'country',
            'currencyCode',
            'isWatchlist',
            'riskScore',
            'riskLevel'
        ));
    }
}