<?php

namespace App\Console\Commands;

use App\Models\EngagementLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class FlushOldEngagementLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'engagement:flush-old-logs {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush engagement logs older than 48 hours, keeping only recent logs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        $cutoffTime = Carbon::now()->subHours(48);
        
        $this->info("Engagement Logs Cleanup");
        $this->info("=====================");
        $this->info("Cutoff time: {$cutoffTime->format('Y-m-d H:i:s')} (48 hours ago)");
        $this->newLine();

        // Get total count of engagement logs
        $totalLogs = EngagementLog::count();
        $this->info("Total engagement logs in database: {$totalLogs}");

        // Get count of logs to be deleted
        $logsToDelete = EngagementLog::where('created_at', '<', $cutoffTime)->count();
        $logsToKeep = $totalLogs - $logsToDelete;
        
        $this->info("Logs to be deleted (older than 48h): {$logsToDelete}");
        $this->info("Logs to be kept (last 48h): {$logsToKeep}");
        $this->newLine();

        if ($logsToDelete === 0) {
            $this->info("✅ No old logs found. All logs are within the last 48 hours.");
            return 0;
        }

        if ($isDryRun) {
            $this->warn("🔍 DRY RUN MODE - No logs will be deleted");
            $this->newLine();
            
            // Show some sample logs that would be deleted
            $sampleLogs = EngagementLog::where('created_at', '<', $cutoffTime)
                ->with(['bot.user:id,name', 'post:id,post_text'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            if ($sampleLogs->count() > 0) {
                $this->info("Sample logs that would be deleted:");
                $this->table(
                    ['ID', 'Bot Name', 'Action', 'Sentiment', 'Created At'],
                    $sampleLogs->map(function ($log) {
                        return [
                            $log->id,
                            $log->bot->user->name ?? 'Unknown',
                            $log->action_type,
                            $log->sentiment,
                            $log->created_at->format('Y-m-d H:i:s')
                        ];
                    })
                );
            }
            
            return 0;
        }

        // No confirmation needed - this is an automated cleanup command

        // Perform the deletion
        $this->info("🗑️  Deleting old engagement logs...");
        
        try {
            DB::beginTransaction();
            
            $deletedCount = EngagementLog::where('created_at', '<', $cutoffTime)->delete();
            
            DB::commit();
            
            $this->info("✅ Successfully deleted {$deletedCount} engagement logs.");
            $this->info("📊 Remaining logs: " . EngagementLog::count());
            
            // Log the cleanup activity
            Log::info('Engagement logs cleanup completed', [
                'deleted_count' => $deletedCount,
                'cutoff_time' => $cutoffTime->toISOString(),
                'remaining_count' => EngagementLog::count()
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Error deleting logs: " . $e->getMessage());
            Log::error('Engagement logs cleanup failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }

        return 0;
    }
}
