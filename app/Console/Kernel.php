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
        Commands\CleanupExpiredTickets::class,
    ];
    
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('seats:clear-expired')->everyMinute();

        $schedule->command('seats:release-daily')->dailyAt('00:00');

       // Jalankan reset kursi setiap hari jam 00:00
        $schedule->command('bus:reset-seats')->dailyAt('00:00');
        
        // Bersihkan locked seats yang expired setiap 5 menit
        $schedule->call(function () {
            LockedSeat::cleanExpiredLocks();
        })->everyFiveMinutes();

        // Jalankan setiap menit untuk pengecekan real-time
        $schedule->command('tickets:cleanup')->everyMinute();
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