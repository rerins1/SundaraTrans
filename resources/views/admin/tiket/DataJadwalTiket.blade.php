<!-- resources/views/admin/tiket/datajadwaltiket.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Data Pesanan Tiket</title>
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
                <h2 class="text-2xl font-bold mb-4">Pesanan Tiket</h2>
                <a href="{{ route('admin.tickets.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                    <i class="fas fa-plus mr-2"></i>Tambah Pesanan
                </a>

                <table class="w-full bg-white rounded-lg overflow-hidden shadow-lg">
                    <thead>
                        <tr class="bg-gray-800 text-white text-left">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Kelas</th>
                            <th class="py-3 px-4">Kode</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Waktu</th>
                            <th class="py-3 px-4">Dari</th>
                            <th class="py-3 px-4">Tujuan</th>
                            <th class="py-3 px-4">Kursi</th>
                            <th class="py-3 px-4">Harga</th>
                            <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $index => $ticket)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">{{ $ticket->kelas }}</td>
                            <td class="py-3 px-4">{{ $ticket->kode }}</td>
                            <td class="py-3 px-4">{{ $ticket->tanggal }}</td>
                            <td class="py-3 px-4">{{ $ticket->waktu }}</td>
                            <td class="py-3 px-4">{{ $ticket->dari }}</td>
                            <td class="py-3 px-4">{{ $ticket->tujuan }}</td>
                            <td class="py-3 px-4">{{ $ticket->kursi }}</td>
                            <td class="py-3 px-4">Rp{{ number_format($ticket->harga, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 flex">
                                <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tiket ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
