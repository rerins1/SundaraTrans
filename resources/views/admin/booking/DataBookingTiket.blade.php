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
        <main class="flex-1 ml-64">
            <x-admin-header></x-admin-header>

            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Data Booking Tiket</h2>

                <div class="flex items-center mb-4">
                    <form action="{{ route('admin.bookings.index') }}" method="GET" class="flex space-x-2">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari Booking..." 
                            value="{{ request('search') }}" 
                            class="px-4 py-2 border rounded w-64"
                        >
                        <button 
                            type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            Cari
                        </button>
                    </form>
                </div>

                @if(session('success'))
                    <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-200 text-red-800 p-4 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <table class="w-full bg-white rounded-lg overflow-hidden shadow-lg">
                    <thead>
                        <tr class="bg-gray-800 text-white text-left">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Kode Booking</th>
                            <th class="py-3 px-4">Nama Pemesan</th>
                            <th class="py-3 px-4">No Handphone</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Dari</th>
                            <th class="py-3 px-4">Tujuan</th>
                            <th class="py-3 px-4">Nama Penumpang</th>
                            <th class="py-3 px-4">Kursi</th>
                            <th class="py-3 px-4">Harga</th>
                            <th class="py-3 px-4">Bukti Pembayaran</th>
                            <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $index => $booking)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $loop->iteration + ($bookings->firstItem() - 1) }}</td>
                            <td class="py-3 px-4">{{ $booking->kode_booking }}</td>
                            <td class="py-3 px-4">{{ $booking->nama_pemesan }}</td>
                            <td class="py-3 px-4">{{ $booking->no_handphone }}</td>
                            <td class="py-3 px-4">{{ $booking->ticket->tanggal ?? 'N/A' }}</td>
                            <td class="py-3 px-4">{{ $booking->ticket->dari ?? 'N/A' }}</td>
                            <td class="py-3 px-4">{{ $booking->ticket->tujuan ?? 'N/A' }}</td>
                            <td class="py-3 px-4">
                                @php 
                                    $namaPenumpang = json_decode($booking->nama_penumpang);
                                    echo implode(', ', $namaPenumpang);
                                @endphp
                            </td>
                            <td class="py-3 px-4">
                                @php 
                                    $kursi = json_decode($booking->kursi);
                                    echo implode(', ', $kursi);
                                @endphp
                            </td>
                            <td class="py-3 px-4">Rp {{ number_format($booking->total_pembayaran, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                @if($booking->bukti_pembayaran)
                                    <a href="{{ Storage::url($booking->bukti_pembayaran) }}" 
                                        target="_blank" 
                                        class="text-blue-500 hover:underline">
                                        Lihat Bukti
                                    </a>
                                @else
                                    <span class="text-gray-500">Tidak ada</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 flex space-x-2">
                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.bookings.edit', $booking->id) }}"
                                    class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">
                                    Edit
                                </a>
                            
                                <!-- Tombol Delete -->
                                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </form>
                            
                                <!-- Tombol Konfirmasi -->
                                <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit"
                                        class="bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600 transition">
                                        Konfirmasi
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $bookings->links('pagination::tailwind') }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
