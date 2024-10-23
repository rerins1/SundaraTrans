<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Daftar Kode Bus - Sundara Trans</title>
</head>
<body>

    <div class="min-h-screen">

        <x-navbar></x-navbar>

        <x-header>Daftar Kode Bus
            <p class="text-center text-lg mt-2">Cari kode bus anda untuk melihat rute atau posisi bus anda tersebut</p></p>
        </x-header>

        <div class="container mx-auto min-h-screen mt-20">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3 mb-5">
                <!-- Daftar bus -->
                <a href="/Live-Tracking/SDT-001" class="border p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
                    <h2 class="text-xl font-semibold">Bus Bandung - Jakarta</h2>
                    <p class="text-gray-600">Kode Bus: SDT-001</p>
                </a>
                <a href="/Live-Tracking/SDT-002" class="border p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
                    <h2 class="text-xl font-semibold">Bus Bandung - Jakarta</h2>
                    <p class="text-gray-600">Kode Bus: SDT-002</p>
                </a>
                <a href="/Live-Tracking/SDT-003" class="border p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
                    <h2 class="text-xl font-semibold">Bus Bandung - Jakarta</h2>
                    <p class="text-gray-600">Kode Bus: SDT-003</p>
                </a>
                <a href="/Live-Tracking/SDT-001" class="border p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
                    <h2 class="text-xl font-semibold">Bus Bandung - Yogyakarta</h2>
                    <p class="text-gray-600">Kode Bus: SDT-001</p>
                </a>
                <a href="/Live-Tracking/SDT-002" class="border p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
                    <h2 class="text-xl font-semibold">Bus Bandung - Yogyakarta</h2>
                    <p class="text-gray-600">Kode Bus: SDT-002</p>
                </a>
                <a href="/Live-Tracking/SDT-003" class="border p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
                    <h2 class="text-xl font-semibold">Bus Bandung - Yogyakarta</h2>
                    <p class="text-gray-600">Kode Bus: SDT-003</p>
                </a>
                <a href="/Live-Tracking/SDT-001" class="border p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
                    <h2 class="text-xl font-semibold">Bus Bandung - Surabaya</h2>
                    <p class="text-gray-600">Kode Bus: SDT-001</p>
                </a>
                <a href="/Live-Tracking/SDT-002" class="border p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
                    <h2 class="text-xl font-semibold">Bus Bandung - Surabaya</h2>
                    <p class="text-gray-600">Kode Bus: SDT-002</p>
                </a>
                <a href="/Live-Tracking/SDT-003" class="border p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
                    <h2 class="text-xl font-semibold">Bus Bandung - Surabaya</h2>
                    <p class="text-gray-600">Kode Bus: SDT-003</p>
                </a>
                <a href="/Live-Tracking/SDT-001" class="border p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
                    <h2 class="text-xl font-semibold">Bus Bandung - Bali</h2>
                    <p class="text-gray-600">Kode Bus: SDT-001</p>
                </a>
                <a href="/Live-Tracking/SDT-002" class="border p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
                    <h2 class="text-xl font-semibold">Bus Bandung - Bali</h2>
                    <p class="text-gray-600">Kode Bus: SDT-002</p>
                </a>
                <a href="/Live-Tracking/SDT-003" class="border p-4 rounded-lg shadow-md hover:bg-gray-100 transition">
                    <h2 class="text-xl font-semibold">Bus Bandung - Bali</h2>
                    <p class="text-gray-600">Kode Bus: SDT-003</p>
                </a>
            </div>
        </div>
    </div>

    <x-footer></x-footer>

</body>
</html>
