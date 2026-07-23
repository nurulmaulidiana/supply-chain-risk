<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\CurrencyHistory;
use App\Services\CountryService;
use Illuminate\Console\Command;

class FetchDailyCurrencyRates extends Command
{
    protected $signature = 'currency:fetch-daily';

    protected $description = 'Ambil kurs harian dari ExchangeRate API (data asli) dan simpan ke currency_histories';

    public function handle(CountryService $countryService)
    {
        $this->info('Mengambil data kurs dari ExchangeRate API...');

        $rates = $countryService->getExchangeRate('USD');

        if (!$rates) {
            $this->error('Gagal mengambil data dari ExchangeRate API. Cek EXCHANGE_RATE_API_KEY di .env.');
            return Command::FAILURE;
        }

        $codes = Currency::pluck('code');

        if ($codes->isEmpty()) {
            $this->warn('Belum ada currency yang tersimpan di tabel currencies. Jalankan minimal 1x kunjungan halaman per negara dulu.');
            return Command::SUCCESS;
        }

        $saved = 0;
        $skipped = 0;

        foreach ($codes as $code) {

            if (!isset($rates[$code])) {
                $skipped++;
                continue;
            }

            CurrencyHistory::updateOrCreate(
                [
                    'currency_code' => $code,
                    'recorded_date' => now()->toDateString(),
                ],
                [
                    'exchange_rate' => $rates[$code],
                ]
            );

            // update juga snapshot terkini di tabel currencies
            Currency::where('code', $code)->update([
                'exchange_rate' => $rates[$code],
                'last_updated' => now(),
            ]);

            $this->info("Saved {$code}: {$rates[$code]}");
            $saved++;
        }

        $this->info("Selesai. {$saved} currency tersimpan, {$skipped} dilewati (tidak ditemukan di API).");

        return Command::SUCCESS;
    }
}