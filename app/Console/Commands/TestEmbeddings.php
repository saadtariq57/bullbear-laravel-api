<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GeneralGroupEmbedding;
use App\Services\EmbeddingService;

class TestEmbeddings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'embeddings:test {--prompt=Technology news : Test prompt to compare against}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test general group embeddings by comparing similarity with a test prompt';

    private EmbeddingService $embeddingService;

    public function __construct(EmbeddingService $embeddingService)
    {
        parent::__construct();
        $this->embeddingService = $embeddingService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Testing General Group Embeddings...');
        $this->info('');

        $testPrompt = $this->option('prompt');
        $this->line("Test Prompt: <comment>{$testPrompt}</comment>");
        $this->info('');

        // Get all general group embeddings
        $embeddings = GeneralGroupEmbedding::with('group.category')->get();

        if ($embeddings->isEmpty()) {
            $this->warn('No general group embeddings found.');
            $this->line('Make sure you have:');
            $this->line('1. Groups with "general", "discussion", or "community" categories');
            $this->line('2. Valid OpenAI API key configured');
            $this->line('3. Groups with descriptions');
            return 1;
        }

        $this->info("Found {$embeddings->count()} general group embeddings");
        $this->info('');

        try {
            // Generate embedding for test prompt
            $this->line('Generating embedding for test prompt...');
            $testEmbedding = $this->embeddingService->generateEmbedding($testPrompt);

            if (!$testEmbedding) {
                $this->error('Failed to generate embedding for test prompt');
                return 1;
            }

            $this->info('✅ Test embedding generated successfully');
            $this->info('');

            // Calculate similarities
            $similarities = [];
            
            foreach ($embeddings as $embedding) {
                $similarity = $this->embeddingService->cosineSimilarity($testEmbedding, $embedding->embedding);
                
                $similarities[] = [
                    'group' => $embedding,
                    'similarity' => $similarity,
                ];
            }

            // Sort by similarity (highest first)
            usort($similarities, function($a, $b) {
                return $b['similarity'] <=> $a['similarity'];
            });

            // Display results
            $this->info('📊 Similarity Results (sorted by relevance):');
            $this->info('');

            $headers = ['Group Name', 'Category', 'Similarity Score', 'Description Preview'];
            $rows = [];

            foreach ($similarities as $item) {
                $group = $item['group'];
                $similarity = $item['similarity'];
                
                // Get description preview (first 60 chars)
                $descPreview = strlen($group->description) > 60 
                    ? substr($group->description, 0, 60) . '...'
                    : $group->description;

                $categoryName = $group->group->category->name ?? 'N/A';

                // Color code based on similarity score
                $scoreColor = $similarity >= 0.8 ? 'green' : ($similarity >= 0.6 ? 'yellow' : 'red');
                $formattedScore = "<fg={$scoreColor}>" . number_format($similarity, 4) . "</>";

                $rows[] = [
                    $group->name ?? 'N/A',
                    $categoryName,
                    $formattedScore,
                    $descPreview,
                ];
            }

            $this->table($headers, $rows);

            // Statistics
            $this->info('');
            $this->info('📈 Statistics:');
            $this->line('Total groups analyzed: ' . count($similarities));
            $this->line('Highest similarity: ' . number_format(max(array_column($similarities, 'similarity')), 4));
            $this->line('Lowest similarity: ' . number_format(min(array_column($similarities, 'similarity')), 4));
            $this->line('Average similarity: ' . number_format(array_sum(array_column($similarities, 'similarity')) / count($similarities), 4));

            // Top recommendations
            $topResults = array_slice($similarities, 0, 3);
            $this->info('');
            $this->info('🎯 Top 3 Recommendations:');
            foreach ($topResults as $index => $item) {
                $rank = $index + 1;
                $group = $item['group'];
                $similarity = number_format($item['similarity'], 4);
                $this->line("{$rank}. {$group->name} (Score: {$similarity})");
            }

            $this->info('');
            $this->info('✅ Test completed successfully!');

        } catch (\Exception $e) {
            $this->error('Failed to test embeddings: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
