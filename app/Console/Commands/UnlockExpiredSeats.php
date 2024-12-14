<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\LockedSeat;
use App\Models\Ticket;

class UnlockExpiredSeats extends Command
{
    protected $signature = 'unlock:expired-seats';
    protected $description = 'Unlock seats for buses whose departure time has passed by 1 hour';

    public function handle()
    {
        $now = Carbon::now();
        $expiredSeats = LockedSeat::whereHas('ticket', function ($query) use ($now) {
            $query->where('departure_time', '<', $now->subHour());
        })->delete();

        $this->info('Expired seats have been unlocked.');
    }
}