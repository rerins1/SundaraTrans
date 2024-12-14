<?php

namespace App\Console;

use App\Models\LockedSeat;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected $commands = [
        Commands\ClearExpiredLockedSeats::class,
    ];
    
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('seats:clear-expired')->everyMinute();

        $schedule->command('seats:release-daily')->dailyAt('00:00');

        $schedule->call(function () {
            LockedSeat::where('expired_at', '<', now())->delete();
        })->everyMinute();
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