<?php

namespace App\Console;

use App\Console\Commands\CreateRepository;
use App\Console\Commands\CreateRepositoryInterFace;
use App\Console\Commands\CreateService;
use App\Console\Commands\MigrateMonthlyTable;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CreateRepository::class,
        CreateRepositoryInterFace::class,
        CreateService::class,
        MigrateMonthlyTable::class
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('migrate:monthly')->monthly();
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
