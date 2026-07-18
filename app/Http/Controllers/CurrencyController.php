<?php

namespace App\Http\Controllers;

use App\Services\CountryService;

class CurrencyController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index()
    {
        $countries = $this->countryService->getCountries();

        $selected = request('country');

        $country = null;
        $currencyCode = null;
        $rates = null;

        if ($selected) {
            $country = $this->countryService->getCountryDetail($selected);

            if ($country) {
                $currencyCode = $country['currencies'][0]['code'] ?? 'USD';
                $rates = $this->countryService->getExchangeRate('USD');
            }
        }

        return view('user.currency', compact(
            'countries',
            'country',
            'currencyCode',
            'rates',
            'selected'
        ));
    }
}