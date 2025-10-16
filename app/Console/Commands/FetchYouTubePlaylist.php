<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Video;
use Carbon\Carbon; // Import Carbon for date handling

class FetchYouTubePlaylist extends Command
{
    protected $signature = 'youtube:fetch-playlists';
    protected $description = 'Fetch multiple YouTube playlist videos and cache them';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Prefer config values; fall back to env() if config entries are missing
        $apiKey = config('services.youtube.key');
        if (!$apiKey) {
            $apiKey = env('YOUTUBE_API_KEY');
        }

        $playlists = config('services.youtube.playlists', []);
        if (empty($playlists)) {
            $playlists = [
                'featured' => env('YOUTUBE_PLAYLIST_ID_FEATURED'),
                'another' => env('YOUTUBE_PLAYLIST_ID_ANOTHER'),
            ];
        }
        $maxResults = 50; // API max

        foreach ($playlists as $type => $playlistId) {
            $this->info("Fetching playlist: {$type} ({$playlistId})");

            $url = "https://www.googleapis.com/youtube/v3/playlistItems";

            $allItems = collect();
            $pageToken = null;
            $page = 0;

            do {
                $params = [
                    'part' => 'snippet,contentDetails',
                    'playlistId' => $playlistId,
                    'maxResults' => $maxResults,
                    'key' => $apiKey,
                ];
                if ($pageToken) {
                    $params['pageToken'] = $pageToken;
                }

                $response = Http::get($url, $params);
                if (!$response->successful()) {
                    $this->error("Failed to fetch playlist page {$page} for: {$type}.");
                    $this->error('Response: ' . $response->body());
                    break;
                }

                $json = $response->json();
                $items = collect($json['items'] ?? []);
                $allItems = $allItems->merge($items);
                $pageToken = $json['nextPageToken'] ?? null;
                $page++;
            } while ($pageToken);

            $videos = $allItems
                ->filter(function ($item) {
                    $thumbs = $item['snippet']['thumbnails'] ?? [];
                    return isset($thumbs['high']['url']) || isset($thumbs['medium']['url']) || isset($thumbs['default']['url']);
                })
                ->map(function ($item) use ($playlistId) {
                    $snippet = $item['snippet'] ?? [];
                    $details = $item['contentDetails'] ?? [];
                    $thumbs = $snippet['thumbnails'] ?? [];
                    $thumb = $thumbs['high']['url'] ?? ($thumbs['medium']['url'] ?? ($thumbs['default']['url'] ?? null));

                    $published = $details['videoPublishedAt'] ?? ($snippet['publishedAt'] ?? null);
                    $publishedAt = $published ? Carbon::parse($published)->format('Y-m-d H:i:s') : null;

                    return [
                        'id' => $item['id'],
                        'title' => $snippet['title'] ?? null,
                        'description' => $snippet['description'] ?? null,
                        'thumbnail_url' => $thumb,
                        'youtube_id' => $details['videoId'] ?? ($snippet['resourceId']['videoId'] ?? null),
                        'playlist_id' => $playlistId,
                        'channel_title' => $snippet['channelTitle'] ?? null,
                        'published_at' => $publishedAt,
                    ];
                });

            // Remove existing videos for this playlist
            Video::where('playlist_id', $playlistId)->delete();

            // Insert new videos
            if ($videos->isNotEmpty()) {
                Video::insert($videos->toArray());
            }

            $this->info("Successfully cached {$videos->count()} videos for playlist: {$type}.");
        }

        $this->info('All playlists have been processed.');
    }
}
