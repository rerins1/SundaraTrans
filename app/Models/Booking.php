<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'kode_booking',
        'nama_pemesan',
        'email',
        'no_handphone',
        'alamat',
        'nama_penumpang',
        'kursi',
        'ticket_id',
        'jumlah_penumpang',
        'total_pembayaran',
        'status'
    ];

    // Definisikan casting untuk array
    protected $casts = [
        'nama_penumpang' => 'array',
        'kursi' => 'array'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}