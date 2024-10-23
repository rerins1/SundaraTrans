<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Ticket; // Import model Ticket

class BusTicketController extends Controller
{
    public function search(Request $request)
{
    $request->validate([
        'dari' => 'required|string',
        'tujuan' => 'required|string',
        'tanggal' => 'required|date',  // Nama field sesuai dengan form
        'jumlah_penumpang' => 'required|integer|min:1',
    ]);
    
    $dari = $request->input('dari');
    $tujuan = $request->input('tujuan');
    $tanggal = $request->input('tanggal');  // Ubah nama variabel sesuai form
    $jumlah_penumpang = $request->input('jumlah_penumpang');

    // Debug untuk memeriksa nilai yang diterima
    // dd($dari, $tujuan, $tanggal, $jumlah_penumpang);

    // Cek dan ambil tiket sesuai kriteria
    $tickets = Ticket::where('dari', $dari)
            ->where('tujuan', $tujuan)
            ->whereDate('tanggal', $tanggal)  // Gunakan variabel yang sudah diubah
            ->where('kursi', '>=', $jumlah_penumpang)
            ->get();

            // dd($request->all());

    // Jika tidak ada tiket yang ditemukan
    if ($tickets->isEmpty()) {
        return view('reservasi.pilih-tiket', [
            'tickets' => $tickets,
            'message' => 'Tidak ada tiket tersedia untuk rute ini.'
        ]);
    }

    return view('reservasi.pilih-tiket', compact('tickets'));
}


}
