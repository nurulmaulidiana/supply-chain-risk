<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CountryService;
use App\Models\WeatherCache;

class WeatherController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index(Request $request)
    {
        // Ambil daftar negara dari World Bank
        $countries = $this->countryService->getCountries();

        $selectedCountry = $request->country;

        $countryData = null;
        $coordinate = null;
        $weather = null;

        if ($selectedCountry) {

            // Cari data negara yang dipilih
            $countryData = $countries->firstWhere('id', $selectedCountry);

            if ($countryData) {

                // Ambil koordinat negara
                $coordinate = $this->countryService->getCoordinate(
                    $countryData['name']
                );

                if ($coordinate) {

                    // Ambil cuaca dari Open Meteo
                    $weather = $this->countryService->getWeather(
                        $coordinate['latitude'],
                        $coordinate['longitude']
                    );

                    // Simpan ke database
                    if ($weather) {

                        WeatherCache::updateOrCreate(

                            [
                                'country' => $countryData['name']
                            ],

                            [
                                'temperature' => $weather['temperature_2m'] ?? null,
                                'wind_speed' => $weather['wind_speed_10m'] ?? null,
                                'rainfall' => $weather['rain'] ?? 0,
                                'weather_condition' => null,
                                'last_updated' => now()
                            ]

                        );

                    }

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