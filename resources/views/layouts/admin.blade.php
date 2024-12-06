<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <x-sidebar></x-sidebar> <!-- Menyertakan komponen sidebar (jika ada) -->

        <!-- Main Content -->
        <main class="flex-1 ml-64">
            <div class="p-6">
                @yield('content') <!-- Isi konten dari halaman yang menggunakan layout ini -->
            </div>
        </main>
    </div>
</body>
</html>