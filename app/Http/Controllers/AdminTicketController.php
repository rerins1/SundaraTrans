<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminTicketController extends Controller
{
    public function index()
    {
        Log::info('Route tickets.index dipanggil.');
        
        // Menggunakan paginate untuk membagi halaman
        $tickets = Ticket::paginate(10); 

        return view('admin.tiket.datajadwaltiket', compact('tickets'));
    }

    public function create()
    {
        return view('admin.tiket.create-jadwal-tiket');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas' => 'required|string',
            'kode' => 'required|string|unique:tickets,kode',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'dari' => 'required|string',
            'tujuan' => 'required|string',
            'kursi' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        Ticket::create($validated);
        return redirect()->route('admin.tickets.index')->with('success', 'Tiket berhasil ditambahkan.');
    }

    public function edit(Ticket $ticket)
    {
        return view('admin.tiket.edit-jadwal-tiket', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'kelas' => 'required|string',
            'kode' => 'required|string|unique:tickets,kode,' . $ticket->id,
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'dari' => 'required|string',
            'tujuan' => 'required|string',
            'kursi' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
        ]);

        $ticket->update($request->all());
        return redirect()->route('admin.tickets.index')->with('success', 'Tiket berhasil diupdate.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success', 'Tiket berhasil dihapus.');
    }

}