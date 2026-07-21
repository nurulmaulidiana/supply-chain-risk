<?php

namespace App\Services;

class RiskService
{
    // WEATHER RISK
    public function weatherScore($temperature)
    {
        if ($temperature <= 30) {
            return 20;
        } elseif ($temperature <= 35) {
            return 40;
        } elseif ($temperature <= 40) {
            return 70;
        }

        return 90;
    }


    // INFLATION RISK
    public function inflationScore($inflation)
    {
        if ($inflation < 3) {
            return 20;
        } elseif ($inflation <= 5) {
            return 40;
        } elseif ($inflation <= 8) {
            return 60;
        }

        return 90;
    }


    // NEWS SENTIMENT RISK
    public function newsScore($news)
    {
        if ($news == 'positive') {
            return 20;
        } elseif ($news == 'neutral') {
            return 40;
        } elseif ($news == 'negative') {
            return 70;
        }

        return 50;
    }


    // CURRENCY RISK
    public function currencyScore($currency)
    {
        if ($currency == 'stable') {
            return 20;
        } elseif ($currency == 'medium') {
            return 50;
        } elseif ($currency == 'unstable') {
            return 80;
        }

        return 50;
    }


    // WEIGHTED RISK MODEL
    public function totalScore($weather, $inflation, $news, $currency)
    {
        return
            ($weather * 0.30) +
            ($inflation * 0.20) +
            ($news * 0.40) +
            ($currency * 0.10);
    }


    // RISK LEVEL
    public function riskLevel($score)
    {
        if ($score >= 70) {
            return "High Risk";
        }

        if ($score >= 40) {
            return "Medium Risk";
        }

        return "Low Risk";
    }
}