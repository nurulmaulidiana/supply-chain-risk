<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CountryService
{
  
    // Daftar Negara (World Bank)
    public function getCountries()
    {
        $response = Http::get(
            'https://api.worldbank.org/v2/country?format=json&per_page=300'
        );

        if (!$response->successful()) {
            return collect();
        }

        $data = $response->json();

        return collect($data[1] ?? [])
            ->filter(function ($country) {
                return $country['region']['id'] != 'NA';
            })
            ->sortBy('name')
            ->values();
    }

    // Koordinat Negara (Open-Meteo Geocoding)
public function getCoordinate($countryName)
{
    $response = Http::get(
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
}

    // GDP
    public function getGDP($countryCode)
    {
        $response = Http::get(
            "https://api.worldbank.org/v2/country/$countryCode/indicator/NY.GDP.MKTP.CD?format=json&per_page=1"
        );

        if (!$response->successful()) {
            return null;
        }

        return $response->json()[1][0]['value'] ?? null;
    }

    // Population
    public function getPopulation($countryCode)
    {
        $response = Http::get(
            "https://api.worldbank.org/v2/country/$countryCode/indicator/SP.POP.TOTL?format=json&per_page=1"
        );

        if (!$response->successful()) {
            return null;
        }

        return $response->json()[1][0]['value'] ?? null;
    }

    // Inflation
    public function getInflation($countryCode)
    {
        $response = Http::get(
            "https://api.worldbank.org/v2/country/$countryCode/indicator/FP.CPI.TOTL.ZG?format=json&per_page=1"
        );

        if (!$response->successful()) {
            return null;
        }

        return $response->json()[1][0]['value'] ?? null;
    }

    // Weather (Open-Meteo API)
    public function getWeather($latitude, $longitude)
    {
        $response = Http::get(
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

        return $response->json()['current'] ?? null;
    }
}