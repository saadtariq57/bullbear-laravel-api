<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Symbol;

class GenerateQuotesSitemap extends Command
{
    protected $signature = 'sitemap:generate-quotes';
    protected $description = 'Generate the quotes sitemap';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Fetch all symbols from the database
        $symbols = Symbol::where('active', true)->get();

        // Add each symbol URL to the sitemap
        foreach ($symbols as $symbol) {
            $sitemap->add(Url::create("/quotes/{$symbol->symbol}")
                ->setLastModificationDate($symbol->updated_at)
                ->setChangeFrequency('daily')
                ->setPriority(0.8));
        }

        // Save the sitemap to the public directory
        $sitemap->writeToFile(public_path('quotes-sitemap.xml'));

        $this->info('Quotes sitemap generated successfully!');
    }
}