<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;  // Tambahkan ini

    protected $table = 'tickets';

    protected $fillable = [
        'kelas', 'kode', 'tanggal', 'waktu', 'dari', 'tujuan', 'kursi', 'harga'
    ];
}
