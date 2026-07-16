<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CountryService;

class WeatherController extends Controller
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
        $coordinate = null;
        $weather = null;

        if ($selectedCountry) {

            $countryData = $countries->firstWhere('id', $selectedCountry);

            if ($countryData) {

                $coordinate = $this->countryService->getCoordinate(
                    $countryData['name']
                );

                if ($coordinate) {

                    $weather = $this->countryService->getWeather(
                        $coordinate['latitude'],
                        $coordinate['longitude']
                    );

                }

            }

        }

        return view('user.weather', compact(
            'countries',
            'selectedCountry',
            'countryData',
            'coordinate',
            'weather'
        ));
    }
}