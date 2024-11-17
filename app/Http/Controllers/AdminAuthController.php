<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->route('dashboard'); // Gunakan route() helper
            }
            
            // Jika bukan admin, logout dan kembalikan error
            Auth::logout();
            return back()->withErrors([
                'email' => 'Anda tidak memiliki akses admin.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ]);
    }
}