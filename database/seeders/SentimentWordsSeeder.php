<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PositiveWord;
use App\Models\NegativeWord;

class SentimentWordsSeeder extends Seeder
{
    public function run(): void
    {
        $positiveWords = [
            'growth', 'increase', 'profit', 'stable', 'improve',
            'recovery', 'surplus', 'boost', 'expand', 'strong',
            'gain', 'rise', 'record', 'success', 'agreement',
            'cooperation', 'deal', 'partnership', 'investment', 'opportunity',
        ];

        $negativeWords = [
            'war', 'crisis', 'inflation', 'delay', 'disaster',
            'conflict', 'decline', 'recession', 'shortage', 'collapse',
            'sanction', 'tension', 'disruption', 'strike', 'shutdown',
            'default', 'debt', 'unrest', 'threat', 'ban',
            // tambahan relevan bencana & insiden
            'flood', 'killed', 'death', 'damage', 'casualties',
            'earthquake', 'storm', 'destroyed', 'missing', 'emergency',
            'havoc', 'devastating', 'evacuate', 'injured', 'collision',
        ];

        foreach ($positiveWords as $word) {
            PositiveWord::firstOrCreate(['word' => $word]);
        }

        foreach ($negativeWords as $word) {
            NegativeWord::firstOrCreate(['word' => $word]);
        }

        $this->command->info('Sentiment words seeded: ' . count($positiveWords) . ' positive, ' . count($negativeWords) . ' negative.');
    }
}