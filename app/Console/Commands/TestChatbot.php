<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\ChatbotService;
use Illuminate\Console\Command;

class TestChatbot extends Command
{
    protected $signature = 'chatbot:test
                            {--user=1      : ID of the user to send the message as}
                            {--prompt=What are the top gainers today? : The prompt to send}
                            {--conversation= : Optional conversation_id to continue an existing thread}';

    protected $description = 'Test the chatbot microservice through the full app stack (same path as a logged-in user)';

    public function __construct(private ChatbotService $chatbot)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        // ── 1. Resolve user ──────────────────────────────────────────────
        $userId = (int) $this->option('user');
        $user   = User::find($userId);

        if (! $user) {
            $this->error("No user found with ID {$userId}.");
            $this->line('Run `php artisan chatbot:test --user=<id>` with a valid user ID.');
            return self::FAILURE;
        }

        $prompt         = $this->option('prompt');
        $conversationId = $this->option('conversation') ?: null;

        // ── 2. Show what we are about to send ────────────────────────────
        $this->newLine();
        $this->line('<fg=cyan>━━━  RichTV Chatbot Test  ━━━</>');
        $this->newLine();
        $this->line("  <fg=yellow>User</>       : [{$user->id}] {$user->name} ({$user->email})");
        $this->line("  <fg=yellow>Prompt</>     : {$prompt}");
        $this->line("  <fg=yellow>Conv. ID</>   : " . ($conversationId ?? '<new conversation>'));
        $this->line("  <fg=yellow>Service URL</> : " . config('services.chatbot.url'));
        $this->newLine();

        // ── 3. Call the service (same path as ChatbotController) ─────────
        $this->line('<fg=cyan>Sending request to chatbot microservice…</>');
        $start = microtime(true);

        try {
            $result = $this->chatbot->query($prompt, $user->id, $conversationId);
        } catch (\Exception $e) {
            $this->newLine();
            $this->error('Request failed: ' . $e->getMessage());
            $this->newLine();
            $this->line('<fg=yellow>Troubleshooting checklist:</>');
            $this->line('  1. Is the chatbot microservice running?');
            $this->line('  2. Is RICHTV_CHATBOT_API_URL in .env set to the correct host:port?');
            $this->line('     Current value: ' . config('services.chatbot.url'));
            $this->line('  3. Run `php artisan config:clear` if you just changed .env');
            return self::FAILURE;
        }

        $elapsed = round((microtime(true) - $start) * 1000);

        // ── 4. Show result ───────────────────────────────────────────────
        $this->newLine();
        $this->line('<fg=green>✔  Response received in ' . $elapsed . ' ms</>');
        $this->newLine();

        $this->line('<fg=yellow>Answer:</>');
        $this->line($result['answer'] ?? '(no answer field in response)');

        if (! empty($result['conversation_id'])) {
            $this->newLine();
            $this->line('<fg=yellow>Conversation ID:</> ' . $result['conversation_id']);
            $this->line('<fg=gray>  → Pass this with --conversation="' . $result['conversation_id'] . '" to continue this thread.</>');
        }

        $this->newLine();
        return self::SUCCESS;
    }
}
