<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        // Hapus parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    function showRegistrasi() {
        return view('components.navbar');
    }

    function submitRegistrasi(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string'
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'],
            'role' => 'user' // Pastikan role default adalah user
        ]);
    
        return redirect()->route('home');
    }

    function showLogin() {
        return view('components.Home');
    }
    
    public function submitLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Perbaikan logika redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('dashboard');
            } else {
                // If there's an intended URL after login, redirect there
                if ($request->session()->has('url.intended')) {
                    return redirect()->intended();
                }
            }
            
            return redirect()->intended(route('home'));
        }

        return back()
            ->withInput($request->only('email'))
            ->with('Gagal', 'Email atau Password Anda Salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}