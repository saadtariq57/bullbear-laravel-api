<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EmbeddingService
{
    private ?string $apiKey;
    private string $model;
    private string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('openai.api_key') ?: env('OPENAI_API_KEY');
        $this->model = 'text-embedding-3-small';
        $this->apiUrl = 'https://api.openai.com/v1/embeddings';
    }

    /**
     * Generate embedding for the given text using OpenAI API
     *
     * @param string $text
     * @return array|null
     * @throws \Exception
     */
    public function generateEmbedding(string $text): ?array
    {
        if (empty($this->apiKey)) {
            Log::error('EmbeddingService: OpenAI API key not configured');
            throw new \Exception('OpenAI API key not configured');
        }

        if (empty(trim($text))) {
            Log::warning('EmbeddingService: Empty text provided for embedding');
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->apiUrl, [
                'model' => $this->model,
                'input' => trim($text),
                'encoding_format' => 'float',
            ]);

            if (!$response->successful()) {
                Log::error('EmbeddingService: OpenAI API request failed', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
                throw new \Exception('OpenAI API request failed: ' . $response->body());
            }

            $data = $response->json();

            if (!isset($data['data'][0]['embedding'])) {
                Log::error('EmbeddingService: Invalid response format', [
                    'response' => $data,
                ]);
                throw new \Exception('Invalid response format from OpenAI API');
            }

            $embedding = $data['data'][0]['embedding'];

            Log::info('EmbeddingService: Successfully generated embedding', [
                'text_length' => strlen($text),
                'embedding_dimension' => count($embedding),
                'model' => $this->model,
            ]);

            return $embedding;

        } catch (\Exception $e) {
            Log::error('EmbeddingService: Exception occurred', [
                'message' => $e->getMessage(),
                'text_sample' => substr($text, 0, 100) . '...',
            ]);
            
            throw $e;
        }
    }

    /**
     * Generate embedding with retry logic
     *
     * @param string $text
     * @param int $maxRetries
     * @return array|null
     */
    public function generateEmbeddingWithRetry(string $text, int $maxRetries = 3): ?array
    {
        Log::info("Generating embedding with retry", [$text]);
        
        $attempt = 1;
        
        while ($attempt <= $maxRetries) {
            try {
                return $this->generateEmbedding($text);
            } catch (\Exception $e) {
                Log::warning("EmbeddingService: Attempt {$attempt} failed", [
                    'error' => $e->getMessage(),
                    'attempt' => $attempt,
                    'max_retries' => $maxRetries,
                ]);

                if ($attempt === $maxRetries) {
                    throw $e;
                }

                // Exponential backoff: wait 2^attempt seconds
                sleep(pow(2, $attempt));
                $attempt++;
            }
        }

        return null;
    }

    /**
     * Calculate cosine similarity between two embedding vectors
     *
     * @param array $vector1
     * @param array $vector2
     * @return float
     */
    public function cosineSimilarity(array $vector1, array $vector2): float
    {
        if (empty($vector1) || empty($vector2)) {
            return 0.0;
        }

        $dotProduct = 0.0;
        $normA = 0.0;
        $normB = 0.0;

        $minLength = min(count($vector1), count($vector2));

        for ($i = 0; $i < $minLength; $i++) {
            $dotProduct += $vector1[$i] * $vector2[$i];
            $normA += $vector1[$i] * $vector1[$i];
            $normB += $vector2[$i] * $vector2[$i];
        }

        $normA = sqrt($normA);
        $normB = sqrt($normB);

        if ($normA == 0.0 || $normB == 0.0) {
            return 0.0;
        }

        return $dotProduct / ($normA * $normB);
    }

    /**
     * Prepare text for embedding by combining group name and description
     *
     * @param string $name
     * @param string $description
     * @return string
     */
    public function prepareGroupText(string $name, string $description): string
    {
        $text = [];
        
        if (!empty(trim($name))) {
            $text[] = "Group: " . trim($name);
        }
        
        if (!empty(trim($description))) {
            $text[] = "Description: " . trim($description);
        }
        
        return implode(". ", $text);
    }
} 