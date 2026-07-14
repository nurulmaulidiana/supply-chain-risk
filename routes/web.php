<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\CountryController;

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

    // ================= USER =================

    Route::view('/user/dashboard', 'user.dashboard')->name('user.dashboard');

    // Global Country Dashboard (REST Countries API)
    Route::get('/user/country', [CountryController::class, 'index'])
        ->name('user.country');

    // Menu lainnya (sementara)
    Route::view('/user/risk', 'user.risk')->name('user.risk');
    Route::view('/user/weather', 'user.weather')->name('user.weather');
    Route::view('/user/currency', 'user.currency')->name('user.currency');
    Route::view('/user/news', 'user.news')->name('user.news');
    Route::view('/user/ports', 'user.ports')->name('user.ports');
    Route::view('/user/visualization', 'user.visualization')->name('user.visualization');
    Route::view('/user/comparison', 'user.comparison')->name('user.comparison');
    Route::view('/user/watchlist', 'user.watchlist')->name('user.watchlist');

});