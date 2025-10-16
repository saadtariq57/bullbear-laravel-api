<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
 

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
        Log::info('FeedService candidates', [
            'user_id' => $user->id,
            'since_hours' => $sinceHours,
            'lastPostId' => $lastPostId,
            'candidate_count' => $candidates->count(),
        ]);

        // If empty, widen window to 7d then 30d and include trending
        if ($candidates->isEmpty()) {
            $fallback = $this->getTrendingFeed(max($sinceHours, 168), $perPage, $lastPostId, $user);
            if ($fallback->total() > 0) return $fallback;
            Log::info('FeedService fallback to 30d trending');
            return $this->getTrendingFeed(720, $perPage, $lastPostId, $user);
        }

        // Backfill when the pool is smaller than a single page (sparse days)
        if ($candidates->count() < $perPage) {
            // First widen to 7 days
            $fallback7dPaginator = $this->getTrendingFeed(max($sinceHours, 168), self::CANDIDATE_LIMIT, $lastPostId, $user);
            $fallback7d = collect($fallback7dPaginator->items());
            if ($fallback7d->isNotEmpty()) {
                $candidates = $candidates
                    ->concat($fallback7d)
                    ->unique('id')
                    ->take(self::CANDIDATE_LIMIT)
                    ->values();
                Log::info('FeedService backfill 7d', ['added' => $fallback7d->count(), 'total' => $candidates->count()]);
            }

            // If still thin, widen to 30 days
            if ($candidates->count() < $perPage) {
                $fallback30dPaginator = $this->getTrendingFeed(720, self::CANDIDATE_LIMIT, $lastPostId, $user);
                $fallback30d = collect($fallback30dPaginator->items());
                if ($fallback30d->isNotEmpty()) {
                    $candidates = $candidates
                        ->concat($fallback30d)
                        ->unique('id')
                        ->take(self::CANDIDATE_LIMIT)
                        ->values();
                    Log::info('FeedService backfill 30d', ['added' => $fallback30d->count(), 'total' => $candidates->count()]);
                }
            }
        }

        $scored = $this->scoreCandidates($user, $candidates);

        if ($scored->isEmpty()) {
            Log::info('FeedService scored empty, fallback trending 7d');
            return $this->getTrendingFeed(max($sinceHours, 168), $perPage, $lastPostId, $user);
        }

        // Paginate manually: we already have rich eager-loaded posts
        $total = $scored->count();
        $page = 1; // cursor-based via lastPostId
        $items = $scored->take($perPage)->values();

        Log::info('FeedService paginate', ['returning' => $items->count(), 'total' => $total]);
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
            ->whereHas('user', function ($u) {
                $u->where('post_privacy', 'Everyone');
            })
            // Trending should only include globally visible posts
            ->whereIn('post_privacy', ['public', 'Public', 'Everyone'])
            ->where('created_at', '>=', $since)
            ->when($lastPostId, fn($q) => $q->where('id', '<', (int) $lastPostId))
            ->orderByDesc('reactions_count')
            ->orderByDesc('comments_count')
            ->orderByDesc('created_at')
            ->limit(self::CANDIDATE_LIMIT);

        $posts = $query->get();
        Log::info('FeedService trending query', ['since_hours' => $sinceHours, 'fetched' => $posts->count()]);

        // Transform posts to handle shared content
        $posts->transform(function ($post) use ($user) {
            // Handle shared post if exists
            if ($post->sharedPost) {
                $sharedPost = $post->sharedPost;

                // Apply similar transformations to the shared post
                switch ($sharedPost->post_type) {
                    case 'photo':
                        break;

                    case 'poll':
                        if ($sharedPost->poll) {
                            $sharedPost->poll->options = $sharedPost->poll->options;
                            // Check if the user has voted
                            if ($sharedPost->poll->userVotes->isNotEmpty()) {
                                $sharedPost->poll->userVoted = true;
                                $sharedPost->poll->userVoteOption = $sharedPost->poll->userVotes->first()->option_id;
                            } else {
                                $sharedPost->poll->userVoted = false;
                            }
                        }
                        unset($sharedPost->pollDetails);
                        break;

                    case 'color':
                        unset($sharedPost->colorDetails);
                        break;
                }

                // Expose original shared content consistently to the frontend
                // Ensure relations are preserved
                $sharedPost->setRelation('user', $sharedPost->user);
                if ($sharedPost->coloredPost) {
                    $sharedPost->setRelation('coloredPost', $sharedPost->coloredPost);
                }
                $post->originalPost = $sharedPost;
                // Avoid duplicating the same payload under two keys
                $post->unsetRelation('sharedPost');
            }

            return $post;
        });

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
        Log::info('FeedService memberships', [
            'user_id' => $user->id,
            'groups_count' => $groupIds->count(),
            'following_count' => $followingIds->count(),
        ]);

        $query = Post::with([
                'user:id,name,avatar,type',
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

        // Build a wide pool with privacy awareness:
        // - User's own posts
        // - Posts in groups the user belongs to
        // - Public/Everyone posts from anyone (non-group)
        // - Followed creators' posts when their privacy is Followers/Friends or Public/Everyone
        $query->where(function ($q) use ($groupIds, $followingIds, $user) {
            // Always include viewer's own posts
            $q->orWhere('user_id', $user->id)
              // Include posts from groups the viewer belongs to
              ->orWhereIn('group_id', $groupIds)
              // Include global public/everyone posts (exclude group posts to avoid leaking group content)
              ->orWhere(function ($q4) {
                  $q4->whereNull('group_id')
                     ->whereIn('post_privacy', ['public', 'Public', 'Everyone']);
              })
              // Include any creator who set profile visibility to Everyone (non-group)
              ->orWhere(function ($q5) {
                  $q5->whereNull('group_id')
                     ->whereHas('user', function ($u) {
                         $u->where('post_privacy', 'Everyone');
                     });
              })
              // Include followed creators' posts that are visible to followers/public
              ->orWhere(function ($q2) use ($followingIds) {
                  $q2->whereIn('user_id', $followingIds)
                     ->whereHas('user', function ($u) {
                         $u->whereIn('post_privacy', ['Followers', 'Everyone']);
                     })
                     ->whereIn('post_privacy', ['followers', 'Followers', 'Friends', 'public', 'Public', 'Everyone'])
                     // Safety: legacy/null privacy treated as public
                     ->orWhere(function ($q3) use ($followingIds) {
                         $q3->whereIn('user_id', $followingIds)
                            ->whereNull('post_privacy');
                     });
              });
        });

        $initial = $query->limit(self::CANDIDATE_LIMIT)->get();
        Log::info('FeedService initial pool', ['count' => $initial->count()]);

        // If pool thin, add global trending slice (still within since window)
        if ($initial->count() < (int) (self::CANDIDATE_LIMIT * 0.6)) {
            $trending = Post::with(['user:id,name,avatar,type'])
                ->withCount(['comments','reactions'])
                ->where('active', 1)
                ->whereHas('user', function ($u) {
                    $u->where('post_privacy', 'Everyone');
                })
                ->whereIn('post_privacy', ['public', 'Public', 'Everyone'])
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

        $scored = $posts->map(function (Post $post) use ($user, $followingIds, $groupIds, $wFollowing, $wGroup, $wEngagement, $wCreator, $nowTs, $daySec) {
            // Handle shared post if exists
            if ($post->sharedPost) {
                $sharedPost = $post->sharedPost;

                // Apply similar transformations to the shared post
                switch ($sharedPost->post_type) {
                    case 'photo':
                        break;

                    case 'poll':
                        if ($sharedPost->poll) {
                            $sharedPost->poll->options = $sharedPost->poll->options;
                            // Check if the user has voted
                            if ($sharedPost->poll->userVotes->isNotEmpty()) {
                                $sharedPost->poll->userVoted = true;
                                $sharedPost->poll->userVoteOption = $sharedPost->poll->userVotes->first()->option_id;
                            } else {
                                $sharedPost->poll->userVoted = false;
                            }
                        }
                        unset($sharedPost->pollDetails);
                        break;

                    case 'color':
                        unset($sharedPost->colorDetails);
                        break;
                }

                // Expose original shared content consistently to the frontend
                // Ensure relations are preserved
                $sharedPost->setRelation('user', $sharedPost->user);
                if ($sharedPost->coloredPost) {
                    $sharedPost->setRelation('coloredPost', $sharedPost->coloredPost);
                }
                $post->originalPost = $sharedPost;
                // Avoid duplicating the same payload under two keys
                $post->unsetRelation('sharedPost');
            }

            $isFollowing = in_array($post->user_id, $followingIds, true) ? 1 : 0;
            $isSameGroup = $post->group_id && in_array($post->group_id, $groupIds, true) ? 1 : 0;
            $isUserPost = $post->user_id === $user->id ? 1 : 0;

            $eng = (int) $post->reactions_count + 2 * (int) $post->comments_count;
            $engNorm = min(1.0, log(1 + $eng) / 5.0);

            $creatorFollowers = (int) ($post->user->followers_count ?? 0);
            $creatorQuality = min(1.0, log(1 + $creatorFollowers) / 8.0);

            $ageSec = max(1, $nowTs - $post->created_at->getTimestamp());
            $ageHours = $ageSec / 3600;
            
            // Enhanced recency decay with user post boost
            $recencyDecay = exp(-$ageSec / (2 * $daySec));
            
            // User post priority: Strong boost for 30 minutes, then smooth blend with normal timeline
            $userPostBoost = 0;
            if ($isUserPost) {
                $ageMinutes = $ageHours * 60; // Convert to minutes
                if ($ageMinutes <= 30) {
                    // Very recent user posts (0-30 minutes): Strong boost for top visibility
                    $userPostBoost = 3.0 + (30 - $ageMinutes) * 0.1; // 3.0 to 6.0 boost
                } elseif ($ageMinutes <= 60) {
                    // Recent user posts (30-60 minutes): Gradual decline to blend with timeline
                    $userPostBoost = 2.0 + (60 - $ageMinutes) * 0.033; // 2.0 to 3.0 boost
                } elseif ($ageHours <= 4) {
                    // Moderately recent user posts (1-4 hours): Small boost to stay visible
                    $userPostBoost = 1.0 + (4 - $ageHours) * 0.25; // 1.0 to 2.0 boost
                } elseif ($ageHours <= 8) {
                    // Older user posts (4-8 hours): Minimal boost to blend naturally
                    $userPostBoost = 0.5 + (8 - $ageHours) * 0.125; // 0.5 to 1.0 boost
                } elseif ($ageHours <= 24) {
                    // Day-old user posts: Very small boost for personal relevance
                    $userPostBoost = 0.3 + (24 - $ageHours) * 0.02; // 0.3 to 0.5 boost
                } else {
                    // Very old user posts: No boost, pure timeline
                    $userPostBoost = 0;
                }
            }

            // Enhanced recency boost for all very recent posts (rebalanced)
            $recencyBoost = 0;
            if ($ageHours <= 1) {
                $recencyBoost = 1.0; // Moderate boost for posts < 1 hour
            } elseif ($ageHours <= 2) {
                $recencyBoost = 0.5; // Small boost for posts 1-2 hours
            } elseif ($ageHours <= 4) {
                $recencyBoost = 0.2; // Minimal boost for posts 2-4 hours
            }

            $score = ($wFollowing * $isFollowing)
                   + ($wGroup * $isSameGroup)
                   + ($wEngagement * $engNorm)
                   + ($wCreator * $creatorQuality)
                   + $recencyDecay
                   + $userPostBoost
                   + $recencyBoost;

            $post->feed_score = $score;
            $post->debug_score_breakdown = [
                'base_score' => ($wFollowing * $isFollowing) + ($wGroup * $isSameGroup) + ($wEngagement * $engNorm) + ($wCreator * $creatorQuality) + $recencyDecay,
                'user_post_boost' => $userPostBoost,
                'recency_boost' => $recencyBoost,
                'age_hours' => round($ageHours, 2),
                'is_user_post' => $isUserPost
            ];
            return $post;
        });

        // Diversity: downweight repeated creators beyond 2 in top list (but be gentler on user posts)
        $seenByUser = [];
        $scored = $scored->sortByDesc('feed_score')->values()->map(function (Post $p) use (&$seenByUser, $user) {
            $cnt = ($seenByUser[$p->user_id] ?? 0) + 1;
            $seenByUser[$p->user_id] = $cnt;
            
            // Apply diversity penalty, but be more lenient for user's own posts
            if ($cnt > 2) {
                if ($p->user_id === $user->id) {
                    // User's own posts: lighter penalty (allow up to 4-5 user posts)
                    if ($cnt > 4) {
                        $p->feed_score *= 0.90; // lighter penalty for user posts
                    }
                } else {
                    // Other users' posts: normal penalty
                    $p->feed_score *= 0.85;
                }
            }
            return $p;
        })->sortByDesc('feed_score')->values();

        // Special handling: Only guarantee top positions for user posts within 30 minutes
        $userVeryRecentPosts = $scored->filter(function ($post) use ($user) {
            $ageMinutes = now()->diffInMinutes($post->created_at);
            return $post->user_id === $user->id && $ageMinutes <= 30;
        })->sortByDesc('created_at')->take(3); // Limit to top 3 very recent user posts

        // All other posts (non-user posts + user posts >30min)
        $otherPosts = $scored->filter(function ($post) use ($user) {
            $ageMinutes = now()->diffInMinutes($post->created_at);
            return $post->user_id !== $user->id || ($post->user_id === $user->id && $ageMinutes > 30);
        });

        // Recombine: top 3 very recent user posts first, then all others by score
        $finalScored = $userVeryRecentPosts->concat($otherPosts);

        return $finalScored;
    }
}


