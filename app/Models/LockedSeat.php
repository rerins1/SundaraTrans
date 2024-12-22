<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class LockedSeat extends Model
{
    protected $fillable = [
        'ticket_id', 
        'seat_number', 
        'locked_at', 
        'expires_at',
    ];

    protected $dates = [
        'locked_at', 
        'expires_at',
    ];

    // Scope untuk hanya menampilkan kunci yang masih aktif
    public function scopeActive($query)
    {
        return $query->where('expires_at', '>', now());
    }

    // Relasi dengan tiket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    // Method untuk membersihkan kunci yang sudah kedaluwarsa
    public static function cleanExpiredLocks()
    {
        $deletedCount = self::where('expires_at', '<=', now())->delete();
        Log::info('Expired locks cleaned', ['deleted_count' => $deletedCount]);
    }

    // Method untuk merilis kursi
    public static function releaseSeats($ticketId, $seats = null)
    {
        $query = self::where('ticket_id', $ticketId);
        
        if ($seats !== null) {
            $query->whereIn('seat_number', $seats);
        }
        
        $query->delete();

        return self::where('ticket_id', $ticketId)->delete();
    }
}
