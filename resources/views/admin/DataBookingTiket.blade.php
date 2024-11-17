<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Data Booking Tiket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar>

        <!-- Main Content -->
        <main class="flex-1">
            <x-admin-header></x-admin-header>

            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Data Booking Tiket</h2>
                <button class="bg-green-500 text-white px-4 py-2 rounded mb-4"><i class="fas fa-plus mr-2"></i>Tambah Booking</button>

                <table class="w-full bg-white rounded-lg overflow-hidden shadow-lg">
                    <thead>
                        <tr class="bg-gray-800 text-white text-left">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Kode Booking</th>
                            <th class="py-3 px-4">Nama Pemesan</th>
                            <th class="py-3 px-4">No Handphone</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Waktu</th>
                            <th class="py-3 px-4">Dari</th>
                            <th class="py-3 px-4">Tujuan</th>
                            <th class="py-3 px-4">Nama Penumpang</th>
                            <th class="py-3 px-4">Kursi</th>
                            <th class="py-3 px-4">Harga</th>
                            <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">SDTN7627374</td>
                            <td class="py-3 px-4">Rendy Riansyah</td>
                            <td class="py-3 px-4">08123456789</td>
                            <td class="py-3 px-4">2024-11-15</td>
                            <td class="py-3 px-4">14:00</td>
                            <td class="py-3 px-4">Bandung (Terminal Leuwipanjang)</td>
                            <td class="py-3 px-4">Jakarta (Terminal Kalideres)</td>
                            <td class="py-3 px-4">Rendy Riansyah</td>
                            <td class="py-3 px-4">31</td>
                            <td class="py-3 px-4">Rp115.000</td>
                            <td class="py-3 px-4 flex">
                                <button class="bg-blue-500 text-white px-3 py-1 rounded mr-2"><i class="fas fa-edit"></i></button>
                                <button class="bg-red-500 text-white px-3 py-1 rounded"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <!-- Tambahkan baris lainnya jika ada data booking tiket lainnya -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
