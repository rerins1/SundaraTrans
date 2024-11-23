<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments'; // Nama tabel yang digunakan

    protected $fillable = [
        'ticket_id',
        'nama_pemesan',
        'email',
        'no_handphone',
        'alamat',
        'jumlah_penumpang',
        'total_pembayaran',
        'selected_seats',
        'payment_method',
        'status', // Status pembayaran (misal: pending, completed, cancelled)
    ];

    // Relasi dengan Ticket model
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
