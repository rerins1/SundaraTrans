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
        // Validasi input pencarian
        $request->validate([
            'dari' => 'required|string',
            'tujuan' => 'required|string',
            'tanggal' => 'required|date',
            'jumlah_penumpang' => 'required|integer|min:1',
        ]);

        $tanggal = date('Y-m-d', strtotime($request->input('tanggal')));
        
        // Simpan tanggal ke session untuk digunakan nanti
        session(['tanggal' => $tanggal]);
        
        Log::info('Search Parameters:', [
            'dari' => $request->input('dari'),
            'tujuan' => $request->input('tujuan'),
            'tanggal' => $tanggal,
            'jumlah_penumpang' => $request->input('jumlah_penumpang'),
        ]);

        $tickets = Ticket::where('dari', 'LIKE', '%' . $request->input('dari') . '%')
            ->where('tujuan', 'LIKE', '%' . $request->input('tujuan') . '%')
            ->whereDate('tanggal', $tanggal)
            ->where('kursi', '>', 0)
            ->get()
            ->map(function ($ticket) {
                // Hitung jumlah kursi yang telah terpesan
                $bookedSeats = Booking::where('ticket_id', $ticket->id)
                    ->where('status', 'lunas')
                    ->get()
                    ->sum(function ($booking) {
                        return count(json_decode($booking->kursi, true) ?? []);
                    });

                // Hitung kursi yang tersisa
                $ticket->sisa_kursi = max(0, $ticket->kursi - $bookedSeats);

                return $ticket;
            });

        Log::info('Query Results:', ['count' => $tickets->count()]);

        if ($tickets->isEmpty()) {
            return view('reservasi.pilih-tiket', [
                'tickets' => $tickets,
                'message' => 'Tidak ada tiket tersedia untuk rute ini.',
            ]);
        }

        // Simpan jumlah penumpang ke session untuk digunakan di halaman berikutnya
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

            // Ambil tanggal dari session yang disimpan saat pencarian
            $tanggal = session('tanggal');

            // Ambil data tiket berdasarkan kode DAN tanggal
            $ticket = Ticket::where('kode', $kode)
                ->whereDate('tanggal', $tanggal) // Tambahkan filter berdasarkan tanggal
                ->firstOrFail();
            
            // Simpan kode dan tanggal ke session untuk digunakan di halaman lain
            session([
                'kode_tiket' => $kode,
                'tanggal' => $tanggal
            ]);
            
            // Pastikan jumlah_penumpang ada dan valid
            $jumlah_penumpang = session('jumlah_penumpang');
            if (!$jumlah_penumpang || $jumlah_penumpang < 1) {
                $jumlah_penumpang = 1; // Default value
            }

            // Hitung total pembayaran
            $total_pembayaran = $ticket->harga * $jumlah_penumpang;

            // Log untuk debugging
            Log::info('Showing biodata form', [
                'ticket_code' => $kode,
                'ticket_date' => $tanggal,
                'passenger_count' => $jumlah_penumpang
            ]);

            return view('reservasi.isi-biodata', compact('ticket', 'jumlah_penumpang', 'total_pembayaran'));
            
        } catch (\Exception $e) {
            Log::error('Error in showBiodata: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memuat data tiket');
        }
    }

    public function storeBiodata(Request $request)
    {
        $jumlah_penumpang = session('jumlah_penumpang', 1);
        
        $request->validate([
            'nama_pemesan' => 'required|string',
            'email' => 'required|email',
            'no_handphone' => 'required|string',
            'alamat' => 'required|string',
            'nama_penumpang' => 'required|array|size:' . $jumlah_penumpang,
            'nama_penumpang.*' => 'required|string',
        ], [
            'nama_penumpang.size' => 'Jumlah nama penumpang harus sesuai dengan jumlah penumpang yang dipilih (' . $jumlah_penumpang . ')',
            'nama_penumpang.*.required' => 'Nama penumpang harus diisi',
        ]);

        // Simpan data ke session
        session([
            'nama_pemesan' => $request->input('nama_pemesan'),
            'email' => $request->input('email'),
            'no_handphone' => $request->input('no_handphone'),
            'alamat' => $request->input('alamat'),
            'nama_penumpang' => $request->input('nama_penumpang'),
        ]);

        Log::info('Biodata stored', [
            'passenger_count' => count($request->input('nama_penumpang')),
            'passengers' => $request->input('nama_penumpang')
        ]);

        return redirect()->route('show.kursi');
    }

    public function showKursi()
    {
        try {
            // Ambil jumlah penumpang dan kode tiket dari sesi
            $jumlah_penumpang = session('jumlah_penumpang');
            $kodeTiket = session('kode_tiket');
            $tanggal = session('tanggal'); // Pastikan tanggal disimpan di session
            
            if (!$jumlah_penumpang || !$kodeTiket) {
                return redirect()->route('search.bus.tickets')
                    ->with('error', 'Silahkan pilih jumlah penumpang dan tiket terlebih dahulu.');
            }

            // Ambil data tiket berdasarkan kode tiket DAN tanggal
            $ticket = Ticket::where('kode', $kodeTiket)
                ->whereDate('tanggal', $tanggal)
                ->firstOrFail();

            // Ambil kursi yang terkunci berdasarkan ticket_id
            $lockedSeats = LockedSeat::where('ticket_id', $ticket->id)
                ->where('expires_at', '>', now())
                ->pluck('seat_number')
                ->toArray();

            // Ambil kursi yang sudah dipesan
            $bookedSeats = Booking::where('ticket_id', $ticket->id)
                ->get()
                ->flatMap(function ($booking) {
                    return json_decode($booking->kursi, true);
                })
                ->toArray();

            // Gabungkan kursi yang terkunci dan yang dipesan
            $unavailableSeats = array_unique(array_merge($lockedSeats, $bookedSeats));

            return view('reservasi.kursi', [
                'jumlah_penumpang' => $jumlah_penumpang,
                'unavailableSeats' => $unavailableSeats,
                'ticket' => $ticket // Tambahkan ticket ke view
            ]);

        } catch (\Exception $e) {
            Log::error('Error in showKursi: ' . $e->getMessage());
            return redirect()->route('search.bus.tickets')
                ->with('error', 'Terjadi kesalahan saat memuat halaman pemilihan kursi.');
        }
    }

    public function storeSeatSelection(Request $request)
    {
        // Validasi input kursi
        $request->validate([
            'nomor_kursi' => 'required|array',
            'nomor_kursi.*' => 'required|integer|min:1|max:31',
        ]);

        // Ambil jumlah penumpang dari sesi
        $jumlah_penumpang = session('jumlah_penumpang');
        $selectedSeats = $request->nomor_kursi;
        $tanggal = session('tanggal');

        // Validasi jumlah kursi
        if (count($selectedSeats) != $jumlah_penumpang) {
            return back()
                ->with('error', 'Jumlah kursi yang dipilih harus sesuai dengan jumlah penumpang.')
                ->withInput();
        }

        // Ambil data tiket berdasarkan kode DAN tanggal
        $ticket = Ticket::where('kode', session('kode_tiket'))
            ->whereDate('tanggal', $tanggal)
            ->firstOrFail();

        // Gabungkan tanggal dan waktu keberangkatan
        $departureDateTime = Carbon::parse($ticket->tanggal . ' ' . $ticket->waktu);

        // Set expire 10 menit setelah waktu keberangkatan
        $expiresAt = $departureDateTime->copy()->addMinutes(10);

        // Validasi waktu keberangkatan
        if (now()->greaterThan($expiresAt)) {
            return back()
                ->with('error', 'Waktu pemesanan sudah melewati jadwal keberangkatan.')
                ->withInput();
        }

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Validasi kursi secara real-time
            foreach ($selectedSeats as $seat) {
                // Periksa apakah kursi sudah terkunci atau dipesan untuk tiket spesifik ini
                $isLocked = LockedSeat::where('ticket_id', $ticket->id)
                    ->where('seat_number', $seat)
                    ->where('expires_at', '>', now())
                    ->exists();

                $isBooked = Booking::where('ticket_id', $ticket->id)
                    ->whereJsonContains('kursi', $seat)
                    ->exists();

                if ($isLocked || $isBooked) {
                    DB::rollBack();
                    return back()
                        ->with('error', "Kursi nomor {$seat} sudah dipilih oleh pengguna lain. Silakan pilih kursi lain.")
                        ->withInput();
                }
            }

            // Proses penguncian kursi dengan ticket_id yang benar
            foreach ($selectedSeats as $seat) {
                LockedSeat::create([
                    'ticket_id' => $ticket->id, // Gunakan ID tiket yang spesifik
                    'seat_number' => $seat,
                    'locked_at' => now(),
                    'expires_at' => $expiresAt
                ]);
            }

            // Simpan kursi yang dipilih ke sesi
            session(['selected_seats' => $selectedSeats]);

            DB::commit();
            return redirect()->route('show.pembayaran');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Seat selection error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memilih kursi.');
        }
    }

    public function cleanupExpiredLocks()
    {
        LockedSeat::where('expires_at', '<=', now())->delete();
    }

    public function leaveSeatPage()
    {
        $selectedSeats = session('selected_seats', []);
        $ticketId = session('kode_tiket');

        if (!empty($selectedSeats)) {
            // Release all locked seats
            foreach ($selectedSeats as $seat) {
                LockedSeat::releaseSeat($ticketId, $seat);
            }
            
            session()->forget('selected_seats');
        }

        return redirect()->route('home');
    }

    public function reselectSeats()
    {
        $ticketId = Ticket::where('kode', session('kode_tiket'))->value('id');
        $selectedSeats = session('selected_seats', []);

        // Lepaskan kursi yang dipilih sebelumnya
        if (!empty($selectedSeats)) {
            LockedSeat::releaseSeats($ticketId, $selectedSeats);
            session()->forget('selected_seats');
        }

        return redirect()->route('show.kursi');
    }

    public function cancelBooking()
    {
        // Ambil data tiket dari session
        $kodeTiket = session('kode_tiket');
        
        // Jika tidak ada kode tiket, redirect ke halaman utama
        if (!$kodeTiket) {
            return redirect()->route('home');
        }

        try {
            // Cari tiket berdasarkan kode
            $ticket = Ticket::where('kode', $kodeTiket)->first();
            
            if (!$ticket) {
                return redirect()->route('home')
                    ->with('error', 'Tiket tidak ditemukan.');
            }

            // Mulai transaksi database
            DB::beginTransaction();

            // 1. Hapus kursi yang terkunci
            LockedSeat::where('ticket_id', $ticket->id)->delete();

            // 2. Hapus booking yang belum selesai (jika ada)
            Booking::where('ticket_id', $ticket->id)
                ->where('status', 'menunggu')
                ->delete();

            // 3. Batalkan semua sesi terkait
            session()->forget([
                'kode_tiket',
                'selected_seats',
                'jumlah_penumpang',
                'nama_pemesan',
                'email',
                'no_handphone',
                'alamat',
                'nama_penumpang'
            ]);

            // Commit transaksi
            DB::commit();

            // Log pembatalan
            Log::info('Booking cancellation complete', [
                'ticket_code' => $kodeTiket,
                'ticket_id' => $ticket->id
            ]);

            // Redirect dengan pesan sukses
            return redirect()->route('home')
                ->with('status', 'Pemesanan berhasil dibatalkan. Terima kasih.');

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            // Log error
            Log::error('Booking cancellation failed', [
                'error' => $e->getMessage(),
                'ticket_code' => $kodeTiket
            ]);

            // Redirect dengan pesan error
            return redirect()->route('home')
                ->with('error', 'Terjadi kesalahan saat membatalkan pemesanan.');
        }
    }

    public function showPembayaran()
    {
        Log::info('Session data in showPembayaran:', session()->all());

        $nama_pemesan = session('nama_pemesan');
        $email = session('email');
        $no_handphone = session('no_handphone');
        $alamat = session('alamat');
        $nama_penumpang = session('nama_penumpang', []); 
        $selected_seats = session('selected_seats', []);
        $tanggal = session('tanggal'); // Ambil tanggal dari session
        
        // Ambil data tiket berdasarkan kode DAN tanggal
        $ticket = Ticket::where('kode', session('kode_tiket'))
            ->whereDate('tanggal', $tanggal)
            ->firstOrFail();

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
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'bukti_pembayaran.required' => 'Silahkan unggah bukti pembayaran.',
            'bukti_pembayaran.image' => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'bukti_pembayaran.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Ambil data dari session
        $nama_pemesan = session('nama_pemesan');
        $email = session('email');
        $no_handphone = session('no_handphone');
        $alamat = session('alamat');
        $nama_penumpang = session('nama_penumpang', []);
        $selected_seats = session('selected_seats', []);
        $tanggal = session('tanggal'); // Ambil tanggal dari session

        // Ambil data tiket berdasarkan kode DAN tanggal
        $ticket = Ticket::where('kode', session('kode_tiket'))
            ->whereDate('tanggal', $tanggal)
            ->firstOrFail();

        $jumlah_penumpang = session('jumlah_penumpang', 1);
        $total_pembayaran = $ticket->harga * $jumlah_penumpang;

        // Generate kode booking unik
        $kode_booking = 'SDT' . strtoupper(uniqid());

        // Proses upload bukti pembayaran
        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $fileName = $kode_booking . '_bukti_pembayaran.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('bukti_pembayaran', $fileName, 'public');
        }

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
            'status' => 'menunggu',
            'bukti_pembayaran' => $filePath ?? null,
        ]);

        // Log data pembayaran
        Log::info('Pembayaran berhasil disimpan dengan status menunggu:', [
            'kode_booking' => $kode_booking,
            'bank' => $request->input('bank'),
            'payment_code' => $request->input('payment_code'),
            'bukti_pembayaran' => $filePath ?? 'Tidak ada',
            'tanggal_keberangkatan' => $ticket->tanggal,
        ]);

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
            'status' => 'menunggu'
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
            'status' => 'menunggu' 
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
        $generator = new BarcodeGeneratorPNG();
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
            'status' => $booking->status
        ]);
    }

}