<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Ambil data user dengan paginasi
        $users = User::paginate(10);

        // Kirim data ke view
        return view('admin.user.DataPenumpang', compact('users'));
    }

    public function create()
    {
        // Tampilkan form untuk membuat user baru
        return view('admin.user.createUser');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:15',
            'role' => 'required|in:user,admin',
        ]);

        // Buat user baru
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'],
            'role' => $validated['role'],
        ]);

        return redirect()->route('data.penumpang')->with('success', 'Data user berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Ambil data user berdasarkan ID
        $user = User::findOrFail($id);

        // Tampilkan form edit
        return view('admin.user.editUser', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:15',
            'role' => 'required|in:user,admin',
        ]);

        // Update data user
        $user = User::findOrFail($id);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
        ]);

        return redirect()->route('data.penumpang')->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('data.penumpang')->with('success', 'Data penumpang berhasil dihapus!');
    }
}
