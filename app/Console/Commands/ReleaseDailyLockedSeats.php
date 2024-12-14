<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LockedSeat;

class ReleaseDailyLockedSeats extends Command
{
    protected $signature = 'seats:release-daily';
    protected $description = 'Release all locked seats for the day';

    public function handle()
    {
        LockedSeat::where('expired_at', '<', now())->delete();
        $this->info('All expired seats have been released.');
    }
}

