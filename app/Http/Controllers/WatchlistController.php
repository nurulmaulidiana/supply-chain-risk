<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CountryService;

class WatchlistController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index()
    {
        $watchlists = Watchlist::with('country')
            ->where('user_id', Auth::id())
            ->get();

        foreach ($watchlists as $item) {

            $country = $item->country;

            // GDP
            $item->gdp = $this->countryService->getGDP($country->iso3);

            // Inflation
            $item->inflation = $this->countryService->getInflation($country->iso3);

          //REST Countries
            $detail = $this->countryService->getCountryDetail($country->name);
            $item->currency =
            $detail['currencies'][0]['code'] ?? '-';

            // Coordinate
            $coordinate = $this->countryService->getCoordinate($country->name);

            if ($coordinate) {

                $weather = $this->countryService->getWeather(
                    $coordinate['latitude'],
                    $coordinate['longitude']
                );

                $item->weather = $weather['temperature_2m'] ?? null;

            } else {

                $item->weather = null;

            }
        }

        return view('user.watchlist', compact('watchlists'));
    }

    public function store(Request $request)
    {
        Watchlist::firstOrCreate([
            'user_id' => Auth::id(),
            'country_id' => $request->country_id,
        ]);

        return back()->with('success', 'Country added to watchlist.');
    }

    public function destroy($id)
    {
        Watchlist::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Country removed from watchlist.');
    }
}