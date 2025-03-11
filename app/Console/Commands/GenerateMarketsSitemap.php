<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateMarketsSitemap extends Command
{
    protected $signature = 'sitemap:generate-markets';
    protected $description = 'Generate the markets sitemap';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Add static market URLs to the sitemap
        $marketUrls = [
            '/markets/indices',
            '/markets/indices/indices-futures',
            '/markets/indices/major-indices',
            '/markets/indices/indices-realtime',
            '/markets/indices/world-indices',
            '/markets/indices/global-indices',
            '/markets/stocks',
            '/markets/stocks/trading-stocks',
            '/markets/stocks/united-states',
            '/markets/stocks/most-active',
            '/markets/stocks/top-gainers',
            '/markets/stocks/top-losers',
            '/markets/stocks/world-adrs',
            '/markets/stocks/marijuana-stocks',
            '/markets/stocks/top-bank-stocks',
            '/markets/commodities',
            '/markets/commodities/real-time-commodities',
            '/markets/commodities/metals',
            '/markets/commodities/energy',
            '/markets/commodities/grains',
            '/markets/commodities/softs',
            '/markets/commodities/meats',
            '/markets/cryptocurrency',
            '/markets/cryptocurrency/bitcoin-etfs',
            '/markets/etfs',
            '/markets/etfs/usa-etfs',
            '/markets/etfs/marijuana-etfs',
            '/markets/funds',
            '/markets/bonds',
        ];

        // Add each market URL to the sitemap
        foreach ($marketUrls as $url) {
            $sitemap->add(Url::create($url)
                ->setLastModificationDate(now()) // Use the current date as lastmod
                ->setChangeFrequency('daily') // Set change frequency to daily
                ->setPriority(0.8)); // Set priority
        }

        // Save the sitemap to the public directory
        $sitemap->writeToFile(public_path('markets-sitemap.xml'));

        $this->info('Markets sitemap generated successfully!');
    }
}