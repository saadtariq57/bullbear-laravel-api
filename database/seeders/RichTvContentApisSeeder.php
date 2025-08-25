<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\RichTvContentApi;

class RichTvContentApisSeeder extends Seeder
{
    public function run(): void
    {
        $seedPath = base_path('extraJunk/richtv_content_apis_seed.txt');

        if (!File::exists($seedPath)) {
            $this->command?->warn("Seed file not found: {$seedPath}");
            return;
        }

        $content = File::get($seedPath);
        // Normalize newlines
        $content = str_replace(["\r\n", "\r"], "\n", $content);

        // Split blocks by blank lines
        $blocks = preg_split('/\n{2,}/', trim($content));

        $created = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($blocks as $block) {
            $name = null;
            $description = null;
            $url = null;

            foreach (explode("\n", $block) as $line) {
                $line = trim($line);
                if ($line === '' || str_starts_with($line, '#')) {
                    continue;
                }
                if (stripos($line, 'Name:') === 0) {
                    $name = trim(substr($line, strlen('Name:')));
                } elseif (stripos($line, 'Description:') === 0) {
                    $description = trim(substr($line, strlen('Description:')));
                } elseif (stripos($line, 'Url:') === 0) {
                    $url = trim(substr($line, strlen('Url:')));
                }
            }

            if (!$name || !$description || !$url) {
                $skipped++;
                continue;
            }

            // Upsert by URL to avoid duplicates
            $endpoint = RichTvContentApi::where('url', $url)->first();
            if ($endpoint) {
                $endpoint->update([
                    'name' => $name,
                    'description' => $description,
                ]);
                $updated++;
            } else {
                RichTvContentApi::create([
                    'name' => $name,
                    'description' => $description,
                    'url' => $url,
                ]);
                $created++;
            }
        }

        $this->command?->info("RichTV Content APIs seeding complete. Created: {$created}, Updated: {$updated}, Skipped (incomplete): {$skipped}");
    }
}


