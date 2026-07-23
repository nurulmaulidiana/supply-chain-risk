<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Ambil kurs mata uang asli setiap hari jam 00:05
Schedule::command('currency:fetch-daily')->dailyAt('00:05');