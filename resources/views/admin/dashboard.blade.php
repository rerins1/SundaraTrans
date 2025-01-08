<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Dashboard Admin - Sundara Trans</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        
        <x-sidebar></x-sidebar>

        <!-- Main Content -->
        <main class="flex-1 ml-64">
            <x-admin-header></x-admin-header>        
            
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
                        <h3 class="text-xl font-bold mb-2">Data Penumpang</h3>
                        <a href="/admin/users" class="text-white hover:underline">Lihat <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                    <div class="bg-green-500 text-white p-4 rounded">
                        <h3 class="text-xl font-bold mb-2">Data Supir</h3>
                        <a href="/admin/drivers" class="text-white hover:underline">Lihat <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                    <div class="bg-yellow-500 text-white p-4 rounded">
                        <h3 class="text-xl font-bold mb-2">Data Jadwal Tiket</h3>
                        <a href="/admin/tickets" class="text-white hover:underline">Lihat <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                    <div class="bg-red-500 text-white p-4 rounded">
                        <h3 class="text-xl font-bold mb-2">Data Pesanan E-Tiket</h3>
                        <a href="/admin/bookings" class="text-white hover:underline">Lihat <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>