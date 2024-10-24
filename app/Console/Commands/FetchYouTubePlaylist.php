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
        $apiKey = env('YOUTUBE_API_KEY');
        $playlists = [
            'featured' => env('YOUTUBE_PLAYLIST_ID_FEATURED'),
            'another' => env('YOUTUBE_PLAYLIST_ID_ANOTHER'),
        ];
        $maxResults = 50;

        foreach ($playlists as $type => $playlistId) {
            $this->info("Fetching playlist: {$type} ({$playlistId})");

            $url = "https://www.googleapis.com/youtube/v3/playlistItems";
            $response = Http::get($url, [
                'part' => 'snippet',
                'playlistId' => $playlistId,
                'maxResults' => $maxResults,
                'key' => $apiKey,
            ]);

            if ($response->successful()) {
                $videos = collect($response->json()['items'])->map(function ($item) use ($playlistId) {
                    return [
                        'id' => $item['id'],
                        'title' => $item['snippet']['title'],
                        'description' => $item['snippet']['description'],
                        'thumbnail_url' => $item['snippet']['thumbnails']['high']['url'],
                        'youtube_id' => $item['snippet']['resourceId']['videoId'],
                        'playlist_id' => $playlistId,
                        'channel_title' => $item['snippet']['channelTitle'] ?? null,
                        'published_at' => isset($item['snippet']['publishedAt'])
                            ? Carbon::parse($item['snippet']['publishedAt'])->format('Y-m-d H:i:s')
                            : null,
                    ];
                });

                // Remove existing videos for this playlist
                Video::where('playlist_id', $playlistId)->delete();

                // Insert new videos
                Video::insert($videos->toArray());

                $this->info("Successfully cached {$videos->count()} videos for playlist: {$type}.");
            } else {
                $this->error("Failed to fetch playlist: {$type}.");
                $this->error('Response: ' . $response->body());
            }
        }

        $this->info('All playlists have been processed.');
    }
}
