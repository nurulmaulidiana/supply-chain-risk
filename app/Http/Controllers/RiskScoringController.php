<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CountryService;
use App\Services\RiskService;
use App\Models\RiskScore;

class RiskScoringController extends Controller
{
    protected $countryService;
    protected $riskService;

    public function __construct(
        CountryService $countryService,
        RiskService $riskService
    ){
        $this->countryService = $countryService;
        $this->riskService = $riskService;
    }

    public function index(Request $request)
    {
        $countries = $this->countryService->getCountries();

        // Ambil parameter country dari query GET tanpa default "Indonesia"
        $selectedCountry = $request->country;

        // Jika negara belum dipilih / parameter kosong
        if (!$selectedCountry) {
            return view('user.risk-scoring', [
                'countries'       => $countries,
                'selectedCountry' => null,

                'temperature' => null,
                'inflation'   => null,
                'currency'    => null,
                'news'        => null,

                'weatherScore'   => null,
                'inflationScore' => null,
                'currencyScore'  => null,
                'newsScore'      => null,

                'totalScore' => null,
                'riskLevel'  => null
            ]);
        }

        // Ambil detail negara berdasarkan nama yang dipilih
        $country = $this->countryService->getCountryDetail($selectedCountry);

        // Jika data detail negara tidak ditemukan
        if (!$country) {
            return view('user.risk-scoring', [
                'countries'       => $countries,
                'selectedCountry' => null,

                'temperature' => null,
                'inflation'   => null,
                'currency'    => null,
                'news'        => null,

                'weatherScore'   => null,
                'inflationScore' => null,
                'currencyScore'  => null,
                'newsScore'      => null,

                'totalScore' => null,
                'riskLevel'  => null
            ]);
        }

        // --- Fetch Data ---
        $alpha3 = $country['codes']['alpha_3'] ?? '';

        // 1. Weather Data
        $temperature = 0;
        $coordinate = $this->countryService->getCoordinate($selectedCountry);

        if ($coordinate) {
            $weather = $this->countryService->getWeather(
                $coordinate['latitude'],
                $coordinate['longitude']
            );

            if ($weather) {
                $temperature = $weather['temperature_2m'];
            }
        }

        // 2. Inflation Data
        $inflation = $this->countryService->getInflation($alpha3);
        if (!$inflation) {
            $inflation = 0;
        }

        // 3. Currency Data (Revisi Logika Kurs USD)
        $currency = "stable";
        $currencyCode = $country['currencies'][0]['code'] ?? "USD";
        $rates = $this->countryService->getExchangeRate("USD");

        if ($rates && isset($rates[$currencyCode])) {
            $rate = $rates[$currencyCode];

            if ($rate < 0.5) {
                $currency = "unstable";
            } elseif ($rate < 1) {
                $currency = "medium";
            } else {
                $currency = "stable";
            }
        }

        // 4. News Data (Revisi Keyword Sentiment Analysis)
        $articles = $this->countryService->getNews($selectedCountry);
        $negative = 0;

        foreach ($articles as $article) {
            $title = strtolower($article['title'] ?? '');

            if (
                str_contains($title, 'war') ||
                str_contains($title, 'conflict') ||
                str_contains($title, 'strike') ||
                str_contains($title, 'flood') ||
                str_contains($title, 'earthquake') ||
                str_contains($title, 'disaster') ||
                str_contains($title, 'port') ||
                str_contains($title, 'sanction')
            ) {
                $negative++;
            }
        }

        if ($negative >= 5) {
            $news = "negative";
        } elseif ($negative >= 2) {
            $news = "neutral";
        } else {
            $news = "positive";
        }

        // --- Calculation via RiskService ---
        $weatherScore   = $this->riskService->weatherScore($temperature);
        $inflationScore = $this->riskService->inflationScore($inflation);
        $currencyScore  = $this->riskService->currencyScore($currency);
        $newsScore      = $this->riskService->newsScore($news);

        $totalScore = $this->riskService->totalScore(
            $weatherScore,
            $inflationScore,
            $newsScore,
            $currencyScore
        );

        $riskLevel = $this->riskService->riskLevel($totalScore);

        RiskScore::updateOrCreate(

    [
        'country' => $selectedCountry
    ],

    [
        'weather_score' => $weatherScore,

        'inflation_score' => $inflationScore,

        'news_score' => $newsScore,

        'currency_score' => $currencyScore,

        'total_score' => $totalScore,

        'risk_level' => $riskLevel
    ]

);

        return view('user.risk-scoring', compact(
            'countries',
            'selectedCountry',

            'temperature',
            'inflation',
            'currency',
            'news',

            'weatherScore',
            'inflationScore',
            'currencyScore',
            'newsScore',

            'totalScore',
            'riskLevel'
        ));
    }
}