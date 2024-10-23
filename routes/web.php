<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusTicketController;

Route::get('/', function () {
    return view('components.Home');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/bus-info', function () {
    return view('information.bus-info');
});

Route::get('/tentang-kami', function () {
    return view('information.tentang-kami');
});

Route::get('/hubungi-kami', function () {
    return view('information.hubungi-kami');
});

Route::get('/aturan', function () {
    return view('information.aturan');
});

Route::get('/bus-code', function () {
    return view('tracking.bus-code');
});

Route::get('/live-tracking', function () {
    return view('tracking.live-tracking');
});

Route::post('/search-bus-tickets', [BusTicketController::class, 'search'])->name('search.bus.tickets');

// Route::get('/search-bus-tickets', [BusTicketController::class, 'searchGet'])->name('search.bus.tickets.get');

Route::get('/isi-biodata', function () {
    return view('reservasi.isi-biodata');
});

Route::get('/kursi-31', function () {
    return view('reservasi.kursi-31');
});

Route::get('/Pembayaran', function () {
    return view('transaksi.Pembayaran');
});

Route::get('/E-Wallet', function () {
    return view('transaksi.E-Wallet');
});

Route::get('/Minimarket', function () {
    return view('transaksi.Minimarket');
});

Route::get('/Virtual-Account', function () {
    return view('transaksi.Virtual-Account');
});

Route::get('/Tiket', function () {
    return view('transaksi.Tiket');
});
