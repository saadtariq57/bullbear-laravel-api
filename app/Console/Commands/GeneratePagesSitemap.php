<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GeneratePagesSitemap extends Command
{
    protected $signature = 'sitemap:generate-pages';
    protected $description = 'Generate the pages sitemap';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Add static page URLs to the sitemap
        $pageUrls = [
            '/economic-calendar',
            '/earning-calendar',
            '/dividend-calendar',
            '/splits-calendar',
            '/ipo-calendar',
            '/watchlist',
            '/groups',
            '/richtv-live',
            '/glossary',
            '/trading-strategies',
            '/academy/how-to-buy-cryptocurrency',
            '/ceo-interviews',
            '/trading-education',
            '/exams',
            '/stocks-screener',
            '/personal-access',
            '/pro-picks',
            '/about-us',
            '/pricing',
            '/contact-us',
            '/pro-picks',
            '/trading-history',
        ];

        // Add each page URL to the sitemap
        foreach ($pageUrls as $url) {
            $sitemap->add(Url::create($url)
                ->setLastModificationDate(now()) // Use the current date as lastmod
                ->setChangeFrequency('yearly') // Set change frequency to yearly
                ->setPriority(0.5)); // Set priority
        }

        // Save the sitemap to the public directory
        $sitemap->writeToFile(public_path('pages-sitemap.xml'));

        $this->info('Pages sitemap generated successfully!');
    }
}