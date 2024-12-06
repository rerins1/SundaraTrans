<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Booking;
use App\Models\LockedSeat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Picqer\Barcode\BarcodeGeneratorPNG;


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
            'nama_penumpang' => 'required|array', // Ubah menjadi array
            'nama_penumpang.*' => 'required|string', // Validasi setiap elemen array
        ]);

        // Mengambil dan memproses array nama penumpang
        $namaPenumpang = $request->input('nama_penumpang');
        
        // Simpan data biodata ke session
        session([
            'nama_pemesan' => $request->input('nama_pemesan'),
            'email' => $request->input('email'),
            'no_handphone' => $request->input('no_handphone'),
            'alamat' => $request->input('alamat'),
            'nama_penumpang' => $namaPenumpang, // Simpan array nama penumpang
        ]);

        // Log semua data termasuk array nama penumpang
        Log::info('Data biodata yang disimpan ke session:', [
            'nama_pemesan' => $request->input('nama_pemesan'),
            'email' => $request->input('email'),
            'no_handphone' => $request->input('no_handphone'),
            'alamat' => $request->input('alamat'),
            'nama_penumpang' => $namaPenumpang,
        ]);

        return redirect()->route('show.kursi');
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
            $request->validate([
                'nomor_kursi' => 'required|array',
                'nomor_kursi.*' => 'required|integer|min:1|max:31',
            ]);

            $jumlah_penumpang = session('jumlah_penumpang');
            
            // Validasi apakah jumlah kursi yang dipilih sesuai dengan jumlah penumpang
            if (count($request->nomor_kursi) != $jumlah_penumpang) {
                return back()->with('error', 'Jumlah kursi yang dipilih harus sesuai dengan jumlah penumpang.');
            }

            // Cek kursi yang sudah dipesan
            $bookedSeats = Booking::where('ticket_id', session('kode_tiket'))
                ->where('status', '!=', 'cancelled')
                ->pluck('kursi')
                ->flatten()
                ->toArray();

            $selectedSeats = $request->nomor_kursi;

            // Validasi apakah kursi yang dipilih ada yang sudah dipesan
            $conflictingSeats = array_intersect($selectedSeats, $bookedSeats);
            if (!empty($conflictingSeats)) {
                return back()->with('error', 'Kursi nomor ' . implode(', ', $conflictingSeats) . ' sudah dipesan.');
            }

            // Jika validasi lolos, simpan kursi yang dipilih ke session
            session(['selected_seats' => $selectedSeats]);

            return redirect()->route('show.pembayaran');
        } catch (\Exception $e) {
            Log::error('Error in storeSeatSelection: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan pilihan kursi.');
        }
    }

    public function showPembayaran()
    {
        Log::info('Session data in showPembayaran:', session()->all());

        $nama_pemesan = session('nama_pemesan');
        $email = session('email');
        $no_handphone = session('no_handphone');
        $alamat = session('alamat');
        $nama_penumpang = session('nama_penumpang', []); // Tambahkan default empty array
        $selected_seats = session('selected_seats', []);
        
        $ticket = Ticket::where('kode', session('kode_tiket'))->firstOrFail();
        $jumlah_penumpang = session('jumlah_penumpang', 1);
        $total_pembayaran = $ticket->harga * $jumlah_penumpang;

        return view('transaksi.Pembayaran', compact(
            'nama_pemesan', 'email', 'no_handphone', 'alamat', 
            'nama_penumpang', 'ticket', 'jumlah_penumpang', 'total_pembayaran', 'selected_seats'
        ));
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'bank' => 'required|string',
            'payment_code' => 'required|string',
        ]);

        // Ambil data dari session
        $nama_pemesan = session('nama_pemesan');
        $email = session('email');
        $no_handphone = session('no_handphone');
        $alamat = session('alamat');
        $nama_penumpang = session('nama_penumpang', []);
        $selected_seats = session('selected_seats', []);
        $ticket = Ticket::where('kode', session('kode_tiket'))->firstOrFail(); // Ambil data tiket dari database
        $jumlah_penumpang = session('jumlah_penumpang', 1);
        $total_pembayaran = $ticket->harga * $jumlah_penumpang;

        // Generate kode booking unik
        $kode_booking = 'SDT' . strtoupper(uniqid());

        $generator = new BarcodeGeneratorPNG();
        $barcode = base64_encode($generator->getBarcode($kode_booking, $generator::TYPE_CODE_128));

        // Simpan data ke tabel bookings dengan status "pending"
        $booking = Booking::create([
            'kode_booking' => $kode_booking,
            'nama_pemesan' => $nama_pemesan,
            'email' => $email,
            'no_handphone' => $no_handphone,
            'alamat' => $alamat,
            'nama_penumpang' => json_encode($nama_penumpang),
            'kursi' => json_encode($selected_seats),
            'ticket_id' => $ticket->id,
            'jumlah_penumpang' => $jumlah_penumpang,
            'total_pembayaran' => $total_pembayaran,
            'status' => 'pending', // Status sedang menunggu konfirmasi
        ]);

        // Log data pembayaran
        Log::info('Pembayaran berhasil disimpan dengan status pending:', [
            'kode_booking' => $kode_booking,
            'bank' => $request->input('bank'),
            'payment_code' => $request->input('payment_code'),
        ]);

        // Set session success dengan kode booking
        session(['success' => $kode_booking]);

        // Kirim data tiket ke halaman Tiket
        return view('transaksi.Tiket', [
            'ticket' => $ticket, // Kirim data tiket ke view
            'nama_pemesan' => $nama_pemesan,
            'email' => $email,
            'no_handphone' => $no_handphone,
            'alamat' => $alamat,
            'nama_penumpang' => $nama_penumpang,
            'selected_seats' => $selected_seats,
            'total_pembayaran' => $total_pembayaran,
            'barcode' => $barcode
        ]);
    }


    public function showVirtualAccount()
    {
        // Menampilkan halaman Virtual Account
        return view('transaksi.Virtual-Account'); // Pastikan ini mengarah ke view yang benar
    }

    public function showTicket()
    {
        // Ambil kode booking dari session
        $kode_booking = session('success');
    
        // Pastikan kode booking ada
        if (!$kode_booking) {
            return redirect()->route('error.page'); // Redirect jika tidak ada kode booking
        }
    
        // Membuat barcode menggunakan kode booking
        $generator = new BarcodeGeneratorPNG();
        $barcode = base64_encode($generator->getBarcode($kode_booking, $generator::TYPE_CODE_128));
    
        // Debugging: pastikan barcode berhasil dibuat
        dd($barcode);  // Cek apakah $barcode dihasilkan dengan benar
    
        // Kirim data ke view
        return view('transaksi.Tiket', [
            'barcode' => $barcode, // Kirim barcode ke view
            'kode_booking' => $kode_booking, // Kirim kode booking ke view
            // Kirim data lainnya yang diperlukan
        ]);
    }
}