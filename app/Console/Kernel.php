<?php

namespace App\Console;

use App\Console\Commands\UpdateAccountBalance;
use App\Jobs\DeleteOldCronJobLogs;
use App\Jobs\UpdateAccountBalanceJob;
use App\Jobs\UpdateCustomerBalance;
use App\Jobs\UpdateProductionHouseBalance;
use App\Jobs\UpdateProductSellPricesJob;
use App\Jobs\UpdateSupplierBalance;
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

        $schedule->job(new UpdateCustomerBalance())
            ->hourly()
            ->before(function () {
                $this->logCronJob('UpdateCustomerBalance', 'initiated');
            })
            ->after(function () {
                $this->logCronJob('UpdateCustomerBalance', 'completed');
            });

        $schedule->job(new UpdateSupplierBalance())
            ->hourly()
            ->before(function () {
                $this->logCronJob('UpdateSupplierBalance', 'initiated');
            })
            ->after(function () {
                $this->logCronJob('UpdateSupplierBalance', 'completed');
            });

        $schedule->job(new UpdateProductionHouseBalance())
            ->hourly()
            ->before(function () {
                $this->logCronJob('UpdateProductionHouseBalance', 'initiated');
            })
            ->after(function () {
                $this->logCronJob('UpdateProductionHouseBalance', 'completed');
            });

        $schedule->job(new DeleteOldCronJobLogs())
            ->daily()
            ->before(function () {
                $this->logCronJob('DeleteOldCronJobLogs', 'initiated');
            })
            ->after(function () {
                $this->logCronJob('DeleteOldCronJobLogs', 'completed');
            });
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
