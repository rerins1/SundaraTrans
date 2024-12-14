<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LockedSeat extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'seat_number', 'user_id', 'locked_until'];

    protected static function boot()
    {
        parent::boot();

        // Hapus otomatis kursi terkunci yang telah expired
        static::addGlobalScope('removeExpired', function ($query) {
            $query->where('expired_at', '>', now());
        });
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
