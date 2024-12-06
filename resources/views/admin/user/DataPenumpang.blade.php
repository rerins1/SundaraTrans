<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Data Penumpang</title>
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

            <!-- Data Penumpang Section -->
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Data Penumpang</h2>
                <div class="flex justify-end mb-4">
                    <a href="{{ route('user.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded flex items-center">
                        <i class="fas fa-plus mr-2"></i>Tambah Penumpang
                    </a>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full bg-white rounded-lg shadow-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-800 text-white">
                                <th class="py-3 px-4">No</th>
                                <th class="py-3 px-4">Nama</th>
                                <th class="py-3 px-4">Email</th>
                                <th class="py-3 px-4">Password</th>
                                <th class="py-3 px-4">Role</th>
                                <th class="py-3 px-4">Telepon</th>
                                <th class="py-3 px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr class="border-b hover:bg-gray-100">
                                    <!-- Hitung No berdasarkan halaman -->
                                    <td class="py-3 px-4">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td class="py-3 px-4">{{ $user->name }}</td>
                                    <td class="py-3 px-4">{{ $user->email }}</td>
                                    <td class="py-3 px-4">********</td>
                                    <td class="py-3 px-4 capitalize">{{ $user->role }}</td>
                                    <td class="py-3 px-4">{{ $user->phone }}</td>
                                    <td class="py-3 px-4 flex space-x-2">
                                        <a href="{{ route('user.edit', $user->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $users->links('pagination::tailwind') }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
