<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Info Bus- Sundara Trans</title>
</head>
<body>

    <x-navbar></x-navbar>

    <x-header>Layanan Antar Kota Antar Provinsi
        <p class="text-center text-lg mt-2">Nikmati perjalanan nyaman dan aman bersama kami!</p>
    </x-header>

    <!-- Slider Section -->
    <section class="mt-8">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-semibold text-center mb-6">Pilihan Bus Terbaik</h2>
            <p class="mb-6 text-center font-serif">
                Terdiri dari Angkutan Antar Kota Dalam Provinsi (AKDP) dan Angkutan Antar Kota Antar Provinsi (AKAP).
                AKDP adalah angkutan dari satu kota ke kota lain yang melalui kabupaten/kota dalam satu daerah provinsi dengan menggunakan bus umum yang terikat dalam trayek.
                Sedangkan AKAP adalah angkutan dari satu kota ke kota lain yang melalui antar daerah kabupaten/kota yang melalui lebih dari satu daerah provinsi dengan menggunakan bus umum yang terikat dalam trayek.
                Layanan ini tersebar di lebih dari 20 kantor cabang Sundara Trans di seluruh Indonesia.
                Sundara Trans angkutan antarkota dilayani dengan kelas non-ekonomi (atau kelas komersil) yang seperti Bisnis, Eksekutif, Royal dengan beberapa jurusan seperti Bandung - Jakarta, Bandung - Yogyakarta, Bandung - Surabaya, Bandung - Bali.
            </p>
            <div class="flex space-x-4">
                <!-- Ganti dengan gambar yang sebenarnya -->
                <img src="{{ asset('img/Akap/1.jpg') }}" alt="Bus Akap Sundara 1" class="w-1/3 rounded-lg shadow-md" />
                <img src="{{ asset('img/Akap/2.jpg') }}" alt="Bus Akap Sundara 2" class="w-1/3 rounded-lg shadow-md" />
                <img src="{{ asset('img/3.png') }}" alt="Bus Akap Sundara 3" class="w-1/3 rounded-lg shadow-md" />
            </div>
        </div>
    </section>

    <!-- Info Perjalanan -->
    <section class="mt-12 bg-white py-8">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-semibold text-center mb-6">Info Perjalanan Antar Kota Antar Provinsi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-blue-50 p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-bold mb-4">Rute 1: Bandung - Jakarta</h3>
                    <p class="text-lg">Durasi: 3 jam</p>
                    <p class="text-lg">Harga: Rp 120.000</p>
                </div>
                <div class="bg-blue-50 p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-bold mb-4">Rute 2: Bandung - Bali</h3>
                    <p class="text-lg">Durasi: 26 jam</p>
                    <p class="text-lg">Harga: Rp 550.000</p>
                </div>
                <div class="bg-blue-50 p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-bold mb-4">Rute 3: Bandung - Surabaya</h3>
                    <p class="text-lg">Durasi: 11 jam</p>
                    <p class="text-lg">Harga: Rp 350.000</p>
                </div>
                <div class="bg-blue-50 p-6 rounded-lg shadow-md text-center">
                    <h3 class="text-xl font-bold mb-4">Rute 4: Bandung - Yogyakarta</h3>
                    <p class="text-lg">Durasi: 9 jam</p>
                    <p class="text-lg">Harga: Rp 250.000</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="mt-12 bg-red-700 py-8">
        <div class="container mx-auto px-4 text-center text-white">
            <h2 class="text-3xl font-bold mb-4">Pesan Tiket Sekarang!</h2>
            <button
                onclick="handleReservationClick()"
                class="mt-6 inline-block bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-600 transition duration-300"
            >
                Booking Sekarang
            </button>
        </div>
    </section>

    <x-footer></x-footer>

</body>
</html>
