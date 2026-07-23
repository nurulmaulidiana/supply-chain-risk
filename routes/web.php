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
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\RiskScoringController;
use App\Http\Controllers\VisualizationController;
use App\Http\Controllers\ArticleController;

use App\Models\User;
use App\Models\Port;
use App\Models\Country;
use App\Models\Article;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', function () {
        $totalUser    = User::count();
        $totalPort    = Port::count();
        $totalCountry = Country::count();
        $totalArtikel = Article::count();

        return view('admin.dashboard', compact(
            'totalUser',
            'totalPort',
            'totalCountry',
            'totalArtikel'
        ));
    })->name('admin.dashboard');

    // Admin Resource Routes
    Route::resource('users', UserController::class);
     Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    Route::resource('ports', PortController::class);
    Route::resource('articles', ArticleController::class);

    // User Feature Routes
    Route::get('/user/country', [CountryController::class, 'index'])->name('user.country');
    Route::get('/user/port-location', [UserPortController::class, 'index'])->name('user.port');
    Route::get('/user/weather', [WeatherController::class, 'index'])->name('user.weather');
    Route::get('/user/currency', [CurrencyController::class, 'index'])->name('user.currency');
    Route::get('/user/risk-scoring', [RiskScoringController::class, 'index'])->name('user.risk-scoring');
    Route::get('/user/news', [NewsController::class, 'index'])->name('user.news');
    Route::get('/user/visualization', [VisualizationController::class, 'index'])->name('user.visualization');
    Route::get('/user/comparison', [ComparisonController::class, 'index'])->name('user.comparison');
    Route::get('/user/watchlist', [WatchlistController::class, 'index'])->name('user.watchlist');
    Route::post('/user/watchlist', [WatchlistController::class, 'store'])->name('watchlist.store');
    Route::delete('/user/watchlist/{id}', [WatchlistController::class, 'destroy'])->name('watchlist.destroy');
});

// Testing Route
Route::get('/tes-country', function () {
    $response = Illuminate\Support\Facades\Http::withHeaders([
        'Authorization' => 'Bearer ' . env('REST_COUNTRIES_API_KEY'),
    ])->get('https://api.restcountries.com/countries/v5?q=Indonesia');

    return $response->body();
});