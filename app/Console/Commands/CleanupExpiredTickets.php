<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Booking;
use App\Models\LockedSeat;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CleanupExpiredTickets extends Command
{
    protected $signature = 'tickets:cleanup';
    protected $description = 'Cleanup expired tickets and reset for next available date';

    public function handle()
    {
        $now = Carbon::now();
        
        try {
            DB::beginTransaction();

            // Ambil semua tiket yang sudah lewat waktu
            $expiredTickets = Ticket::where(function($query) use ($now) {
                $query->whereDate('tanggal', '<', $now->toDateString())
                    ->orWhere(function($q) use ($now) {
                        $q->whereDate('tanggal', '=', $now->toDateString())
                            ->whereTime('waktu', '<', $now->toTimeString());
                    });
            })->get();

            foreach ($expiredTickets as $ticket) {
                // Log tiket yang akan diproses
                Log::info("Processing expired ticket:", [
                    'kode' => $ticket->kode,
                    'tanggal' => $ticket->tanggal,
                    'waktu' => $ticket->waktu
                ]);

                // Hapus semua booking terkait
                Booking::where('ticket_id', $ticket->id)->delete();

                // Hapus semua locked seats
                LockedSeat::where('ticket_id', $ticket->id)->delete();

                // Hitung tanggal berikutnya (besok pada jam yang sama)
                $nextDate = Carbon::parse($ticket->tanggal . ' ' . $ticket->waktu)->addDay();

                // Update tiket dengan tanggal baru
                $ticket->update([
                    'tanggal' => $nextDate->toDateString(),
                    'kursi' => 31, // Reset jumlah kursi ke default
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                Log::info("Ticket reset to next date:", [
                    'kode' => $ticket->kode,
                    'new_date' => $nextDate->toDateString()
                ]);
            }

            DB::commit();
            $this->info('Successfully cleaned up ' . $expiredTickets->count() . ' expired tickets.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during ticket cleanup: ' . $e->getMessage());
            $this->error('Failed to cleanup tickets: ' . $e->getMessage());
        }
    }
}