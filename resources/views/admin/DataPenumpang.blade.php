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
        <main class="flex-1">
            <x-admin-header></x-admin-header>
            

            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Data Penumpang</h2>
                <button class="bg-green-500 text-white px-4 py-2 rounded mb-4"><i class="fas fa-plus mr-2"></i>Tambah Penumpang</button>

                <table class="w-full bg-white rounded-lg overflow-hidden shadow-lg">
                    <thead>
                        <tr class="bg-gray-800 text-white text-left">
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Telepon</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Kursi</th>
                            <th class="py-3 px-4">Harga</th>
                            <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Budi</td>
                            <td class="py-3 px-4">08123456789</td>
                            <td class="py-3 px-4">budi@example.com</td>
                            <td class="py-3 px-4">12A</td>
                            <td class="py-3 px-4">Rp115.000</td>
                            <td class="py-3 px-4 flex">
                                <button class="bg-blue-500 text-white px-3 py-1 rounded mr-2"><i class="fas fa-edit"></i></button>
                                <button class="bg-red-500 text-white px-3 py-1 rounded"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
