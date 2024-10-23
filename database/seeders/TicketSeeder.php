<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void {
        Ticket::create([
            'kelas' => 'Eksekutif',
            'kode' => 'SDT001',
            'waktu' => '07:00',
            'dari' => 'Bandung',
            'tujuan' => 'Jakarta (Terminal Senen)',
            'kursi' => 30,
            'harga' => 150000,
        ]);

        Ticket::create([
            'kelas' => 'Eksekutif',
            'kode' => 'SDT002',
            'waktu' => '12:00',
            'dari' => 'Bandung (Terminal Cicaheum)',
            'tujuan' => 'Jakarta (Terminal Senen)',
            'kursi' => 29,
            'harga' => 120000,
        ]);
    }
}
