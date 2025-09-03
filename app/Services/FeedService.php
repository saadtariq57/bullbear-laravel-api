<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
 

class FeedService
{
    private const DEFAULT_WINDOW_HOURS = 24;
    private const CANDIDATE_LIMIT = 400; // maximum items to score per request

    public function getFeedForUser(?User $user, array $options = []): LengthAwarePaginator
    {
        $sinceHours = (int) ($options['since_hours'] ?? self::DEFAULT_WINDOW_HOURS);
        $lastPostId = $options['lastPostId'] ?? null;
        $perPage = (int) ($options['per_page'] ?? 10);

        // Guest fallback: trending feed only
        if ($user === null) {
            return $this->getTrendingFeed($sinceHours, $perPage, $lastPostId);
        }

        // Build feed fresh on every request (no server-side caching)
        $candidates = $this->fetchCandidates($user, $sinceHours, $lastPostId);

        // If empty, widen window to 7d then 30d and include trending
        if ($candidates->isEmpty()) {
            $fallback = $this->getTrendingFeed(max($sinceHours, 168), $perPage, $lastPostId, $user);
            if ($fallback->total() > 0) return $fallback;
            return $this->getTrendingFeed(720, $perPage, $lastPostId, $user);
        }

        $scored = $this->scoreCandidates($user, $candidates);

        if ($scored->isEmpty()) {
            return $this->getTrendingFeed(max($sinceHours, 168), $perPage, $lastPostId, $user);
        }

        // Paginate manually: we already have rich eager-loaded posts
        $total = $scored->count();
        $page = 1; // cursor-based via lastPostId
        $items = $scored->take($perPage)->values();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [ 'path' => request()->url(), 'query' => request()->query() ]
        );
    }

    public function getTrendingFeed(int $sinceHours, int $perPage, $lastPostId, ?User $user = null): LengthAwarePaginator
    {
        $since = now()->subHours(max(1, $sinceHours));
        $query = Post::with([
                'user:id,name,avatar',
                'photos',
                'poll.options',
                'poll.userVotes' => function ($q) use ($user) { if ($user) $q->where('user_id', $user->id); },
                'coloredPost',
                'reactions' => function ($q) {
                    $q->with('reactionType:id,name,icon')
                      ->with('user:id,name,avatar,about');
                },
                'sharedPost.user:id,name,avatar',
                'sharedPost.photos',
                'sharedPost.poll.options',
                'sharedPost.poll.userVotes' => function ($q) use ($user) { if ($user) $q->where('user_id', $user->id); },
                'sharedPost.coloredPost',
                'sharedPost.reactions' => function ($q) {
                    $q->with('reactionType:id,name,icon')
                      ->with('user:id,name,avatar,about');
                },
            ])
            ->withCount(['comments', 'reactions'])
            ->where('active', 1)
            ->where('created_at', '>=', $since)
            ->when($lastPostId, fn($q) => $q->where('id', '<', (int) $lastPostId))
            ->orderByDesc('reactions_count')
            ->orderByDesc('comments_count')
            ->orderByDesc('created_at')
            ->limit(self::CANDIDATE_LIMIT);

        $posts = $query->get();

        $total = $posts->count();
        $items = $posts->take($perPage)->values();
        return new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            1,
            [ 'path' => request()->url(), 'query' => request()->query() ]
        );
    }

    private function fetchCandidates(User $user, int $sinceHours, $lastPostId): Collection
    {
        $since = now()->subHours(max(1, $sinceHours));

        $groupIds = $user->groupMemberships()->pluck('group_id');
        $followingIds = $user->followings()->pluck('following_id');

        $query = Post::with([
                'user:id,name,avatar',
                'user' => function ($q) { $q->withCount('followers'); },
                'photos',
                'poll.options',
                'poll.userVotes' => function ($q) use ($user) { $q->where('user_id', $user->id); },
                'coloredPost',
                'reactions' => function ($q) { $q->with('reactionType:id,name,icon')->with('user:id,name,avatar,about'); },
                'sharedPost.user:id,name,avatar',
                'sharedPost.photos',
                'sharedPost.poll.options',
                'sharedPost.poll.userVotes' => function ($q) use ($user) { $q->where('user_id', $user->id); },
                'sharedPost.coloredPost',
                'sharedPost.reactions' => function ($q) { $q->with('reactionType:id,name,icon')->with('user:id,name,avatar,about'); },
            ])
            ->withCount(['comments', 'reactions'])
            ->where('active', 1)
            ->where('created_at', '>=', $since)
            ->orderByDesc('created_at');

        if ($lastPostId) {
            $query->where('id', '<', (int) $lastPostId);
        }

        // Build a wide pool: followings, groups, and global trending as fallback
        $query->where(function ($q) use ($groupIds, $followingIds, $user) {
            $q->whereIn('user_id', $followingIds)
              ->orWhereIn('group_id', $groupIds)
              ->orWhere('user_id', $user->id);
        });

        $initial = $query->limit(self::CANDIDATE_LIMIT)->get();

        // If pool thin, add global trending slice (still within since window)
        if ($initial->count() < (int) (self::CANDIDATE_LIMIT * 0.6)) {
            $trending = Post::with(['user:id,name,avatar'])
                ->withCount(['comments','reactions'])
                ->where('active', 1)
                ->where('created_at', '>=', $since)
                ->when($lastPostId, fn($q) => $q->where('id', '<', (int) $lastPostId))
                ->orderByDesc('reactions_count')
                ->orderByDesc('comments_count')
                ->limit(self::CANDIDATE_LIMIT - $initial->count())
                ->get();
            $initial = $initial->merge($trending);
        }

        return $initial;
    }

    private function scoreCandidates(User $user, Collection $posts): Collection
    {
        // Preload signals
        $followingIds = $user->followings()->pluck('following_id')->toArray();
        $groupIds = $user->groupMemberships()->pluck('group_id')->toArray();

        // Weights (can be moved to config)
        $wFollowing = 4.0;
        $wGroup = 2.0;
        $wEngagement = 1.2;
        $wCreator = 1.0;

        $nowTs = now()->getTimestamp();
        $daySec = 86400;

        $scored = $posts->map(function (Post $post) use ($followingIds, $groupIds, $wFollowing, $wGroup, $wEngagement, $wCreator, $nowTs, $daySec) {
            $isFollowing = in_array($post->user_id, $followingIds, true) ? 1 : 0;
            $isSameGroup = $post->group_id && in_array($post->group_id, $groupIds, true) ? 1 : 0;

            $eng = (int) $post->reactions_count + 2 * (int) $post->comments_count;
            $engNorm = min(1.0, log(1 + $eng) / 5.0);

            $creatorFollowers = (int) ($post->user->followers_count ?? 0);
            $creatorQuality = min(1.0, log(1 + $creatorFollowers) / 8.0);

            $ageSec = max(1, $nowTs - $post->created_at->getTimestamp());
            $recencyDecay = exp(-$ageSec / (2 * $daySec));

            $score = ($wFollowing * $isFollowing)
                   + ($wGroup * $isSameGroup)
                   + ($wEngagement * $engNorm)
                   + ($wCreator * $creatorQuality)
                   + $recencyDecay;

            $post->feed_score = $score;
            return $post;
        });

        // Diversity: downweight repeated creators beyond 2 in top list
        $seenByUser = [];
        $scored = $scored->sortByDesc('feed_score')->values()->map(function (Post $p) use (&$seenByUser) {
            $cnt = ($seenByUser[$p->user_id] ?? 0) + 1;
            $seenByUser[$p->user_id] = $cnt;
            if ($cnt > 2) {
                $p->feed_score *= 0.85; // slight penalty
            }
            return $p;
        })->sortByDesc('feed_score')->values();

        return $scored;
    }
}


