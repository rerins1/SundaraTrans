<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LockedSeat extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'seat_number', 'user_id', 'locked_until'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
