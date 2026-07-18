<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\UserPortController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {


    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('users', UserController::class);
    Route::resource('ports', PortController::class);



    // Global Country Dashboard
    Route::get('/user/country', [CountryController::class, 'index'])
        ->name('user.country');

    // Port Location
    Route::get('/user/port-location', [UserPortController::class, 'index'])
        ->name('user.port');

    // Weather
    Route::get('/user/weather', [WeatherController::class, 'index'])
        ->name('user.weather');

    // Currency
    Route::get('/user/currency', [CurrencyController::class, 'index'])
        ->name('user.currency');

    // Risk
    Route::view('/user/risk', 'user.risk')->name('user.risk');

    // News
    Route::view('/user/news', 'user.news')->name('user.news');

    // Visualization
    Route::view('/user/visualization', 'user.visualization')
        ->name('user.visualization');

    // Comparison
    Route::view('/user/comparison', 'user.comparison')
        ->name('user.comparison');


    Route::get('/user/watchlist', [WatchlistController::class, 'index'])
        ->name('user.watchlist');

    Route::post('/user/watchlist', [WatchlistController::class, 'store'])
        ->name('watchlist.store');

    Route::delete('/user/watchlist/{id}', [WatchlistController::class, 'destroy'])
        ->name('watchlist.destroy');
});



Route::get('/tes-country', function () {

    $response = Illuminate\Support\Facades\Http::withHeaders([
        'Authorization' => 'Bearer ' . env('REST_COUNTRIES_API_KEY'),
    ])->get('https://api.restcountries.com/countries/v5?q=Indonesia');

    return $response->body();
});