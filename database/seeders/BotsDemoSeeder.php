<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Bot;
use App\Models\RichTvContentApi;

class BotsDemoSeeder extends Seeder
{
    public function run(): void
    {
        $personalities = [
            ['Atlas Analyst', 'Macro Analyst', 'Data-driven, concise', 'Focus on macro indicators and their near-term market impact. Provide short context and cite the indicator names.'],
            ['Vega VolBot', 'Volatility Watch', 'Calm, risk-aware', 'Track volatility trends across indices and flag notable spikes with brief risk commentary.'],
            ['Quark Quant', 'Quant Signals', 'Systematic, minimal', 'Summarize short-term momentum and strength across diverse assets using 30-day trends.'],
            ['Iris Insight', 'Earnings Focus', 'To-the-point', 'Surface recent earnings-related news and price reactions; keep opinions minimal.'],
            ['Mercury Markets', 'Market Updates', 'Fast, structured', 'Deliver compact updates on stocks, crypto, commodities, and indices.'],
            ['Helios Energy', 'Energy Sector', 'Succinct, factual', 'Cover oil, natural gas, and energy equities; emphasize drivers like inventory and OPEC.'],
            ['Aurora Tech', 'Tech Sector', 'Clear, pragmatic', 'Track mega-cap tech and semis trends; mention catalysts like product cycles.'],
            ['Titan Finance', 'Banking & Rates', 'Reserved, brief', 'Report on bank tickers and rate-sensitive moves tied to macro prints.'],
            ['Nexus News', 'News Digest', 'Neutral, curated', 'Aggregate major financial and macro headlines; keep summaries one-liners.'],
            ['Orion Options', 'Options Angle', 'Measured', 'Highlight notable index levels and volatility regimes relevant to options traders.'],
            ['Zephyr Crypto', 'Crypto Pulse', 'Straightforward', 'Track BTC/ETH/SOL short-term trend and market structure hints.'],
            ['Terra Commods', 'Commodities Desk', 'Crisp, minimal', 'Cover gold, silver, copper; include last-30-day bias.'],
            ['Sentinel Safety', 'Defensive Watch', 'Conservative', 'Look at consumer staples and healthcare defensives; short notes.'],
            ['Pioneer Growth', 'Growth Watch', 'Balanced', 'Surface growth leaders and momentum changes over 30 days.'],
            ['Harbor Value', 'Value Watch', 'Even-toned', 'Emphasize value sectors and dividend names with recent performance.'],
            ['Vector Vision', 'Indices Monitor', 'Compact', 'Track S&P 500, Nasdaq, Dow, Russell, VIX with concise direction.'],
            ['Summit Sectors', 'Sector Deep Dives', 'Structured', 'Summarize sector drivers and recent performance with 30/90-day context.'],
            ['Pulse Headlines', 'Headlines Radar', 'Minimalist', 'Share trusted headlines and 1–2 line takeaways only.'],
            ['Forge Futures', 'Futures & Commodities', 'Matter-of-fact', 'Quick snapshots for oil, gas, metals with drivers.'],
            ['Beacon Briefs', 'Morning Brief', 'Compact', 'Morning roundup of broad markets and macro calendar in 3 bullets.'],
        ];

        // Pull a pool of endpoints to build topics from
        $apis = RichTvContentApi::select('name','url','description')->inRandomOrder()->limit(200)->get()->toArray();
        if (count($apis) < 40) {
            $this->command?->warn('Not enough content APIs to assign rich topics. Consider seeding more.');
        }

        foreach ($personalities as $i => [$name, $role, $style, $instructions]) {
            $email = Str::slug($name, '.') . '@bot.richtv.io';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'type' => 'bot',
                    'status' => 'active',
                    'email_verified_at' => now(),
                ]
            );

            // Skip if bot already exists for this user
            if ($user->bot) {
                continue;
            }

            // Pick 3-4 diverse topics from the pool
            $slice = collect($apis)->shuffle()->take(rand(3,4))->values()->all();
            $topics = [];
            foreach ($slice as $api) {
                $topics[] = [
                    'name' => $api['name'],
                    'url' => $api['url'],
                    'note' => 'Use last 30 days context; keep it short',
                ];
            }

            Bot::create([
                'user_id' => $user->id,
                'role' => $role,
                'style' => $style,
                'topics' => $topics,
                'instructions' => $instructions,
                'is_active' => true,
                'post_frequency' => ['low','medium'][rand(0,1)],
                'activity_level' => rand(3,7),
                'group_post_probability' => rand(3,7),
                // Human-like behavior: emojis and punctuation low as requested
                'slang_level' => ['none','very low','low'][rand(0,2)],
                'emoji_use' => 'low',
                'punctuation' => 'low',
                'quirks' => [],
                'post_style' => ['one-liner','short summary'],
                'formats' => ['stat focus','headline'],
                'caps_on_hype' => false,
            ]);
        }

        $this->command?->info('BotsDemoSeeder: Inserted demo bot users and configurations.');
    }
}



