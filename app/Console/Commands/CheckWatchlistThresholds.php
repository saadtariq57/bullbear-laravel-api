<?php

namespace App\Console\Commands;

use App\Services\WatchlistThresholdService;
use Illuminate\Console\Command;

class CheckWatchlistThresholds extends Command
{
    protected $signature = 'watchlist:check-thresholds';

    protected $description = 'Check watchlist price thresholds and notify users';

    public function handle(WatchlistThresholdService $service): int
    {
        $count = $service->checkAndNotify();
        $this->info("Watchlist threshold check complete. Notifications sent: {$count}");

        return self::SUCCESS;
    }
}
