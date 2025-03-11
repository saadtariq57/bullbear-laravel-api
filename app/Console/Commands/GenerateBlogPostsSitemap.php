<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class GenerateBlogPostsSitemap extends Command
{
    protected $signature = 'sitemap:generate-blog-posts';
    protected $description = 'Generate the blog posts sitemap';

    // Define the list of categories
    protected $categories = [
        'fundamental-analysis',
        'technical-analysis',
        'investing-money-management',
        'investing101',
        'investment-strategy',
        'stock-market-basics',
        'how-to-invest',
        'trading-strategies',
        'cryptocurrency',
        'investing',
        'stocks',
        'specialized-reports',
    ];

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Fetch posts for each category
        foreach ($this->categories as $categorySlug) {
            $response = Http::get('https://richtv.io/wp-json/wp/v2/posts', [
                'per_page' => 100, // Adjust as needed
                'page' => 1,
                'categories' => $this->getCategoryId($categorySlug), // Filter by category ID
                '_embed' => true, // Include embedded data (e.g., categories)
            ]);

            if ($response->successful()) {
                $posts = $response->json();

                // Add each post URL to the sitemap
                foreach ($posts as $post) {
                    // Convert the modified date string to a DateTime object
                    $lastModificationDate = Carbon::parse($post['modified_gmt']);

                    $sitemap->add(Url::create("/blog/{$categorySlug}/{$post['slug']}")
                        ->setLastModificationDate($lastModificationDate)
                        ->setChangeFrequency('weekly')
                        ->setPriority(0.6));
                }
            } else {
                $this->error("Failed to fetch posts for category: {$categorySlug}");
            }
        }

        // Save the sitemap to the public directory
        $sitemap->writeToFile(public_path('blog-posts-sitemap.xml'));

        $this->info('Blog posts sitemap generated successfully!');
    }

    /**
     * Get the category ID from the category slug.
     */
    protected function getCategoryId(string $categorySlug): ?int
    {
        $response = Http::get('https://richtv.io/wp-json/wp/v2/categories', [
            'slug' => $categorySlug,
        ]);

        if ($response->successful()) {
            $categories = $response->json();
            if (!empty($categories)) {
                return $categories[0]['id']; // Return the first matching category ID
            }
        }

        $this->error("Failed to fetch category ID for slug: {$categorySlug}");
        return null;
    }
}