<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
{
    // YouTube Playlist Fetch Command
    $schedule->command('youtube:fetch-playlists')->dailyAt('03:00');

    // Sitemap Commands
    $schedule->command('sitemap:generate-quotes')->dailyAt('04:00');
    $schedule->command('sitemap:generate-blog-posts')->weeklyOn(1, '05:00'); // Runs every Monday at 5:00 AM
}

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
