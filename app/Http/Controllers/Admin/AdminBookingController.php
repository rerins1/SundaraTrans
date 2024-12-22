<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    // Menampilkan semua booking
    public function index(Request $request)
    {
        $search = $request->query('search');

        $bookings = Booking::with('ticket')
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
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'lunas']);

        return redirect()->route('admin.bookings.index')->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }
}
