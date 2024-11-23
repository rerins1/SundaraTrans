<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = ['kode_bus', 'no_polisi', 'kapasitas', 'status'];
}
