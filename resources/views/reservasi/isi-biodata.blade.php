<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <div class="md:flex md:space-x-6 space-y-6 md:space-y-0">
                
                <!-- Informasi Penumpang -->
                <div class="bg-white p-6 rounded w-full shadow-xl md:flex-1">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block">Nama Pemesan</label>
                            <input type="text" class="w-full p-2 border rounded" placeholder="Masukkan Nama Pemesan" />
                        </div>
                        <div>
                            <label class="block">Email</label>
                            <input type="email" class="w-full p-2 border rounded" placeholder="Masukkan Email" />
                            <small class="text-green-600">Email diperlukan untuk mengirim e-tiket, kode bayar & OTP</small>
                        </div>
                        <div>
                            <label class="block">No Handphone</label>
                            <input type="text" class="w-full p-2 border rounded" placeholder="Masukkan No Telepon" />
                        </div>
                        <div>
                            <label class="block">Alamat</label>
                            <input type="text" class="w-full p-2 border rounded" placeholder="Masukkan Alamat" />
                        </div>
                        <div>
                            <label class="block">Nama Penumpang 1</label>
                            <input type="text" class="w-full p-2 border rounded" placeholder="Masukkan Nama Penumpang 1" />
                        </div>
                        <div class="col-span-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="form-checkbox" checked />
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
                            <span>Eksekutif</span>
                        </div>
                        <div class="flex justify-between border-b">
                            <span class="font-semibold">Kode Bus</span>
                            <span>B111</span>
                        </div>
                        <div class="flex justify-between border-b">
                            <span class="font-semibold">Berangkat</span>
                            <span>Bandung</span>
                        </div>
                        <div class="flex justify-between border-b">
                            <span class="font-semibold">Titik Naik</span>
                            <span>Terminal Cicaheum</span>
                        </div>
                        <div class="flex justify-between border-b">
                            <span class="font-semibold">Tujuan</span>
                            <span>Denpasar</span>
                        </div>
                        <div class="flex justify-between border-b">
                            <span class="font-semibold">Titik Turun</span>
                            <span>Denpasar</span>
                        </div>
                        <div class="flex justify-between border-b">
                            <span class="font-semibold">Keberangkatan</span>
                            <span>1 Des 2024 07:30 AM</span>
                        </div>
                        <div class="flex justify-between border-b">
                            <span class="font-semibold">Kedatangan</span>
                            <span>2 Des 2024 09:10 PM</span>
                        </div>
                        <div class="flex justify-between border-b">
                            <span class="font-semibold">Penumpang</span>
                            <span>2</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-semibold">Pembayaran</span>
                            <span>Rp 1.100.000</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Navigasi -->
            <div class="md:flex md:justify-between mt-6 flex-col md:flex-row space-y-4 md:space-y-0">
                <button 
                    onclick="navigateToPilihTiket()"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg w-full md:w-auto"
                >
                    SEBELUMNYA
                </button>
                <button 
                onclick="handleNextClick()"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg w-full md:w-auto"
                >
                    SELANJUTNYA 
                </button>
            </div>
        </div>

    </div>

    <x-footer></x-footer>

    <script>    
        function navigateToPilihTiket() {
            // Tambahkan logika untuk navigasi ke halaman Biodata Form
            window.location.href = '/pilih-tiket'; // Ganti dengan URL yang sesuai
        }

        function handleNextClick() {
            // Tambahkan logika untuk navigasi ke halaman Biodata Form
            window.location.href = '/kursi-31'; // Ganti dengan URL yang sesuai
        }
    </script>
</body>
</html>
