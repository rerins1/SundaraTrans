<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <title>Biodata Form - Sundara Trans</title>
</head>
<body>

    <x-navbar></x-navbar>

    <x-header>Isi Informasi Penumpang
        <p class="text-center text-lg mt-2">Tolong isi informasi penumpang untuk mendapatkan E-Ticket</p>
    </x-header>

    <div class="min-h-screen justify-center items-center py-32">
        <div class="w-full max-w-full px-6 py-4">
            <form action="{{ route('store.biodata') }}" method="POST">
                @csrf
                <div class="md:flex md:space-x-6 space-y-6 md:space-y-0">
                    
                    <!-- Informasi Penumpang -->
                    <div class="bg-white p-6 rounded w-full shadow-xl md:flex-1">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block">Nama Pemesan</label>
                                <input name="nama_pemesan" type="text" class="w-full p-2 border rounded" placeholder="Masukkan Nama Pemesan" />
                            </div>
                            <div>
                                <label class="block">Email</label>
                                <input name="email" type="email" class="w-full p-2 border rounded" placeholder="Masukkan Email" />
                                <small class="text-green-600">Email diperlukan untuk mengirim e-tiket, kode bayar & OTP</small>
                            </div>
                            <div>
                                <label class="block">No Handphone</label>
                                <input name="no_handphone" type="text" class="w-full p-2 border rounded" placeholder="Masukkan No Telepon" />
                            </div>
                            <div>
                                <label class="block">Alamat</label>
                                <input name="alamat" type="text" class="w-full p-2 border rounded" placeholder="Masukkan Alamat" />
                            </div>
                            <div class="col-span-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_pemesan_penumpang" class="form-checkbox" />
                                    <span class="ml-2">Penumpang Adalah Pemesan</span>
                                </label>
                            </div>                            
                        </div>
                    </div>

                    <!-- Informasi Keberangkatan -->
                    <div class="bg-white p-4 rounded shadow-lg w-full md:w-[450px]">
                        <h3 class="text-black font-bold text-lg mb-4">Tujuan Keberangkatan</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between border-b">
                                <span class="font-semibold">Kelas Bus</span>
                                <span>{{ $ticket->kelas }}</span>
                            </div>
                            <div class="flex justify-between border-b">
                                <span class="font-semibold">Kode Bus</span>
                                <span>{{ $ticket->kode }}</span>
                            </div>
                            <div class="flex justify-between border-b">
                                <span class="font-semibold">Berangkat</span>
                                <span>{{ $ticket->dari }}</span>
                            </div>
                            <div class="flex justify-between border-b">
                                <span class="font-semibold">Tujuan</span>
                                <span>{{ $ticket->tujuan }}</span>
                            </div>
                            <div class="flex justify-between border-b">
                                <span class="font-semibold">Tanggal Keberangkatan</span>
                                <span>{{ \Carbon\Carbon::parse($ticket->tanggal)->format('d M Y') }} {{ $ticket->waktu }}</span>
                            </div>
                            <div class="flex justify-between border-b">
                                <span class="font-semibold">Jumlah Penumpang</span>
                                <span>{{ $jumlah_penumpang }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">Total Pembayaran</span>
                                <span>Rp {{ number_format($total_pembayaran, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi -->
                <div class="md:flex md:justify-between mt-6 flex-col md:flex-row space-y-4 md:space-y-0">
                    <button 
                        id="sebelumnya-button"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg w-full md:w-auto"
                    >
                        SEBELUMNYA
                    </button>
                    <button 
                        type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg w-full md:w-auto"
                    >
                        SELANJUTNYA 
                    </button>
                </div>
            </form>
        </div>

    </div>

    <x-footer></x-footer>


    <script src="{{ asset('js/biodata.js') }}"></script>
    
</body>
</html>
