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
        $rates = $this->countryService->getExchangeRate('USD');

        return view('user.currency', compact('rates'));
    }
}