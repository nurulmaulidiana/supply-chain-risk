<?php

namespace App\Http\Controllers;

use App\Services\CountryService;
use App\Models\Currency;

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

    Currency::updateOrCreate(

        [
            'code' => $currencyCode
        ],

        [
            'country' => $country['names']['common'] ?? $selected,
            'name' => $country['currencies'][0]['name'] ?? '',
            'symbol' => $country['currencies'][0]['symbol'] ?? '',
            'exchange_rate' => $rates[$currencyCode] ?? null,
            'last_updated' => now()
        ]

    );

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