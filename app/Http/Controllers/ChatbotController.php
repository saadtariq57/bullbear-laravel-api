<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function __construct(private ChatbotService $chatbot) {}

    /**
     * POST /api/chatbot/query
     * Send a prompt; backend injects user_id before calling the microservice.
     */
    public function query(Request $request)
    {
        $data = $request->validate([
            'prompt'          => 'required|string|max:4000',
            'conversation_id' => 'nullable|string|max:100',
        ]);

        try {
            $result = $this->chatbot->query(
                $data['prompt'],
                auth()->id(),
                $data['conversation_id'] ?? null,
            );

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('ChatbotController::query error', ['message' => $e->getMessage()]);

            return response()->json(
                ['error' => 'Failed to get a response. Please try again.'],
                500
            );
        }
    }

    /**
     * GET /api/chatbot/conversations
     * List all conversations for the authenticated user.
     */
    public function conversations()
    {
        try {
            $conversations = $this->chatbot->listConversations(auth()->id());

            return response()->json($conversations);
        } catch (\Exception $e) {
            Log::error('ChatbotController::conversations error', ['message' => $e->getMessage()]);

            return response()->json([], 200);
        }
    }

    /**
     * GET /api/chatbot/conversations/{conversationId}/messages
     * Fetch message history for a single conversation.
     */
    public function messages(string $conversationId)
    {
        try {
            $messages = $this->chatbot->getMessages($conversationId);

            return response()->json($messages);
        } catch (\Exception $e) {
            Log::error('ChatbotController::messages error', [
                'conversation_id' => $conversationId,
                'message'         => $e->getMessage(),
            ]);

            return response()->json(
                ['error' => 'Failed to load conversation history.'],
                500
            );
        }
    }
}
