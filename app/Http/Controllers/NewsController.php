<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CountryService;
use App\Models\NewsCache;

class NewsController extends Controller
{
    protected $countryService;

    private $positiveWords = [
        'growth',
        'increase',
        'improve',
        'profit',
        'stable',
        'recovery',
        'success',
        'boost',
        'expand',
        'strong'
    ];

    private $negativeWords = [
        'war',
        'crisis',
        'delay',
        'storm',
        'inflation',
        'disaster',
        'conflict',
        'decline',
        'loss',
        'risk',
        'shortage'
    ];

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    private function analyzeSentiment($text)
    {
        $text = strtolower($text);

        $positive = 0;
        $negative = 0;

        foreach ($this->positiveWords as $word) {
            if (str_contains($text, $word)) {
                $positive++;
            }
        }

        foreach ($this->negativeWords as $word) {
            if (str_contains($text, $word)) {
                $negative++;
            }
        }

        if ($positive > $negative) {
            return 'Positive';
        }

        if ($negative > $positive) {
            return 'Negative';
        }

        return 'Neutral';
    }

    public function index(Request $request)
    {
        $countries = $this->countryService->getCountries();

        $selectedCountry = $request->country;

        $articles = collect();

        if ($selectedCountry) {

            $news = $this->countryService->getNews($selectedCountry);

            foreach ($news as $item) {
                // Cek ketersediaan URL agar tidak merusak unique constraint di database
                if (isset($item['url'])) {
                    NewsCache::updateOrCreate(
                        [
                            'url' => $item['url']
                        ],
                        [
                            'country'      => $selectedCountry,
                            'title'        => $item['title'] ?? '',
                            'description'  => $item['description'] ?? '',
                            'source'       => $item['source']['name'] ?? '',
                            'image'        => $item['image'] ?? '',
                            'published_at' => isset($item['publishedAt'])
                                ? date('Y-m-d H:i:s', strtotime($item['publishedAt']))
                                : now(),
                        ]
                    );
                }
            }

            // Ambil berita dari cache berdasarkan negara terpilih
            $articles = NewsCache::where('country', $selectedCountry)
                ->latest('published_at')
                ->get();

            // Hitung sentimen untuk tiap artikel
            foreach ($articles as $article) {
                $article->sentiment = $this->analyzeSentiment(
                    $article->title . ' ' . $article->description
                );
            }
        }

        return view('user.news', compact(
            'countries',
            'selectedCountry',
            'articles'
        ));
    }
}