<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\LockedSeat;
use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ResetBusSeats extends Command
{
    protected $signature = 'bus:reset-seats';
    protected $description = 'Reset semua kursi bus yang sudah lewat tanggal keberangkatan';

    public function handle()
    {
        try {
            // Ambil semua tiket yang tanggal keberangkatannya sudah lewat
            $expiredTickets = Ticket::whereDate('tanggal', '<', Carbon::today())->get();

            foreach ($expiredTickets as $ticket) {
                // Hapus semua locked seats untuk tiket ini
                LockedSeat::where('ticket_id', $ticket->id)->delete();

                // Update booking yang masih pending menjadi expired
                Booking::where('ticket_id', $ticket->id)
                    ->where('status', 'menunggu')
                    ->update(['status' => 'expired']);

                // Reset jumlah kursi tersedia ke nilai awal
                $ticket->update(['kursi' => 31]); // Asumsikan total kursi adalah 31

                Log::info("Reset kursi berhasil untuk tiket ID: {$ticket->id}, Kode: {$ticket->kode}");
            }

            $this->info('Berhasil mereset kursi bus yang sudah lewat tanggal keberangkatan');
        } catch (\Exception $e) {
            Log::error("Error saat mereset kursi bus: " . $e->getMessage());
            $this->error('Terjadi kesalahan saat mereset kursi bus');
        }
    }
}