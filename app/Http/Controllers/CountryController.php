<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CountryService;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index(Request $request)
    {
        $countries = $this->countryService->getCountries();

        $selectedCountry = $request->country;

        $countryData = null;

        $gdp = null;
        $population = null;
        $inflation = null;
        $weather = null;
        $coordinate = null;

        if ($selectedCountry) {

            $countryData = $countries->firstWhere('id', $selectedCountry);

            if ($countryData) {

                // Ambil koordinat dari Open-Meteo Geocoding
                $coordinate = $this->countryService->getCoordinate(
                    $countryData['name']
                    );
                    
                    // World Bank
                    $gdp = $this->countryService->getGDP($selectedCountry);
                    $population = $this->countryService->getPopulation($selectedCountry);
                    $inflation = $this->countryService->getInflation($selectedCountry);

                    // Weather
                    if ($coordinate) {
                        $weather = $this->countryService->getWeather(
                            $coordinate['latitude'],
                            $coordinate['longitude']
                            );
                            }
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
    'coordinate'
));

    }
}