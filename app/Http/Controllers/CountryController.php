<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        // Ambil daftar negara dari World Bank
        $response = Http::get(
            'https://api.worldbank.org/v2/country?format=json&per_page=300'
        );

        if (!$response->successful()) {

            return view('user.country', [
                'countries' => [],
                'selectedCountry' => null,
                'countryData' => null,
            ]);

        }

        $data = $response->json();

        $countries = collect($data[1] ?? [])
            ->filter(function ($country) {
                return $country['region']['id'] != 'NA';
            })
            ->sortBy('name')
            ->values();

        // kode negara yang dipilih (IDN, AUS, USA, dll)
        $selectedCountry = $request->get('country');

        $countryData = null;

        if ($selectedCountry) {

            $countryData = $countries->firstWhere(
                'id',
                $selectedCountry
            );

        }

        return view('user.country', compact(
            'countries',
            'selectedCountry',
            'countryData'
        ));
    }
}