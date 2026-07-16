<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\WeatherController;
use App\Services\CountryService;
use App\Http\Controllers\CurrencyController;

Route::get('/', function () {
    return redirect('/login');
});

// ================= AUTH =================

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================= SETELAH LOGIN =================

Route::middleware('auth')->group(function () {

    // ================= ADMIN =================

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('users', UserController::class);
    Route::resource('ports', PortController::class);

    

    // Global Country Dashboard (REST Countries API)
    Route::get('/user/country', [CountryController::class, 'index'])
        ->name('user.country');

    // Port Location
    Route::get('/user/port-location', [PortController::class, 'index'])
        ->name('user.port');

    // Menu 
    Route::view('/user/risk', 'user.risk')->name('user.risk');
    Route::get('/user/weather', [WeatherController::class, 'index'])
    ->name('user.weather');
    Route::get('/user/currency', [CurrencyController::class, 'index'])
    ->name('user.currency');
    Route::view('/user/news', 'user.news')->name('user.news');
    Route::view('/user/visualization', 'user.visualization')->name('user.visualization');
    Route::view('/user/comparison', 'user.comparison')->name('user.comparison');
    Route::view('/user/watchlist', 'user.watchlist')->name('user.watchlist');
});