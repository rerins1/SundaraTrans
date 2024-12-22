<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LockedSeat;
use Carbon\Carbon;

class ClearExpiredLockedSeats extends Command
{
    protected $signature = 'seats:clear-expired';
    protected $description = 'Hapus kursi yang terkunci setelah kedaluwarsa';

    public function handle()
    {
        LockedSeat::where('locked_until', '<', Carbon::now())->delete();
        $this->info('Kursi yang kedaluwarsa telah dihapus.');
    }
}