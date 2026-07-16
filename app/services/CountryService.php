<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CountryService
{
  
    // Daftar Negara (World Bank)
    public function getCountries()
    {
        try {
        $response = Http::timeout(10)
        ->retry(2, 500)
        ->get(
            'https://api.worldbank.org/v2/country?format=json&per_page=300'
        );

        if (!$response->successful()) {
            return collect();
        }

        $data = $response->json();

        return collect($data[1] ?? [])
            ->filter(function ($country) {
                return ($country['region']['id'] ?? null) != 'NA';
            })
            ->sortBy('name')
            ->values();
    } catch (\Exception $e) {
         return collect();
    }
    }

    // Koordinat Negara (Open-Meteo Geocoding)
public function getCoordinate($countryName)
{
    try {
    $response = Http::timeout(10)
     ->retry(2, 500)
     ->get(
        "https://geocoding-api.open-meteo.com/v1/search",
        [
            'name' => $countryName,
            'count' => 1
        ]
    );

    if (!$response->successful()) {
        return null;
    }

    $data = $response->json();

    return $data['results'][0] ?? null;
} catch (\Exception $e) {
     return null;
}
}

    // GDP
    public function getGDP($countryCode)
    {
        try {
        $response = Http::timeout(10)
        ->retry(2, 500)
        ->get(
            "https://api.worldbank.org/v2/country/$countryCode/indicator/NY.GDP.MKTP.CD?format=json&per_page=1"
        );

        if (!$response->successful()) {
            return null;
        }

        return $response->json()[1][0]['value'] ?? null;
         } catch (\Exception $e) {
            return null;
         }
    }

    // Population
    public function getPopulation($countryCode)
    {
        try {
            $response = Http::timeout(10)
            ->retry(2, 500)
            ->get(
            "https://api.worldbank.org/v2/country/$countryCode/indicator/SP.POP.TOTL?format=json&per_page=1"
        );

        if (!$response->successful()) {
            return null;
        }

        return $response->json()[1][0]['value'] ?? null;
    } catch (\Exception $e) {
         return null;
    }
    }
    

    // Inflation
    public function getInflation($countryCode)
    {
        try {
        $response = Http::timeout(10)
        ->retry(2, 500)
        ->get(
            "https://api.worldbank.org/v2/country/$countryCode/indicator/FP.CPI.TOTL.ZG?format=json&per_page=1"
        );

        if (!$response->successful()) {
            return null;
        }

        return $response->json()[1][0]['value'] ?? null;
    } catch (\Exception $e) {
        return null;
    }
    }

    // Weather (Open-Meteo API)
    public function getWeather($latitude, $longitude)
    {
        try {
        $response = Http::timeout(10)
         ->retry(2, 500)
         ->get(
            "https://api.open-meteo.com/v1/forecast",
            [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'current' => 'temperature_2m,wind_speed_10m,rain'
            ]
        );

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();
        return $data['current'] ?? null;
    } catch (\Exception $e) {
        return null;
    }
    }
    

    // Exchange Rate API
public function getExchangeRate($baseCurrency)
{
    try {

        $response = Http::timeout(10)
            ->retry(2, 500)
            ->get(
                "https://v6.exchangerate-api.com/v6/" .
                env('EXCHANGE_RATE_API_KEY') .
                "/latest/" .
                $baseCurrency
            );

        if (!$response->successful()) {
            return null;
        }

        return $response->json()['conversion_rates'] ?? null;

    } catch (\Exception $e) {
        return null;
    }
}
}