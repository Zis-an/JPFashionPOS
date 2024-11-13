<?php

namespace App\Jobs;

use App\Models\CronJobLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DeleteOldCronJobLogs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Get the date 1 days ago
        $sevenDaysAgo = Carbon::now()->subDays(1);

        // Delete CronJobLog entries older than 1 days
        CronJobLog::where('created_at', '<', $sevenDaysAgo)->delete();

        // Optionally, log that the cleanup has occurred (for monitoring purposes)
        Log::info('Deleted CronJobLogs older than 1 days');
    }
}