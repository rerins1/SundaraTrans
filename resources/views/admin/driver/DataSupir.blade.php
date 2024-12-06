<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Data Sopir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <x-sidebar></x-sidebar>

        <main class="flex-1 ml-64">
            <x-admin-header></x-admin-header>

            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Data Sopir</h2>
                <a href="{{ route('drivers.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4"><i class="fas fa-plus mr-2"></i>Tambah Sopir</a>

                <table class="w-full bg-white rounded-lg overflow-hidden shadow-lg">
                    <thead>
                        <tr class="bg-gray-800 text-white text-left">
                            <th class="py-3 px-4">Foto</th>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Telepon</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Alamat</th>
                            <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($drivers as $index => $driver)
                            <tr class="border-b">
                                <td class="py-3 px-4">
                                    <img src="{{ asset('storage/' . $driver->photo) }}" alt="{{ $driver->name }}" class="w-12 h-12 rounded-full object-cover">
                                </td>
                                <td class="py-3 px-4">{{ $loop->iteration + ($drivers->firstItem() - 1) }}</td>
                                <td class="py-3 px-4">{{ $driver->name }}</td>
                                <td class="py-3 px-4">{{ $driver->phone }}</td>
                                <td class="py-3 px-4">{{ $driver->email }}</td>
                                <td class="py-3 px-4">{{ $driver->address }}</td>
                                <td class="py-3 px-4 flex space-x-2">
                                    <a href="{{ route('drivers.edit', $driver->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                    {{ $drivers->links('pagination::tailwind') }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
