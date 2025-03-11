<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;

class GenerateSitemapIndex extends Command
{
    protected $signature = 'sitemap:generate-index';
    protected $description = 'Generate the sitemap index';

    public function handle()
    {
        $sitemapIndex = Sitemap::create();

        // Add all sitemaps to the index
        $sitemapIndex->add('/quotes-sitemap.xml');
        $sitemapIndex->add('/blog-categories-sitemap.xml');
        $sitemapIndex->add('/blog-posts-sitemap.xml');
        $sitemapIndex->add('/markets-sitemap.xml');
        $sitemapIndex->add('/pages-sitemap.xml');

        // Save the sitemap index to the public directory
        $sitemapIndex->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap index generated successfully!');
    }
}