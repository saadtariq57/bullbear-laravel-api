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
        // $schedule->command('inspire')->hourly();
        $schedule->command('youtube:fetch-playlists')->daily();

        // sitemap

        $schedule->command('sitemap:generate-quotes')->daily();
        $schedule->command('sitemap:generate-blog-categories')->weekly();
        $schedule->command('sitemap:generate-blog-posts')->weekly();
        $schedule->command('sitemap:generate-markets')->daily();
        $schedule->command('sitemap:generate-pages')->monthly();
        $schedule->command('sitemap:generate-index')->daily();
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
