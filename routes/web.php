<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusTicketController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AuthController;

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


// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

// User Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout');