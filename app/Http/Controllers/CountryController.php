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
        $currency = null;

        if ($selectedCountry) {

            $countryData = $countries->firstWhere('id', $selectedCountry);

            $gdp = $this->countryService->getGDP($selectedCountry);

            $population = $this->countryService->getPopulation($selectedCountry);

            $inflation = $this->countryService->getInflation($selectedCountry);

            $currency = $this->countryService->getCurrency($selectedCountry);
        }

        return view(
            'user.country',
            compact(
                'countries',
                'selectedCountry',
                'countryData',
                'gdp',
                'population',
                'inflation',
                'currency'
            )
        );
    }
}