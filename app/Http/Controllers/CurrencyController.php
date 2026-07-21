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

                // 2. Simpan histori hari ini
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

                    // 3. FITUR OTOMATIS: Jika data histori kurang dari 2, buatkan dummy 30 hari ke belakang
                    $existingCount = CurrencyHistory::where('currency_code', $currencyCode)->count();

                    if ($existingCount < 2) {
                        for ($i = 30; $i >= 1; $i--) {
                            // Buat variasi fluktuasi angka acak halus
                            $fluctuation = (rand(-100, 100) / 1000) * $todayRate;
                            $dummyRate = max(0.0001, round($todayRate + $fluctuation, 4));

                            CurrencyHistory::firstOrCreate(
                                [
                                    'currency_code' => $currencyCode,
                                    'recorded_date' => Carbon::now()->subDays($i)->toDateString(),
                                ],
                                [
                                    'exchange_rate' => $dummyRate,
                                ]
                            );
                        }
                    }
                }

                // 4. Ambil 30 hari terakhir untuk chart
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