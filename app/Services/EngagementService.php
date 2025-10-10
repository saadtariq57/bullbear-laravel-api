<?php

namespace App\Services;

use App\Models\Bot;
use App\Models\Comment;
use App\Models\EngagementLog;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\ReactionType;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class EngagementService
{
    public function engage(Bot $bot, array $options = []): array
    {
        $config = $bot->engagement_config ?? [];

        if (!$this->isWithinActiveHours($config)) {
            return [
                'success' => false,
                'skipped' => true,
                'reason' => 'outside_active_hours'
            ];
        }

        $botUser = User::find($bot->user_id);
        if (!$botUser) {
            return ['success' => false, 'error' => 'bot_user_not_found'];
        }

        $forced = $options['forced_action'] ?? null;
        $actionType = in_array($forced, ['react','react+comment'], true)
            ? $forced
            : $this->pickWeighted(Arr::get($config, 'actions', [ 'react' => 70, 'react+comment' => 30 ]));

        $sentiment = $this->pickWeighted(Arr::get($config, 'sentiment', [
            'positive' => 35, 'neutral' => 25, 'skeptical' => 15, 'curious' => 15, 'critical' => 10
        ]));

        $selectionDiagnostics = [];
        $post = $this->selectEligiblePost($bot, $options, $selectionDiagnostics);
        if (!$post) {
            // Cool down this bot on failure to avoid immediate reselection
            try {
                $bot->update(['last_engagement' => now()]);
                $botUser = $bot->user ?: User::find($bot->user_id);
                Log::channel('bot_engagement')->info('No eligible posts; updated last_engagement for bot', [
                    'bot_id' => $bot->id,
                    'bot_user_id' => $bot->user_id,
                    'bot_name' => $botUser?->name,
                    'bot_email' => $botUser?->email,
                    'options' => $options,
                    'diagnostics' => $selectionDiagnostics,
                ]);
            } catch (\Throwable $e) {
                Log::warning('EngagementService: failed to update bot timestamps on no eligible posts', ['e' => $e->getMessage(), 'bot_id' => $bot->id]);
            }
            return [
                'success' => false,
                'error' => 'no_eligible_posts',
                'message' => 'No eligible posts were found based on the current time window and exclusion rules.',
                'diagnostics' => $selectionDiagnostics,
            ];
        }

        $result = [
            'success' => true,
            'action' => $actionType,
            'sentiment' => $sentiment,
            'post_id' => $post->id,
            'reaction' => null,
            'comment' => null,
        ];

        // React
        if ($actionType === 'react' || $actionType === 'react+comment') {
            $forcedReactionName = $options['forced_reaction_name'] ?? null;
            $reactionTypeId = null;
            if (is_string($forcedReactionName) && trim($forcedReactionName) !== '') {
                $reactionTypeId = ReactionType::where('name', strtolower(trim($forcedReactionName)))->value('id');
            }
            if (!$reactionTypeId) {
                $reactionTypeId = $this->pickReactionTypeId($sentiment, Arr::get($config, 'reaction_weights', []));
            }
            if ($reactionTypeId) {
                $reaction = Reaction::updateOrCreate(
                    [
                        'user_id' => $botUser->id,
                        'post_id' => $post->id,
                    ],
                    [
                        'reaction_type_id' => $reactionTypeId,
                    ]
                );

                $this->notifyReaction($reaction, $post);

                try {
                    EngagementLog::create([
                        'bot_id' => $bot->id,
                        'post_id' => $post->id,
                        'action_type' => $actionType === 'react+comment' ? 'react+comment' : 'react',
                        'reaction_type_id' => $reactionTypeId,
                        'sentiment' => $sentiment,
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    // If enum not yet migrated for new sentiments, fallback to nearest allowed
                    $fallback = in_array($sentiment, ['positive','neutral','skeptical'], true)
                        ? $sentiment
                        : 'neutral';
                    Log::warning('EngagementLog create failed; using fallback sentiment', [
                        'original' => $sentiment,
                        'fallback' => $fallback,
                        'error' => $e->getMessage(),
                    ]);
                    EngagementLog::create([
                        'bot_id' => $bot->id,
                        'post_id' => $post->id,
                        'action_type' => $actionType === 'react+comment' ? 'react+comment' : 'react',
                        'reaction_type_id' => $reactionTypeId,
                        'sentiment' => $fallback,
                    ]);
                }

                $result['reaction'] = [
                    'reaction_type_id' => $reactionTypeId
                ];
            }
        }

        // Comment
        if ($actionType === 'react+comment') {
            $commentText = $options['forced_comment_text'] ?? null;
            if (!$commentText || trim($commentText) === '') {
                $commentText = $this->generateCommentText($bot, $config, $sentiment);
            }

            $comment = Comment::create([
                'user_id' => $botUser->id,
                'post_id' => $post->id,
                'text' => $commentText,
            ]);
            $this->notifyComment($comment, $post);

            try {
                EngagementLog::create([
                    'bot_id' => $bot->id,
                    'post_id' => $post->id,
                    'action_type' => $actionType,
                    'comment_id' => $comment->id,
                    'sentiment' => $sentiment,
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                $fallback = in_array($sentiment, ['positive','neutral','skeptical'], true)
                    ? $sentiment
                    : 'neutral';
                Log::warning('EngagementLog create (comment) failed; using fallback sentiment', [
                    'original' => $sentiment,
                    'fallback' => $fallback,
                    'error' => $e->getMessage(),
                ]);
                EngagementLog::create([
                    'bot_id' => $bot->id,
                    'post_id' => $post->id,
                    'action_type' => $actionType,
                    'comment_id' => $comment->id,
                    'sentiment' => $fallback,
                ]);
            }

            $result['comment'] = [
                'comment_id' => $comment->id,
            ];
        }

        // Update bot last_engagement timestamp on any successful engagement action
        try {
            if (!empty($result['success'])) {
                $bot->update(['last_engagement' => now()]);
            }
        } catch (\Throwable $e) {
            Log::warning('EngagementService: failed to update bot last_engagement', ['e' => $e->getMessage(), 'bot_id' => $bot->id]);
        }

        Log::info('EngagementService: engagement result', $result);
        return $result;
    }

    private function isWithinActiveHours(array $config): bool
    {
        $hours = Arr::get($config, 'active_window_hours');
        $minutes = Arr::get($config, 'active_window_minutes');
        if ((!$hours && !$minutes) || (is_numeric($hours) && (int)$hours <= 0 && (!is_numeric($minutes) || (int)$minutes <= 0))) {
            return true; // no restriction configured
        }
        // n8n drives scheduling; window here is informational/gating only. Allow by default.
        return true;
    }

    private function selectEligiblePost(Bot $bot, array $options = [], array &$diagnostics = []): ?Post
    {
        $config = $bot->engagement_config ?? [];
        $forcedWindow = $options['time_window'] ?? null;
        $windowChoice = $forcedWindow ?: $this->pickWeighted(Arr::get($config, 'post_windows', [
            '24h' => 60, '7d' => 30, '30d' => 10
        ]));

        $from = match ($windowChoice) {
            '24h' => now()->subHours(24),
            '7d' => now()->subDays(7),
            default => now()->subDays(30),
        };

        $diagnostics = [
            'forced_window' => $forcedWindow,
            'window_choice' => $windowChoice,
            'from_utc' => method_exists($from, 'toISOString') ? $from->toISOString() : (string) $from,
            'exclude_engaged' => !empty($options['exclude_engaged']),
            'allow_any' => !empty($options['allow_any']),
        ];

        // If a specific post is requested, try that immediately
        if (!empty($options['post_id'])) {
            $specific = Post::where('active', 1)
                ->where('id', (int) $options['post_id'])
                ->where('user_id', '!=', $bot->user_id)
                // Enforce 2-minute blackout: skip posts younger than 2 minutes
                ->where('created_at', '<=', now()->subMinutes(2))
                ->first();
            if ($specific) {
                // Optionally honor exclude_engaged
                if (!empty($options['exclude_engaged'])) {
                    $already = EngagementLog::where('bot_id', $bot->id)->where('post_id', $specific->id)->exists();
                    $reacted = Reaction::where('user_id', $bot->user_id)->where('post_id', $specific->id)->exists();
                    $commented = Comment::where('user_id', $bot->user_id)->where('post_id', $specific->id)->exists();
                    if (!$already && !$reacted && !$commented) {
                        return $specific;
                    }
                } else {
                    return $specific;
                }
            }
        }

        $query = Post::where('active', 1)
            ->where('created_at', '>=', $from)
            ->where('user_id', '!=', $bot->user_id)
            // Enforce 2-minute blackout
            ->where('created_at', '<=', now()->subMinutes(2));

        // Exclude posts already engaged by this bot
        $engagedPostIds = EngagementLog::where('bot_id', $bot->id)
            ->whereNotNull('post_id')
            ->pluck('post_id')
            ->all();
        if (!empty($engagedPostIds)) {
            $query->whereNotIn('id', $engagedPostIds);
        }

        // Additional safety: exclude posts already reacted or commented by the bot user
        $reacted = Reaction::where('user_id', $bot->user_id)
            ->whereNotNull('post_id')
            ->pluck('post_id')
            ->all();
        $commented = Comment::where('user_id', $bot->user_id)
            ->whereNotNull('post_id')
            ->pluck('post_id')
            ->all();
        $exclude = array_values(array_unique(array_merge($reacted, $commented)));
        $exclude = array_values(array_filter($exclude, fn($v) => !is_null($v)));
        if (!empty($exclude)) {
            $query->whereNotIn('id', $exclude);
        }

        $candidates = $query->orderByDesc('created_at')->limit(100)->get();
        $diagnostics['candidates_initial'] = $candidates->count();
        $diagnostics['excluded_reacted_or_commented_count'] = count($exclude);
        $diagnostics['excluded_already_engaged_count'] = count($engagedPostIds);
        if ($candidates->isEmpty()) {
            // Fallback: widen window to 7d, then 30d, then all if allow_any
            $fallbacks = [];
            if ($windowChoice !== '7d') $fallbacks[] = now()->subDays(7);
            if ($windowChoice !== '30d') $fallbacks[] = now()->subDays(30);
            if (!empty($options['allow_any'])) $fallbacks[] = null; // all time

            $fallbackAttempts = [];
            foreach ($fallbacks as $fFrom) {
                $q = Post::where('active', 1)->where('user_id', '!=', $bot->user_id);
                if ($fFrom) $q->where('created_at', '>=', $fFrom);
                // Enforce 2-minute blackout in fallbacks as well
                $q->where('created_at', '<=', now()->subMinutes(2));
                // Respect exclude_engaged again
                if (!empty($options['exclude_engaged'])) {
                    $engagedPostIds = EngagementLog::where('bot_id', $bot->id)
                        ->whereNotNull('post_id')
                        ->pluck('post_id')
                        ->all();
                    if (!empty($engagedPostIds)) $q->whereNotIn('id', $engagedPostIds);
                    $reacted = Reaction::where('user_id', $bot->user_id)
                        ->whereNotNull('post_id')
                        ->pluck('post_id')
                        ->all();
                    $commented = Comment::where('user_id', $bot->user_id)
                        ->whereNotNull('post_id')
                        ->pluck('post_id')
                        ->all();
                    $exclude = array_values(array_unique(array_merge($reacted, $commented)));
                    $exclude = array_values(array_filter($exclude, fn($v) => !is_null($v)));
                    if (!empty($exclude)) $q->whereNotIn('id', $exclude);
                }
                $found = $q->orderByDesc('created_at')->limit(100)->get();
                $fallbackAttempts[] = [
                    'from_utc' => $fFrom ? (method_exists($fFrom, 'toISOString') ? $fFrom->toISOString() : (string) $fFrom) : null,
                    'count' => $found->count(),
                ];
                if ($found->isNotEmpty()) return $found->random();
            }
            $diagnostics['fallback_attempts'] = $fallbackAttempts;
            return null;
        }
        return $candidates->random();
    }

    private function pickReactionTypeId(string $sentiment, array $weights): ?int
    {
        // Map sentiment to allowed reaction names
        $allowed = match ($sentiment) {
            'positive' => ['like', 'love', 'haha', 'wow'],
            'neutral' => ['like', 'wow', 'haha'],
            'skeptical' => ['sad', 'angry'],
            'curious' => ['like', 'wow'],
            'critical' => ['sad', 'angry'],
            default => ['like']
        };

        $types = ReactionType::whereIn('name', $allowed)->get();
        if ($types->isEmpty()) {
            return null;
        }

        // If bot provided custom weights per reaction name, apply within allowed set
        $pool = [];
        foreach ($types as $type) {
            $name = strtolower($type->name);
            $pool[$type->id] = (int) ($weights[$name] ?? 1);
        }

        $chosenId = $this->pickWeightedId($pool);
        return $chosenId ?: $types->random()->id;
    }

    private function generateCommentText(Bot $bot, array $config, string $sentiment): string
    {
        // Map sentiment to category
        $category = match ($sentiment) {
            'positive' => 'positive',
            'neutral' => 'neutral',
            'skeptical' => 'skeptical',
            'curious' => 'curious',
            'critical' => 'critical',
            default => 'neutral'
        };

        $templates = Arr::get($config, "comment_templates.$category", []);
        if (!is_array($templates) || empty($templates)) {
            // Fallback defaults
            $defaults = [
                'positive' => ['Love this take!', 'Agree with this 👍', 'Well said!'],
                'neutral' => ['Interesting.', 'Noted.', 'Hmm.'],
                'skeptical' => ['Not sure I buy this.', 'This seems optimistic.', 'I have doubts about this.'],
                'curious' => ['Curious about this.', 'What makes you say that?', 'Any sources on this?'],
                'critical' => ['This may be risky.', 'I see some issues here.', 'Needs a reality check.'],
            ];
            $templates = $defaults[$category] ?? ['Interesting.'];
        }

        $base = Arr::random($templates);

        // Length variation
        $lengthPref = $this->pickWeighted(Arr::get($config, 'comment_length', [
            'short' => 50, 'medium' => 35, 'long' => 15
        ]));

        $expanded = $this->expandTemplate($base, $lengthPref, $sentiment, $config);

        // Optional small randomness (emoji/typos)
        if ((bool) Arr::get($config, 'randomness.emojis', true)) {
            $expanded = $this->maybeAddEmoji($expanded, $sentiment);
        }
        if ((bool) Arr::get($config, 'randomness.typos', false)) {
            $expanded = $this->maybeAddMinorTypo($expanded);
        }

        return trim($expanded);
    }

    private function expandTemplate(string $text, string $length, string $sentiment, array $config): string
    {
        $addonsPositive = ['Totally agree.', 'Great point.', 'Exactly what I was thinking.', 'Thanks for sharing!'];
        $addonsNeutral = ['Makes sense.', 'Curious to see how this plays out.', 'Interesting angle.'];
        $addonsSkeptical = ['Curious about the downside.', 'What about risks?', 'Could be a stretch.'];

        $addons = match ($sentiment) {
            'positive' => $addonsPositive,
            'neutral' => $addonsNeutral,
            'skeptical' => $addonsSkeptical,
            default => $addonsNeutral
        };

        switch ($length) {
            case 'short':
                return $text;
            case 'medium':
                return $text . ' ' . Arr::random($addons);
            case 'long':
                return $text . ' ' . Arr::random($addons) . ' ' . Arr::random($addons);
            default:
                return $text;
        }
    }

    private function maybeAddEmoji(string $text, string $sentiment): string
    {
        $emojiSets = [
            'positive' => ['😊', '🙌', '🔥', '👍', '💯'],
            'neutral' => ['🤔', '👀', '📌'],
            'skeptical' => ['🤨', '🧐', '💭'],
        ];
        $set = $emojiSets[$sentiment] ?? ['🙂'];
        if (random_int(0, 100) < 35) {
            $text .= ' ' . Arr::random($set);
        }
        return $text;
    }

    private function maybeAddMinorTypo(string $text): string
    {
        if (strlen($text) < 6 || random_int(0, 100) > 20) {
            return $text;
        }
        $pos = random_int(1, max(1, strlen($text) - 2));
        $chars = str_split($text);
        $tmp = $chars[$pos];
        $chars[$pos] = $chars[$pos - 1];
        $chars[$pos - 1] = $tmp;
        return implode('', $chars);
    }

    private function notifyReaction(Reaction $reaction, Post $post): void
    {
        try {
            $postOwner = $post->user;
            $reaction->load(['reactionType', 'user:id,name,avatar,about']);
            if ($reaction->user_id !== $postOwner->id) {
                $notificationData = [
                    'reacted_by' => $reaction->user_id,
                    'reacted_to' => $postOwner->id,
                    'post_id' => $post->id,
                    'comment_id' => $reaction->comment_id ?? null,
                    'message_id' => $reaction->message_id ?? null,
                    'title' => $reaction->user->name . ' has reacted to your post',
                    'description' => $reaction->user->name . ' has ' . $reaction->reactionType->name . ' your post',
                    'type' => 'reaction',
                    'last_notification_time' => now(),
                    'url' => "/post/{$postOwner->name}/{$post->id}",
                    'user' => [
                        'id' => $reaction->user->id,
                        'name' => $reaction->user->name,
                        'avatar' => $reaction->user->avatar,
                    ],
                ];
                broadcast(new \App\Events\NewPostReaction($notificationData));
                $postOwner->notify(new \App\Notifications\NewPostReactionNotification($notificationData));
            }
        } catch (\Throwable $e) {
            Log::warning('EngagementService: reaction notification failed', ['e' => $e->getMessage()]);
        }
    }

    private function notifyComment(Comment $comment, Post $post): void
    {
        try {
            $postOwner = $post->user;
            $notificationData = [
                'id' => $comment->id,
                'commented_by' => $comment->user_id,
                'commented_to' => $postOwner->id !== $comment->user_id ? $postOwner->id : null,
                'post_id' => $post->id,
                'parent_id' => $comment->parent_id,
                'title' => $comment->user->name . ' has commented on your post',
                'description' => '',
                'type' => 'comment',
                'last_notification_time' => now(),
                'url' => "/post/{$postOwner->name}/{$post->id}",
                'user' => [
                    'id' => $comment->user->id,
                    'name' => $comment->user->name,
                    'avatar' => $comment->user->avatar,
                ],
            ];
            if ($notificationData['commented_to']) {
                broadcast(new \App\Events\NewPostComment($notificationData));
                $postOwner->notify(new \App\Notifications\PostCommentNotification($notificationData));
            }
        } catch (\Throwable $e) {
            Log::warning('EngagementService: comment notification failed', ['e' => $e->getMessage()]);
        }
    }

    private function pickWeighted(array $weights): string
    {
        $sum = array_sum($weights);
        if ($sum <= 0) {
            return array_key_first($weights);
        }
        $rand = random_int(1, $sum);
        $cumulative = 0;
        foreach ($weights as $key => $w) {
            $cumulative += (int) $w;
            if ($rand <= $cumulative) return (string) $key;
        }
        return (string) array_key_first($weights);
    }

    private function pickWeightedId(array $weightsById): ?int
    {
        if (empty($weightsById)) return null;
        $sum = array_sum($weightsById);
        if ($sum <= 0) {
            return (int) array_key_first($weightsById);
        }
        $rand = random_int(1, $sum);
        $cumulative = 0;
        foreach ($weightsById as $id => $w) {
            $cumulative += (int) $w;
            if ($rand <= $cumulative) return (int) $id;
        }
        return (int) array_key_first($weightsById);
    }
}


