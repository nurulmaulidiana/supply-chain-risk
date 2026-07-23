<?php

namespace App\Http\Controllers;

use App\Services\CountryService;
use App\Models\Currency;
use App\Models\CurrencyHistory;
use Carbon\Carbon;

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
        $history = collect();

        if ($selected) {
            $country = $this->countryService->getCountryDetail($selected);

            if ($country) {

                $currencyCode = $country['currencies'][0]['code'] ?? 'USD';
                $rates = $this->countryService->getExchangeRate('USD');
                $todayRate = $rates[$currencyCode] ?? null;

                // 1. Simpan snapshot current (untuk tabel info)
                Currency::updateOrCreate(
                    ['code' => $currencyCode],
                    [
                        'country' => $country['names']['common'] ?? $selected,
                        'name' => $country['currencies'][0]['name'] ?? '',
                        'symbol' => $country['currencies'][0]['symbol'] ?? '',
                        'exchange_rate' => $todayRate,
                        'last_updated' => now()
                    ]
                );

                // 2. Simpan histori hari ini (data ASLI dari API, bukan dummy)
                if ($todayRate) {
                    CurrencyHistory::updateOrCreate(
                        [
                            'currency_code' => $currencyCode,
                            'recorded_date' => now()->toDateString(),
                        ],
                        [
                            'exchange_rate' => $todayRate,
                        ]
                    );
                }

                // 3. Ambil 30 hari terakhir untuk chart
                $history = CurrencyHistory::where('currency_code', $currencyCode)
                    ->orderBy('recorded_date', 'asc')
                    ->take(30)
                    ->get();
            }
        }

        return view('user.currency', compact(
            'countries',
            'country',
            'currencyCode',
            'rates',
            'selected',
            'history'
        ));
    }
}