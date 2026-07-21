<?php

namespace App\Http\Controllers;

use App\Services\CountryService;

class ComparisonController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index()
    {
        $countries = $this->countryService->getCountries();

        $country1 = request('country1', 'Germany');
        $country2 = request('country2', 'Australia');

        $first = $this->countryService->getCountryDetail($country1);
        $second = $this->countryService->getCountryDetail($country2);

        // GDP
        $firstGDP = $this->countryService->getGDP(
            $first['codes']['alpha_3'] ?? 'DEU'
        );

        $secondGDP = $this->countryService->getGDP(
            $second['codes']['alpha_3'] ?? 'AUS'
        );

        // Inflation
        $firstInflation = $this->countryService->getInflation(
            $first['codes']['alpha_3'] ?? 'DEU'
        );

        $secondInflation = $this->countryService->getInflation(
            $second['codes']['alpha_3'] ?? 'AUS'
        );


        $coordinate1 = $this->countryService->getCoordinate($country1);

        $weather1 = null;

        if ($coordinate1) {
            $weather1 = $this->countryService->getWeather(
                $coordinate1['latitude'],
                $coordinate1['longitude']
            );
        }

        $coordinate2 = $this->countryService->getCoordinate($country2);

        $weather2 = null;

        if ($coordinate2) {
            $weather2 = $this->countryService->getWeather(
                $coordinate2['latitude'],
                $coordinate2['longitude']
            );
        }


        $firstWeather = '-';

        if ($weather1) {
            $firstWeather =
                $weather1['temperature_2m'] . " °C";
        }

        $secondWeather = '-';

        if ($weather2) {
            $secondWeather =
                $weather2['temperature_2m'] . " °C";
        }

        $firstRisk = rand(20, 80);
        $secondRisk = rand(20, 80);

        return view(
            'user.comparison',
            compact(
                'countries',
                'country1',
                'country2',
                'first',
                'second',
                'firstGDP',
                'secondGDP',
                'firstInflation',
                'secondInflation',
                'firstWeather',
                'secondWeather',
                'firstRisk',
                'secondRisk'
            )
        );
    }
}