<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Pilih Tiket - Sundara Trans</title>
</head>
<body>

    <x-navbar></x-navbar>

    <x-header>Pilih Jam Keberangkatan
        <p class="text-center text-lg mt-2">Tetap terhubung dengan kami, dimana pun anda berada</p>
    </x-header>
    
    <div class="container mx-auto pb-24">
        <div class="flex flex-col lg:flex-row justify-between items-start pt-10">
            <div class="w-full lg:w-2/3">
                <h3 class="text-xl font-bold mb-4 pt-8 text-center">SESUAIKAN JADWAL</h3>
                <div class="bg-white p-6 px-8 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4 text-center">Tiket yang Tersedia</h2>
                    
                    {{-- Header Judul --}}
                    <div class="hidden md:flex justify-between font-semibold text-center mb-2">
                        <span class="w-1/6 text-center">Kelas Bus</span>
                        <span class="w-1/6 text-center">Kode Bus</span>
                        <span class="w-1/6 text-center">Waktu</span>
                        <span class="w-2/6 text-center">Dari - Tujuan</span>
                        <span class="w-1/6 text-center">Kursi</span>
                        <span class="w-1/6 text-center">Harga</span>
                    </div>
        
                    {{-- Daftar Tiket --}}
                    <ul class="space-y-5">
                        @forelse ($tickets as $ticket)
                            <li class="flex justify-between items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-200" onclick="window.location.href='/isi-biodata'">
                                <span class="w-1/6 text-center text-sm font-normal">{{ $ticket->kelas }}</span>
                                <span class="w-1/6 text-center text-sm font-normal">{{ $ticket->kode }}</span>
                                <span class="w-1/6 text-center text-sm font-normal">{{ $ticket->waktu }}</span>
                                <span class="w-1/6 text-center text-sm font-normal">{{ $ticket->dari }} - {{ $ticket->tujuan }}</span>
                                <span class="w-1/6 text-center text-sm font-normal">Tersedia {{ $ticket->kursi }} lagi</span>
                                <span class="w-1/6 text-center text-sm font-normal">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</span>
                            </li>
                        @empty
                            <li class="flex justify-between items-center p-4 border rounded-lg cursor-default">
                                <p class="text-md font-semibold text-left mt-4">Maaf, Tidak ada tiket tersedia.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <!-- Kotak Ubah Keberangkatan -->
            <div class="w-full lg:w-1/3 mt-6 lg:mt-0 lg:ml-6">
                <form class="space-y-2 sm:space-y-3 md:space-y-4" action="{{ route('search.bus.tickets') }}" method="POST">
                    @csrf
                    <h3 class="text-xl font-bold mb-4 pt-8 text-center">UBAH KEBERANGKATAN</h3>
                    <div class="bg-white p-4 rounded-lg shadow-lg">
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Keberangkatan</label>
                            <select name="from" class="w-full p-2 border rounded-lg">
                                <optgroup label="PILIH ASAL KOTA">
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Bandung">Bandung</option>
                                    <option value="Yogyakarta">Yogyakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                    <option value="Bali">Bali</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Tujuan</label>
                            <select name="to" class="w-full p-2 border rounded-lg">
                                <optgroup label="PILIH TUJUAN KOTA">
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Bandung">Bandung</option>
                                    <option value="Yogyakarta">Yogyakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                    <option value="Bali">Bali</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Tanggal Keberangkatan</label>
                            <input type="date" name="departure_time" class="w-full p-2 border rounded-lg" />
                        </div>
                        <div class="mb-4">
                            <label for="jumlah_penumpang" class="block text-sm font-medium mb-2">Jumlah Penumpang</label>
                            <select id="jumlah_penumpang" name="passengers" class="mt-1 block w-full p-1 sm:p-2 text-gray-500 bg-white bg-opacity-50 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" defaultValue="1">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <button 
                            type="submit"
                            class="w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 focus:outline-none"
                        >
                            CARI TIKET
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-footer></x-footer>

    <script>
        document.querySelectorAll('li.cursor-pointer').forEach(item => {
            item.addEventListener('click', function() {
                const busCode = this.querySelector('span:nth-child(2)').textContent; // Mengambil kode bus
                window.location.href = `/isi-biodata`; // Arahkan ke halaman pemesanan
            });
        });
    </script>
</body>

</html>
