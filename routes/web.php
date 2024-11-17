<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\BusTicketController;

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

            Route::get('/virtual-account', function () {
                return view('transaksi.Virtual-Account');
            })->name('payment.va');
        });
    });
});

// Ticket Display
Route::get('/Tiket', function () {
    return view('transaksi.Tiket');
})->name('show.ticket');

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

// Protected Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// Route::get('/dashboard', function () {
//     return view('admin.Dashboard');
// });

Route::get('/datajadwaltiket', function () {
    return view('admin.DataJadwalTiket');
});

Route::get('/databookingtiket', function () {
    return view('admin.DataBookingTiket');
});

Route::get('/livegpsbus', function () {
    return view('admin.LiveGPSBus');
});

Route::get('/databus', function () {
    return view('admin.DataBus');
});

Route::get('/datapenumpang', function () {
    return view('admin.DataPenumpang');
});

Route::get('/datasupir', function () {
    return view('admin.DataSupir');
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
