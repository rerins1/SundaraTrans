<!-- resources/views/dataBus.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Data Bus</title>
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
                <h2 class="text-2xl font-bold mb-4">Data Bus</h2>

                <div class="flex items-center mb-4">
                    <form action="{{ route('dataBus.index') }}" method="GET" class="flex items-center space-x-2">
                        <!-- Input Pencarian -->
                        <div class="relative">
                            <input 
                                type="text" 
                                name="search" 
                                placeholder="Cari Bus..." 
                                value="{{ request('search') }}" 
                                class="pl-10 pr-4 py-2 border rounded w-64 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            >
                            <i class="fas fa-search absolute left-3 top-2.5 text-gray-500"></i>
                        </div>
                
                        <!-- Tombol Submit -->
                        <button 
                            type="submit" 
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            Cari
                        </button>
                    </form>
                </div>

                <a href="{{ route('dataBus.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4"><i class="fas fa-plus mr-2"></i>Tambah Bus</a>

                <table class="w-full bg-white rounded-lg overflow-hidden shadow-lg">
                    <thead>
                        <tr class="bg-gray-800 text-white text-left">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Kode Bus</th>
                            <th class="py-3 px-4">Nomor Polisi</th>
                            <th class="py-3 px-4">Kapasitas</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buses as $bus)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $loop->iteration + ($buses->firstItem() - 1) }}</td>
                            <td class="py-3 px-4">{{ $bus->kode_bus }}</td>
                            <td class="py-3 px-4">{{ $bus->no_polisi }}</td>
                            <td class="py-3 px-4">{{ $bus->kapasitas }}</td>
                            <td class="py-3 px-4">{{ $bus->status }}</td>
                            <td class="py-3 px-4 flex space-x-2">
                                <a href="{{ route('dataBus.edit', $bus->id) }}"  class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">Edit</a>
                                <form action="{{ route('dataBus.destroy', $bus->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bus ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $buses->links('pagination::tailwind') }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
