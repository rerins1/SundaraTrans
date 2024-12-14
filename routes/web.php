<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\BusTicketController;
use App\Http\Controllers\AdminTicketController;
use App\Http\Controllers\Admin\AdminBookingController;

// Home route
Route::get('/', function () {
    return view('components.Home');
})->name('home');

// Booking Process Routes
Route::prefix('booking')->group(function () {
    // Step 1: Search Tickets
    Route::post('/search', [BusTicketController::class, 'search'])
        ->name('search.bus.tickets');

    // Step 2: Fill Biodata
    Route::get('/biodata/{kode?}', [BusTicketController::class, 'showBiodata'])
        ->name('tickets.biodata');
    Route::post('/biodata', [BusTicketController::class, 'storeBiodata'])
        ->name('store.biodata');

    // Step 3: Seat Selection
    Route::get('/seat', [BusTicketController::class, 'showKursi'])
        ->name('show.kursi');
    Route::post('/seat', [BusTicketController::class, 'storeSeatSelection'])
        ->name('store.seat');
    Route::post('/cancel-booking', [BusTicketController::class, 'cancelBooking'])->name('cancel.booking');
    Route::get('/seat/reselect', [BusTicketController::class, 'reselectSeats'])->name('reselect.seats');

    // Step 4: Payment
    Route::prefix('payment')->group(function () {
        // Main payment page
        Route::get('/pembayaran', [BusTicketController::class, 'showPembayaran'])
            ->name('show.pembayaran');

        // Payment methods
        Route::prefix('method')->group(function () {
            Route::get('/e-wallet', function () {
                return view('transaksi.E-Wallet');
            })->name('payment.ewallet');

            Route::get('/minimarket', function () {
                return view('transaksi.Minimarket');
            })->name('payment.minimarket');

            Route::get('/virtual-account', [BusTicketController::class, 'showVirtualAccount'])->name('payment.va');
            Route::post('/virtual-account', [BusTicketController::class, 'storePayment'])->name('payment.store.va');
        });
    });
});

Route::post('/cek-tiket', [BusTicketController::class, 'cekTiket'])->name('cek.tiket');

Route::get('/Tiket', function () {
    return view('transaksi.Tiket');
})->name('ticket.page');

Route::get('/E-Ticket', function () {
    return view('transaksi.E-Ticket');
})->name('ticket.page');

Route::middleware(['guest'])->group(function () {
    Route::get('/registrasi', [AuthController::class, 'showRegistrasi'])->name('registrasi');
    Route::post('/registrasi/submit', [AuthController::class, 'submitRegistrasi'])->name('registrasi.submit');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login/submit', [AuthController::class, 'submitLogin'])->name('login.submit');
    
    // Admin login routes
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::post('/logout-ajax', [AdminAuthController::class, 'logoutAjax'])->name('logout.ajax');


// Protected Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [AdminTicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets/create', [AdminTicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}/edit', [AdminTicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [AdminTicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [AdminTicketController::class, 'destroy'])->name('tickets.destroy');
});

Route::prefix('admin')->middleware('auth')->group(function() {
    Route::get('data-bus', [BusController::class, 'index'])->name('dataBus.index');
    Route::get('data-bus/create', [BusController::class, 'create'])->name('dataBus.create');
    Route::post('data-bus', [BusController::class, 'store'])->name('dataBus.store');
    Route::get('data-bus/{id}/edit', [BusController::class, 'edit'])->name('dataBus.edit');
    Route::put('data-bus/{id}', [BusController::class, 'update'])->name('dataBus.update');
    Route::delete('/dataBus/{bus}', [BusController::class, 'destroy'])->name('dataBus.destroy');
});

Route::prefix('admin')->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('data.penumpang');
    Route::get('users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('users', [UserController::class, 'store'])->name('user.store');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::prefix('admin')->middleware('auth')->group(function() {
    Route::get('drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::get('drivers/create', [DriverController::class, 'create'])->name('drivers.create');
    Route::post('drivers', [DriverController::class, 'store'])->name('drivers.store');
    Route::get('drivers/{driver}/edit', [DriverController::class, 'edit'])->name('drivers.edit');
    Route::put('drivers/{driver}', [DriverController::class, 'update'])->name('drivers.update');
    Route::delete('drivers/{driver}', [DriverController::class, 'destroy'])->name('drivers.destroy');
});

Route::prefix('admin')->group(function () {
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('/bookings/{id}/edit', [AdminBookingController::class, 'edit'])->name('admin.bookings.edit');
    Route::put('/bookings/{id}', [AdminBookingController::class, 'update'])->name('admin.bookings.update');
    Route::delete('/bookings/{id}', [AdminBookingController::class, 'destroy'])->name('admin.bookings.destroy');
    Route::post('/bookings/{id}/confirm', [AdminBookingController::class, 'confirm'])->name('admin.bookings.confirm');
});


Route::get('/livegpsbus', function () {
    return view('admin.LiveGPSBus');
});


Route::get('/laporanpendapatan', function () {
    return view('admin.LaporanPendapatan');
});

Route::get('/backupdata', function () {
    return view('admin.BackupData');
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

Route::get('/Live-Tracking/SDT-001', function () {
    return view('tracking.live-tracking');
});

Route::get('/Live-Tracking/SDT-001', function () {
    return view('tracking.SDT001');
});