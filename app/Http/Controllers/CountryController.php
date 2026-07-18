<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Services\CountryService;
use App\Models\Watchlist;

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
            'isWatchlist'
        ));
    }
}