<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Picqer\Barcode\BarcodeGeneratorPNG;

class AdminBookingController extends Controller
{
    // Menampilkan semua booking
    public function index(Request $request)
    {
        $search = $request->query('search');

        $bookings = Booking::with(['ticket'])
            ->whereHas('ticket') // Hanya ambil booking yang memiliki tiket
            ->when($search, function ($query, $search) {
                return $query->where('kode_booking', 'like', "%{$search}%")
                    ->orWhere('nama_pemesan', 'like', "%{$search}%")
                    ->orWhere('no_handphone', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.booking.DataBookingTiket', compact('bookings'));
    }

    // Menampilkan form edit booking
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.booking.EditBooking', compact('booking'));
    }

    // Mengupdate data booking
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pemesan' => 'required|string',
            'email' => 'required|email',
            'no_handphone' => 'required|string',
            'alamat' => 'required|string',
            'status' => 'required|in:menunggu,lunas,dibatalkan',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update($request->only('nama_pemesan', 'email', 'no_handphone', 'alamat', 'status'));

        return redirect()->route('admin.bookings.index')->with('success', 'Data booking berhasil diupdate.');
    }

    // Menghapus booking
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Data booking berhasil dihapus.');
    }

    // Mengkonfirmasi pembayaran
    public function confirm($id)
    {
        $booking = Booking::with('ticket')->findOrFail($id);
        $booking->update(['status' => 'lunas']);

        // Generate barcode
        $generator = new BarcodeGeneratorPNG();
        $barcode = base64_encode($generator->getBarcode($booking->kode_booking, $generator::TYPE_CODE_128));

        // Kirim email E-Ticket ke user
        Mail::to($booking->email)->send(new \App\Mail\ETicketMail($booking, $barcode));

        return redirect()->route('admin.bookings.index')->with('success', 'Pembayaran berhasil dikonfirmasi dan E-Ticket telah dikirim.');
    }
}
