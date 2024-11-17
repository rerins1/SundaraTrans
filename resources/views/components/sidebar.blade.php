<!-- Sidebar -->
<aside class="w-64 bg-gray-800 text-white">
    <div class="p-4">
        <h1 class="self-center text-2xl font-bold whitespace-nowrap dark:text-white">Sundara Trans</h1>
    </div>
    <div class="mt-4 p-4 bg-gray-700">
        <div class="flex items-center">
            <img src="{{ asset('img/admin.png') }}" alt="Rendy" class="w-10 h-10 rounded-full mr-3">
            <div>
                <span class="block text-sm">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </div>
    <div class="p-4">
        <input type="text" placeholder="Search..." class="w-full bg-gray-700 text-white px-3 py-2 rounded">
    </div>
    <nav class="mt-4">
        <a href="/dashboard" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-home mr-2"></i> Beranda</a>
        <a href="/datajadwaltiket" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-calendar-alt mr-2"></i> Jadwal Tiket</a>
        <a href="/databookingtiket" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-ticket-alt mr-2"></i> Data Booking Tiket</a>
        <a href="/livegpsbus" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-bus mr-2"></i> Live GPS Bus</a>
        <a href="/databus" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-bus mr-2"></i> Data Bus</a>
        <a href="/datapenumpang" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-users mr-2"></i> Data Penumpang</a>
        <a href="/datasupir" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-users mr-2"></i> Data Supir</a>
        <a href="/laporanpendapatan" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-chart-line mr-2"></i> Laporan Pendapatan</a>
        <a href="/backupdata" class="block py-2 px-4 hover:bg-gray-700"><i class="fas fa-database mr-2"></i> Backup Data</a>
    </nav>
</aside>