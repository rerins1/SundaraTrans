<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sundara Trans</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white">
            <div class="p-4">
                <h1 class="self-center text-2xl font-bold whitespace-nowrap dark:text-white">Sundara Trans</h1>
            </div>
            <div class="mt-4 p-4 bg-gray-700">
                <div class="flex items-center">
                    <img src="{{ asset('img/admin.png') }}" alt="Rendy" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <p class="font-semibold">Rendy</p>
                        <p class="text-sm text-green-400">Online</p>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <input type="text" placeholder="Search..." class="w-full bg-gray-700 text-white px-3 py-2 rounded">
            </div>
            <nav class="mt-4">
                <a href="#" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-home mr-2"></i> Beranda</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-ticket-alt mr-2"></i> Pesanan Tiket</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-shopping-cart mr-2"></i> Penjualan</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-ticket-alt mr-2"></i> Tiket</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-bus mr-2"></i> Keberangkatan</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-users mr-2"></i> Member</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-map-marker-alt mr-2"></i> Tujuan</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-calendar-alt mr-2"></i> Jadwal</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <header class="bg-blue-600 text-white p-4 flex justify-between items-center">
                <h2 class="text-xl font-bold">Admin</h2>
                <div class="flex items-center">
                    <img src="{{ asset('img/admin.png') }}" alt="Surono" class="w-8 h-8 rounded-full mr-2"> <!-- Pindahkan img ke depan span -->
                    <span class="mr-4">Rendy</span>
                    <button class="mr-4"><i class="fas fa-cog"></i></button>
                </div>
            </header>            
            
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Home</h2>
                <nav class="text-sm mb-4">
                    <span class="text-blue-600">Home</span> &gt; <span class="text-gray-500">Home</span>
                </nav>
                
                <div class="bg-green-500 text-white p-4 rounded mb-6">
                    <p>Selamat Datang ! Dimenu Adminisrator.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-blue-400 text-white p-4 rounded">
                        <h3 class="text-xl font-bold mb-2">Data Member</h3>
                        <a href="#" class="text-white hover:underline">Lihat <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                    <div class="bg-green-500 text-white p-4 rounded">
                        <h3 class="text-xl font-bold mb-2">Data Sopir</h3>
                        <a href="#" class="text-white hover:underline">Lihat <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                    <div class="bg-yellow-500 text-white p-4 rounded">
                        <h3 class="text-xl font-bold mb-2">Data Tujuan</h3>
                        <a href="#" class="text-white hover:underline">Lihat <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                    <div class="bg-red-500 text-white p-4 rounded">
                        <h3 class="text-xl font-bold mb-2">Data Jadwal</h3>
                        <a href="#" class="text-white hover:underline">Lihat <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>