<?php

namespace App\Console;

use App\Console\Commands\UpdateAccountBalance;
use App\Jobs\DeleteOldCronJobLogs;
use App\Jobs\UpdateAccountBalanceJob;
use App\Jobs\UpdateProductSellPricesJob;
use App\Models\CronJobLog;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Log before and after the UpdateAccountBalanceJob
        $schedule->job(new UpdateAccountBalanceJob())
            ->everyMinute() // Adjust as needed
            ->before(function () {
                $this->logCronJob('UpdateAccountBalanceJob', 'initiated');
            })
            ->after(function () {
                $this->logCronJob('UpdateAccountBalanceJob', 'completed');
            });

        // Log before and after the UpdateProductSellPricesJob
        $schedule->job(new UpdateProductSellPricesJob())
            ->hourly()
            ->before(function () {
                $this->logCronJob('UpdateProductSellPricesJob', 'initiated');
            })
            ->after(function () {
                $this->logCronJob('UpdateProductSellPricesJob', 'completed');
            });

        $schedule->job(new DeleteOldCronJobLogs())->dailyAt('00:00');
    }

    /**
     * Log the cron job execution in the cron_job_logs table.
     *
     * @param string $command
     * @param string $status
     */
    private function logCronJob(string $command, string $status)
    {
        CronJobLog::create([
            'command' => $command,
            'status' => $status,
            'executed_at' => now(),
        ]);
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
