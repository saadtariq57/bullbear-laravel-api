<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateBlogCategoriesSitemap extends Command
{
    protected $signature = 'sitemap:generate-blog-categories';
    protected $description = 'Generate the blog categories sitemap';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Hardcoded categories from your categories.js file
        $categories = [
            ['slug' => 'fundamental-analysis'],
            ['slug' => 'technical-analysis'],
            ['slug' => 'investing-money-management'],
            ['slug' => 'investing101'],
            ['slug' => 'investment-strategy'],
            ['slug' => 'stock-market-basics'],
            ['slug' => 'how-to-invest'],
            ['slug' => 'trading-strategies'],
            ['slug' => 'cryptocurrency'],
            ['slug' => 'investing'],
            ['slug' => 'stocks'],
            ['slug' => 'specialized-reports'],
        ];

        // Add each category URL to the sitemap
        foreach ($categories as $category) {
            $sitemap->add(Url::create("/blog/category/{$category['slug']}")
                ->setChangeFrequency('weekly')
                ->setPriority(0.7));
        }

        // Save the sitemap to the public directory
        $sitemap->writeToFile(public_path('blog-categories-sitemap.xml'));

        $this->info('Blog categories sitemap generated successfully!');
    }
}