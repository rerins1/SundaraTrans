<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function laporanPendapatan()
    {
        // Ambil data pendapatan berdasarkan status 'paid'
        $totalPendapatan = Booking::where('status', 'lunas')->sum('total_pembayaran');

        $pendapatanBulanIni = Booking::where('status', 'lunas')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_pembayaran');

        $pendapatanTahunIni = Booking::where('status', 'lunas')
            ->whereYear('created_at', now()->year)
            ->sum('total_pembayaran');

        // Ambil data transaksi secara detail
        $pendapatanDetail = Booking::where('status', 'lunas')->get();

        return view('admin.LaporanPendapatan', compact(
            'totalPendapatan',
            'pendapatanBulanIni',
            'pendapatanTahunIni',
            'pendapatanDetail'
        ));
    }
}
