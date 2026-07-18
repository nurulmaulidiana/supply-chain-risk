<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use App\Services\CountryService;

class ImportCountries extends Command
{
    protected $signature = 'countries:import';

    protected $description = 'Import countries from World Bank API';

    public function handle(CountryService $countryService)
    {
        $countries = $countryService->getCountries();

        if ($countries->isEmpty()) {
            $this->error('Failed to retrieve countries.');
            return;
        }

        foreach ($countries as $item) {

            Country::updateOrCreate(
                [
                    'iso3' => $item['id']
                ],
                [
                    'name'   => $item['name'],
                    'iso2'   => $item['iso2Code'] ?? null,
                    'iso3'   => $item['id'],
                    'region' => $item['region']['value'] ?? null,
                ]
            );

        }

        $this->info('Countries imported successfully.');
    }
}