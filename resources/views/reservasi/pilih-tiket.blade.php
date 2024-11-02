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
                    <div class="hidden md:grid grid-cols-12 gap-2 font-semibold mb-2">
                        <span class="col-span-2 text-center">Kelas Bus</span>
                        <span class="col-span-2 text-center">Kode Bus</span>
                        <span class="col-span-1 text-center">Waktu</span>
                        <span class="col-span-3 text-center">Dari - Tujuan</span>
                        <span class="col-span-2 text-center">Kursi</span>
                        <span class="col-span-2 text-center">Harga</span>
                    </div>
            
                    {{-- Daftar Tiket --}}
                    <ul class="space-y-5">
                        @forelse ($tickets as $ticket)
                        <li class="grid grid-cols-12 md:gap-2 items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-200" 
                            onclick="window.location.href='{{ route('tickets.biodata', $ticket->kode) }}'">
                            {{-- Tampilan Mobile --}}
                            <div class="col-span-12 md:hidden grid grid-cols-1 gap-2">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold">{{ $ticket->kelas }}</span>
                                    <span class="text-blue-600 font-semibold">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm text-gray-600">
                                    <span>{{ $ticket->kode }}</span>
                                    <span>{{ $ticket->waktu }}</span>
                                </div>
                                <div class="text-sm">
                                    <div class="font-medium">{{ $ticket->dari }}</div>
                                    <div class="flex items-center my-1">
                                        <div class="w-1 h-8 bg-gray-300 mx-2"></div>
                                    </div>
                                    <div class="font-medium">{{ $ticket->tujuan }}</div>
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-sm text-green-600">Tersedia {{ $ticket->kursi }} kursi</span>
                                </div>
                            </div>
                    
                            {{-- Tampilan Desktop --}}
                            <span class="hidden md:block col-span-2 text-center">{{ $ticket->kelas }}</span>
                            <span class="hidden md:block col-span-2 text-center">{{ $ticket->kode }}</span>
                            <span class="hidden md:block col-span-1 text-center">{{ $ticket->waktu }}</span>
                            <span class="hidden md:block col-span-3 text-center">{{ $ticket->dari }} - {{ $ticket->tujuan }}</span>
                            <span class="hidden md:block col-span-2 text-center">Tersedia {{ $ticket->kursi }} lagi</span>
                            <span class="hidden md:block col-span-2 text-center">Rp {{ number_format($ticket->harga, 0, ',', '.') }}</span>
                        </li>
                        @empty
                            <li class="flex justify-center p-4 border rounded-lg cursor-default">
                                <p class="text-md font-semibold">{{ $message ?? 'Maaf, Tidak ada tiket tersedia.' }}</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <!-- Kotak Ubah Keberangkatan -->
            <div class="w-full lg:w-1/3 mt-6 lg:mt-0 lg:ml-6">
                <form class="space-y-2 sm:space-y-3 md:space-y-4" id="form-booking" action="{{ route('search.bus.tickets') }}" method="POST">
                    @csrf
                    <h3 class="text-xl font-bold mb-4 pt-8 text-center">UBAH KEBERANGKATAN</h3>
                    <div class="bg-white p-4 rounded-lg shadow-lg">
                        <div class="mb-4">
                            <label for="dari" class="block text-sm font-medium mb-2">Keberangkatan</label>
                            <select id="dari" name="dari" class="w-full p-2 border rounded-lg">
                                <optgroup label="PILIH ASAL KOTA">
                                    <option value="" selected>Silahkan Pilih Kota Asal</option>
                                    <option value="Bandung">Bandung</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Yogyakarta">Yogyakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                    <option value="Bali">Bali</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="tujuan" class="block text-sm font-medium mb-2">Tujuan</label>
                            <select id="tujuan" name="tujuan" class="w-full p-2 border rounded-lg">
                                <optgroup label="PILIH TUJUAN KOTA">
                                    <option value="" selected>Silahkan Pilih Kota Tujuan</option>
                                    <option value="Bandung">Bandung</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Yogyakarta">Yogyakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                    <option value="Bali">Bali</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="tanggal" class="block text-sm font-medium mb-2">Tanggal Keberangkatan</label>
                            <input type="date" id="tanggal" name="tanggal" class="w-full p-2 border rounded-lg" />
                        </div>
                        <div class="mb-4">
                            <label for="jumlah_penumpang" class="block text-sm font-medium mb-2">Jumlah Penumpang</label>
                            <select id="jumlah_penumpang" name="jumlah_penumpang" class="w-full p-2 border rounded-lg">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <!-- Error message -->
                        <div id="error" class="hidden text-red-500"></div>
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

    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
