<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup Data - Dashboard Admin</title>
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
                <h2 class="text-2xl font-bold mb-4">Backup Data</h2>
                <p class="text-gray-700 mb-6">Di sini Anda dapat mencadangkan data sistem seperti data pengguna, data tiket, dan lainnya. Klik tombol di bawah untuk memulai proses backup.</p>

                <!-- Backup Data Button -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        <i class="fas fa-database mr-2"></i> Backup Data
                    </button>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
