<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    // Menampilkan daftar bus
    public function index()
    {
        $buses = Bus::all();
        return view('admin.bus.DataBus', compact('buses'));
    }

    // Menampilkan form tambah bus
    public function create()
    {
        return view('admin.bus.createBus');
    }

    // Menyimpan data bus baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_bus' => 'required|max:255',
            'no_polisi' => 'required|unique:buses,nomor_polisi|max:255',
            'kapasitas' => 'required|integer',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
        ]);

        // Simpan data bus
        Bus::create([
            'kode_bus' => $validated['kode_bus'],
            'no_polisi' => $validated['no_polisi'],
            'kapasitas' => $validated['kapasitas'],
            'status' => $validated['status'],
        ]);

        // Redirect atau kembali dengan pesan sukses
        return redirect()->route('dataBus.index')->with('success', 'Bus berhasil ditambahkan!');
    }

    // Menampilkan form edit bus
    public function edit($id)
    {
        $bus = Bus::findOrFail($id);
        return view('admin.bus.editBus', compact('bus'));
    }

    // Menyimpan perubahan data bus
    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim
        $validated = $request->validate([
            'kode_bus' => 'required|string|max:255',
            'no_polisi' => 'required|string|max:255',
            'kapasitas' => 'required|integer',
            'status' => 'required|string',
        ]);

        // Cari bus berdasarkan ID
        $bus = Bus::findOrFail($id);

        // Update data bus
        $bus->update([
            'kode_bus' => $validated['kode_bus'],
            'no_polisi' => $validated['no_polisi'],
            'kapasitas' => $validated['kapasitas'],
            'status' => $validated['status'],
        ]);

        // Redirect ke halaman dataBus dengan pesan sukses
        return redirect()->route('dataBus.index')->with('success', 'Bus berhasil diperbarui!');
    }

    // Menghapus data bus
    public function destroy($id)
    {
        $bus = Bus::findOrFail($id);  // Mencari bus berdasarkan ID
        $bus->delete();  // Menghapus bus tersebut

        return redirect()->route('dataBus.index')->with('success', 'Bus berhasil dihapus!');
    }
}
