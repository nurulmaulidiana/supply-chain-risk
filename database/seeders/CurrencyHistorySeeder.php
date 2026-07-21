<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CurrencyHistory;
use Carbon\Carbon;

class CurrencyHistorySeeder extends Seeder
{
    public function run(): void
    {
        // Ganti/tambah kode currency sesuai yang mau di-demo
        $currencies = [
            'AFN' => 65.90,
            'EUR' => 0.92,
            'JPY' => 149.50,
            'MYR' => 4.45,
            'SGD' => 1.34,
        ];

        foreach ($currencies as $code => $baseRate) {

            for ($i = 29; $i >= 0; $i--) {

                $date = Carbon::now()->subDays($i)->toDateString();

                // Kasih variasi naik-turun kecil biar chart-nya terlihat natural
                $fluctuation = $baseRate * (rand(-200, 200) / 10000); // ±2%
                $rate = round($baseRate + $fluctuation, 4);

                CurrencyHistory::updateOrCreate(
                    [
                        'currency_code' => $code,
                        'recorded_date' => $date,
                    ],
                    [
                        'exchange_rate' => $rate,
                    ]
                );
            }
        }
    }
}