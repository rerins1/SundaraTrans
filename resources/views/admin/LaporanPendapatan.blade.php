<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan - Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Main Content -->
        <main class="flex-1 ml-64">
            <x-admin-header></x-admin-header>

            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Ringkasan Pendapatan</h2>

                <!-- Pendapatan Summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-green-500 text-white p-4 rounded shadow-lg">
                        <h3 class="text-xl font-bold mb-2">Total Pendapatan</h3>
                        <p class="text-2xl">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-blue-500 text-white p-4 rounded shadow-lg">
                        <h3 class="text-xl font-bold mb-2">Pendapatan Bulan Ini</h3>
                        <p class="text-2xl">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-yellow-500 text-white p-4 rounded shadow-lg">
                        <h3 class="text-xl font-bold mb-2">Pendapatan Tahun Ini</h3>
                        <p class="text-2xl">Rp {{ number_format($pendapatanTahunIni, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Pendapatan Detail -->
                <h3 class="text-xl font-bold mb-4">Pendapatan Detail</h3>
                <table class="w-full bg-white rounded-lg overflow-hidden shadow-lg">
                    <thead>
                        <tr class="bg-gray-800 text-white text-left">
                            <th class="py-3 px-4">ID Transaksi</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Jumlah</th>
                            <th class="py-3 px-4">Metode Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendapatanDetail as $booking)
                            <tr class="border-b">
                                <td class="py-3 px-4">{{ $booking->kode_booking }}</td>
                                <td class="py-3 px-4">{{ $booking->created_at->format('Y-m-d') }}</td>
                                <td class="py-3 px-4">Rp {{ number_format($booking->total_pembayaran, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">{{ ucfirst($booking->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>                
            </div>
        </main>
    </div>
</body>
</html>