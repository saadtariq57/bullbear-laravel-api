<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.chatbot.url'), '/');
    }

    /**
     * Send a prompt to the chatbot and return the answer + conversation_id.
     */
    public function query(string $prompt, int $userId, ?string $conversationId = null): array
    {
        $payload = [
            'prompt'  => $prompt,
            'user_id' => (string) $userId,
        ];

        if ($conversationId) {
            $payload['conversation_id'] = $conversationId;
        }

        $response = Http::timeout(60)->post("{$this->baseUrl}/query", $payload);

        if (! $response->successful()) {
            Log::error('ChatbotService::query failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new \Exception('Chatbot service error: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Return all conversations belonging to the given user.
     */
    public function listConversations(int $userId): array
    {
        $response = Http::timeout(15)->get("{$this->baseUrl}/conversations", [
            'user_id' => (string) $userId,
        ]);

        if (! $response->successful()) {
            Log::error('ChatbotService::listConversations failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new \Exception('Chatbot service error: ' . $response->body());
        }

        return $response->json() ?? [];
    }

    /**
     * Return messages for a single conversation.
     */
    public function getMessages(string $conversationId, int $limit = 50): array
    {
        $response = Http::timeout(15)->get(
            "{$this->baseUrl}/conversations/{$conversationId}/messages",
            ['limit' => $limit]
        );

        if (! $response->successful()) {
            Log::error('ChatbotService::getMessages failed', [
                'conversation_id' => $conversationId,
                'status'          => $response->status(),
                'body'            => $response->body(),
            ]);
            throw new \Exception('Chatbot service error: ' . $response->body());
        }

        return $response->json() ?? [];
    }
}
