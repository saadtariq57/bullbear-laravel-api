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

    // Engagement Logs Cleanup - Run every 48 hours at 2:00 AM to keep 48 hours of data
    $schedule->command('engagement:flush-old-logs')->cron('0 2 */2 * *')->appendOutputTo(storage_path('logs/engagement-cleanup.log'));

    // Watchlist price threshold alerts
    $schedule->command('watchlist:check-thresholds')->everyFiveMinutes();
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
