<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CountryService
{
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

    public function getCurrency($countryCode)
    {
        $response = Http::get(
            "https://restcountries.com/v3.1/alpha/$countryCode"
        );

        if (!$response->successful()) {
            return null;
        }

        $country = $response->json()[0] ?? [];

        if (!isset($country['currencies'])) {
            return null;
        }

        return array_key_first($country['currencies']);
    }
}