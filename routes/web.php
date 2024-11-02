<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusTicketController;

Route::get('/', function () {
    return view('components.Home')->name('home');
});

// untuk halaman pilih-tiket
Route::post('/search-bus-tickets', [BusTicketController::class, 'search'])->name('search.bus.tickets');

Route::get('/isi-biodata/{kode?}', [BusTicketController::class, 'showBiodata'])->name('tickets.biodata');
Route::post('/store-biodata', [BusTicketController::class, 'storeBiodata'])->name('store.biodata');

Route::get('/select-seat', [BusTicketController::class, 'showKursi'])->name('show.kursi');
Route::post('/store-seat', [BusTicketController::class, 'storeSeatSelection'])->name('store.seat');

Route::get('/Pembayaran', [BusTicketController::class, 'showPembayaran'])->name('pembayaran');

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
