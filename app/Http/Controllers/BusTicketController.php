<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Ticket;

class BusTicketController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'dari' => 'required|string',
            'tujuan' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah_penumpang' => 'required|integer|min:1',
        ]);
        
        $tanggal = date('Y-m-d', strtotime($request->input('tanggal')));
        
        Log::info('Search Parameters:', [
            'dari' => $request->input('dari'),
            'tujuan' => $request->input('tujuan'),
            'tanggal' => $tanggal,
            'jumlah_penumpang' => $request->input('jumlah_penumpang')
        ]);

        $tickets = Ticket::where('dari', 'LIKE', '%' . $request->input('dari') . '%')
            ->where('tujuan', 'LIKE', '%' . $request->input('tujuan') . '%')
            ->whereDate('tanggal', $tanggal)
            ->where('kursi', '>=', $request->input('jumlah_penumpang'))
            ->get();
            
        Log::info('Query Results:', ['count' => $tickets->count()]);

        if ($tickets->isEmpty()) {
            return view('reservasi.pilih-tiket', [
                'tickets' => $tickets,
                'message' => 'Tidak ada tiket tersedia untuk rute ini.'
            ]);
        }

        // Simpan jumlah penumpang ke session untuk digunakan di halaman biodata
        session(['jumlah_penumpang' => $request->input('jumlah_penumpang')]);

        return view('reservasi.pilih-tiket', compact('tickets'));
    }

    public function navigateToPilihTiket(Request $request)
    {
        // Bersihkan session jika perlu
        $request->session()->forget(['dari', 'tujuan', 'tanggal', 'jumlah_penumpang']);
        
        return redirect()->route('search.bus.tickets'); // Redirect ke route pencarian tiket
    }

    // Method untuk menampilkan form biodata dengan data tiket
    public function showBiodata($kode = null)
    {
        try {
            // Cek apakah kode tiket tersedia, jika tidak ambil dari session
            if (!$kode) {
                $kode = session('kode_tiket');
                
                if (!$kode) {
                    return redirect()->back()
                        ->with('error', 'Kode tiket tidak ditemukan');
                }
            }

            // Ambil data tiket berdasarkan kode
            $ticket = Ticket::where('kode', $kode)->firstOrFail();
            
            // Simpan kode ke session untuk digunakan di halaman lain
            session(['kode_tiket' => $kode]);
            
            // Ambil jumlah penumpang dari session atau set default 1
            $jumlah_penumpang = session('jumlah_penumpang', 1);

            // Hitung total pembayaran
            $total_pembayaran = $ticket->harga * $jumlah_penumpang;

            return view('reservasi.isi-biodata', compact('ticket', 'jumlah_penumpang', 'total_pembayaran'));
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memuat data tiket');
        }
    }

    public function storeBiodata(Request $request)
    {
        $request->validate([
            'nama_pemesan' => 'required|string',
            'email' => 'required|email',
            'no_handphone' => 'required|string',
            'alamat' => 'required|string',
            'nama_penumpang' => 'required|string',
        ]);

        // Simpan data biodata ke session
        session([
            'nama_pemesan' => $request->input('nama_pemesan'),
            'email' => $request->input('email'),
            'no_handphone' => $request->input('no_handphone'),
            'alamat' => $request->input('alamat'),
            'nama_penumpang' => $request->input('nama_penumpang'),
        ]);

        dd(session()->all());

        return redirect()->route('show.pembayaran'); // Pastikan route ini benar
    }

    public function showKursi()
    {
        try {
            // Ambil jumlah penumpang dari session
            $jumlah_penumpang = session('jumlah_penumpang');
            
            // Validasi apakah jumlah penumpang ada
            if (!$jumlah_penumpang) {
                // Ganti redirect ke halaman yang menerima GET
                return redirect()->route('search.bus.tickets')
                    ->with('error', 'Silahkan pilih jumlah penumpang terlebih dahulu');
            }

            // Ambil data kursi yang sudah terpesan (jika ada)
            $bookedSeats = []; // Anda bisa mengisi ini dari database jika diperlukan
            
            return view('reservasi.kursi', [
                'jumlah_penumpang' => $jumlah_penumpang,
                'bookedSeats' => $bookedSeats
            ]);

            dd(session()->all());

        } catch (\Exception $e) {
            Log::error('Error in showKursi: ' . $e->getMessage());
            // Ganti redirect ke halaman yang menerima GET
            return redirect()->route('search.bus.tickets')
                ->with('error', 'Terjadi kesalahan saat memuat halaman pemilihan kursi');
        }
    }

    public function storeSeatSelection(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'nomor_kursi' => 'required|array',
                'nomor_kursi.*' => 'required|integer|min:1|max:31',
            ]);

            // Ambil jumlah penumpang dari session
            $jumlah_penumpang = session('jumlah_penumpang');

            // Validasi jumlah kursi yang dipilih
            if (count($request->nomor_kursi) != $jumlah_penumpang) {
                return back()->with('error', "Silahkan pilih {$jumlah_penumpang} kursi");
            }

            // Simpan nomor kursi ke session
            session(['selected_seats' => $request->nomor_kursi]);

            // Ganti redirect ke route pembayaran yang menerima GET
            return redirect()->route('pembayaran')
                ->with('success', 'Kursi berhasil dipilih');

        } catch (\Exception $e) {
            Log::error('Error in storeSeatSelection: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan pilihan kursi');
        }
    }

    public function showPembayaran()
    {
        Log::info('Session data in showPembayaran:', session()->all());

        $nama_pemesan = session('nama_pemesan');
        $email = session('email');
        $no_handphone = session('no_handphone');
        $alamat = session('alamat');
        $nama_penumpang = session('nama_penumpang');
        $selected_seats = session('selected_seats', []);
        
        $ticket = Ticket::where('kode', session('kode_tiket'))->firstOrFail();
        $jumlah_penumpang = session('jumlah_penumpang', 1);
        $total_pembayaran = $ticket->harga * $jumlah_penumpang;


        return view('transaksi.Pembayaran', compact(
            'nama_pemesan', 'email', 'no_handphone', 'alamat', 
            'nama_penumpang', 'ticket', 'jumlah_penumpang', 'total_pembayaran', 'selected_seats'
        ));
    }

}