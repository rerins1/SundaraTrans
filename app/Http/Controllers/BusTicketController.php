<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Booking;
use App\Models\LockedSeat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            // Validasi input jumlah kursi yang dipilih
            $request->validate([
                'nomor_kursi' => 'required|array',
                'nomor_kursi.*' => 'required|integer|min:1|max:31',
            ]);

            // Ambil jumlah penumpang dari session
            $jumlah_penumpang = session('jumlah_penumpang');
            $selectedSeats = $request->nomor_kursi;

            // Validasi jumlah kursi yang dipilih harus sesuai jumlah penumpang
            if (count($selectedSeats) != $jumlah_penumpang) {
                return back()->with('error', 'Jumlah kursi yang dipilih harus sesuai dengan jumlah penumpang.');
            }

            // Validasi kursi yang dipilih (menggunakan database transaction untuk konsistensi)
            DB::transaction(function () use ($selectedSeats) {
                foreach ($selectedSeats as $seat) {
                    // Periksa apakah kursi sedang terkunci oleh pengguna lain
                    $isLocked = LockedSeat::where('ticket_id', session('kode_tiket'))
                        ->where('seat_number', $seat)
                        ->where('expired_at', '>', now())
                        ->exists();

                    if ($isLocked) {
                        throw new \Exception("Kursi nomor {$seat} sedang dipesan oleh pengguna lain.");
                    }

                    // Kunci ulang kursi baru untuk pengguna ini
                    LockedSeat::updateOrCreate(
                        [
                            'ticket_id' => session('kode_tiket'),
                            'seat_number' => $seat,
                        ],
                        [
                            'locked_until' => now()->addMinutes(5),
                            'expired_at' => now()->addMinutes(5),
                        ]
                    );
                }

                // Simpan kursi baru yang dipilih ke session
                session(['selected_seats' => $selectedSeats]);
            });

            // Redirect ke halaman pembayaran
            return redirect()->route('show.pembayaran');
        } catch (\Exception $e) {
            // Log error jika ada
            Log::error('Error in storeSeatSelection: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan pilihan kursi: ' . $e->getMessage());
        }
    }


    public function leaveSeatPage()
    {
        $selectedSeats = session('selected_seats', []);
        if (!empty($selectedSeats)) {
            LockedSeat::whereIn('seat_number', $selectedSeats)
                ->where('ticket_id', session('kode_tiket'))
                ->delete();
            session()->forget('selected_seats');
        }

        return redirect()->route('home');
    }

    public function reselectSeats()
    {
        try {
            // Ambil ID tiket dari session
            $ticketId = session('kode_tiket');

            // Ambil kursi yang sebelumnya dipilih dari session
            $selectedSeats = session('selected_seats', []);

            // Hapus kunci dari kursi yang sebelumnya dipilih
            if (!empty($selectedSeats)) {
                LockedSeat::where('ticket_id', $ticketId)
                    ->whereIn('seat_number', $selectedSeats)
                    ->delete();

                // Hapus kursi yang dipilih dari session
                session()->forget('selected_seats');
            }

            // Redirect kembali ke halaman pemilihan kursi
            return redirect()->route('show.kursi');
        } catch (\Exception $e) {
            Log::error('Error in reselectSeats: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Terjadi kesalahan saat mengatur ulang kursi.');
        }
    }

    public function cancelBooking()
    {
        $selectedSeats = session('selected_seats', []);
        if (!empty($selectedSeats)) {
            LockedSeat::whereIn('seat_number', $selectedSeats)->delete();
            session()->forget(['selected_seats', 'kode_tiket']);
        }

        return redirect()->route('home');
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
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validasi upload gambar
        ], [
            'bukti_pembayaran.required' => 'Silakan unggah bukti pembayaran.',
            'bukti_pembayaran.image' => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'bukti_pembayaran.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            // Ambil data dari session
            $nama_pemesan = session('nama_pemesan');
            $email = session('email');
            $no_handphone = session('no_handphone');
            $alamat = session('alamat');
            $nama_penumpang = session('nama_penumpang', []);
            $selected_seats = session('selected_seats', []);
            $kode_tiket = session('kode_tiket');
            $jumlah_penumpang = session('jumlah_penumpang', 1);

            if (!$selected_seats || !$kode_tiket) {
                return redirect()->route('show.kursi')->with('error', 'Data kursi atau tiket tidak valid.');
            }

            // Validasi kursi yang dipilih masih terkunci
            $lockedSeats = LockedSeat::where('ticket_id', $kode_tiket)
                ->whereIn('seat_number', $selected_seats)
                ->where('expired_at', '>', now())
                ->pluck('seat_number')
                ->toArray();

            if (count($lockedSeats) !== count($selected_seats)) {
                return redirect()->route('show.kursi')
                    ->with('error', 'Salah satu kursi Anda telah dipilih oleh pengguna lain.');
            }

            // Ambil data tiket
            $ticket = Ticket::where('kode', $kode_tiket)->firstOrFail();
            $total_pembayaran = $ticket->harga * $jumlah_penumpang;

            // Generate kode booking unik
            $kode_booking = 'SDT' . strtoupper(uniqid());

            // Proses upload bukti pembayaran
            if ($request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                $fileName = $kode_booking . '_bukti_pembayaran.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
            }

            // Generate barcode
            $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
            $barcode = base64_encode($generator->getBarcode($kode_booking, $generator::TYPE_CODE_128));

            // Simpan data ke tabel bookings
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
                'status' => 'pending',
                'bukti_pembayaran' => $filePath ?? null,
            ]);

            // Lepaskan kunci kursi setelah pembayaran berhasil
            LockedSeat::where('ticket_id', $ticket->id)
                ->whereIn('seat_number', $selected_seats)
                ->delete();

            // Log pembayaran berhasil
            Log::info('Pembayaran berhasil disimpan dengan status pending:', [
                'kode_booking' => $kode_booking,
                'bank' => $request->input('bank'),
                'payment_code' => $request->input('payment_code'),
                'bukti_pembayaran' => $filePath ?? 'Tidak ada',
            ]);

            // Set session sukses dengan kode booking
            session(['success' => $kode_booking]);

            // Kirim data tiket ke halaman Tiket
            return view('transaksi.Tiket', [
                'ticket' => $ticket,
                'nama_pemesan' => $nama_pemesan,
                'email' => $email,
                'no_handphone' => $no_handphone,
                'alamat' => $alamat,
                'nama_penumpang' => $nama_penumpang,
                'selected_seats' => $selected_seats,
                'total_pembayaran' => $total_pembayaran,
                'barcode' => $barcode,
                'status' => 'pending'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in storePayment: ' . $e->getMessage());
            return redirect()->route('show.pembayaran')->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }
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
            'status' => 'pending' 
            // Kirim data lainnya yang diperlukan
        ]);
    }

    public function cekTiket(Request $request)
    {
        $request->validate([
            'noHp' => 'required|string',
            'kodeBooking' => 'required|string'
        ]);

        $booking = Booking::where('no_handphone', $request->input('noHp'))
            ->where('kode_booking', $request->input('kodeBooking'))
            ->first();

        if (!$booking) {
            return redirect()->back()->with('error', 'Nomor HP atau Kode Booking salah. Silakan periksa kembali.');
        }

        // Mengambil data tiket dan status
        $ticket = Ticket::find($booking->ticket_id);
        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
        $barcode = base64_encode($generator->getBarcode($booking->kode_booking, $generator::TYPE_CODE_128));

        return view('transaksi.E-Ticket', [
            'ticket' => $ticket,
            'nama_pemesan' => $booking->nama_pemesan,
            'email' => $booking->email,
            'no_handphone' => $booking->no_handphone,
            'alamat' => $booking->alamat,
            'nama_penumpang' => json_decode($booking->nama_penumpang, true) ?? [],
            'selected_seats' => json_decode($booking->kursi, true) ?? [],
            'total_pembayaran' => $booking->total_pembayaran,
            'barcode' => $barcode,
            'kode_booking' => $booking->kode_booking,
            'status' => $booking->status // Kirim status pembayaran
        ]);
    }

}