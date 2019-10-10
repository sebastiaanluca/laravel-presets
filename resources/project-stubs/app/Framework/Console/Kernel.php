<?php

declare(strict_types=1);

namespace Framework\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Laravel\Horizon\Console\SnapshotCommand as SnapshotHorizon;
use Laravel\Telescope\Console\PruneCommand as PruneTelescopeEntries;
use Spatie\Backup\Commands\BackupCommand as BackUp;
use Spatie\Backup\Commands\CleanupCommand as CleanBackups;
use Spatie\Backup\Commands\MonitorCommand as MonitorBackups;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() : void
    {
        $this->load(base_path('app/Interfaces/Cli/Commands'));
    }

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule) : void
    {
        $this->scheduleMaintenanceJobs($schedule);
        $this->scheduleBackupJobs($schedule);
    }

    /**
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function scheduleMaintenanceJobs(Schedule $schedule) : void
    {
        $schedule->command(SnapshotHorizon::class)->everyFiveMinutes();
        $schedule->command(PruneTelescopeEntries::class, ['--hours' => 168])->daily();
    }

    /**
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function scheduleBackupJobs(Schedule $schedule) : void
    {
        if (app()->environment('production')) {
            $schedule->command(BackUp::class)->hourly();
        } else {
            $schedule->command(BackUp::class)->daily();
        }

        $schedule->command(CleanBackups::class)->daily()->at('03:00');
        $schedule->command(MonitorBackups::class)->daily()->at('04:00');
    }
}
