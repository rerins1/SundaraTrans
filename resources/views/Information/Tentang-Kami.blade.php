<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Tentang Kami - Sundara Trans</title>
</head>
<body>

    <x-navbar></x-navbar>

    <x-header>Tentang Sundara Trans
        <p class="text-center text-lg mt-2">Perusahaan transportasi darat terkemuka di Indonesia yang berkomitmen pada kenyamanan dan keamanan penumpang.</p>
    </x-header>

    <section class='mt-8'>
        <div class="container mx-auto px-4">
            <!-- Image Section -->
            <div class="flex space-x-4">
                <img src="{{ asset('img/Akap/1.jpg') }}" alt="Bus Sundara 1" class="w-1/3 rounded-lg shadow-md" />
                <img src="{{ asset('img/Akap/2.jpg') }}" alt="Bus Sundara 2" class="w-1/3 rounded-lg shadow-md" />
                <img src="{{ asset('img/3.png') }}" alt="Bus Sundara 3" class="w-1/3 rounded-lg shadow-md" />
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto py-12 px-6 md:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Misi Kami</h2>
                <p class="text-gray-600 leading-relaxed">
                    Memberikan layanan transportasi yang dapat diandalkan dengan mengutamakan kenyamanan, keamanan, dan kepuasan penumpang, serta mendukung mobilitas masyarakat secara berkelanjutan.
                </p>
            </div>
            
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Visi Kami</h2>
                <p class="text-gray-600 leading-relaxed">
                    Menjadi perusahaan transportasi darat terkemuka di Indonesia, dikenal karena inovasi, pelayanan berkualitas tinggi, dan kontribusi terhadap kelestarian lingkungan.
                </p>
            </div>
        </div>

        <div class="mt-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Nilai-Nilai Kami</h2>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li><strong>Keandalan:</strong> Mengutamakan ketepatan waktu dan kualitas pelayanan yang konsisten.</li>
                <li><strong>Keamanan:</strong> Memastikan standar keselamatan yang tinggi dalam setiap perjalanan.</li>
                <li><strong>Kenyamanan:</strong> Fasilitas modern seperti AC, Wi-Fi, dan kursi ergonomis tersedia untuk setiap penumpang.</li>
                <li><strong>Inovasi:</strong> Terus berinovasi dalam penggunaan teknologi untuk meningkatkan pengalaman penumpang.</li>
                <li><strong>Ramah Lingkungan:</strong> Menggunakan armada bus dengan emisi rendah untuk menjaga keberlanjutan lingkungan.</li>
            </ul>
        </div>

        <div class="mt-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Layanan Kami</h2>
            <p class="text-gray-600 leading-relaxed">
                Sundara Trans menawarkan berbagai layanan transportasi untuk memenuhi kebutuhan perjalanan Anda, mulai dari bus reguler antar kota hingga layanan charter bus untuk pariwisata dan acara korporat.
            </p>
            <ul class="list-disc list-inside space-y-2 text-gray-600 mt-4">
                <li>Bus Reguler: Rute harian antar kota dan dalam kota.</li>
                <li>Bus Pariwisata: Layanan charter untuk perjalanan wisata atau kebutuhan korporat.</li>
                <li>Layanan Ekspres: Rute cepat dengan pemberhentian terbatas.</li>
            </ul>
        </div>

        <div class="mt-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Live Tracking Bus</h2>
            <p class="text-gray-600 leading-relaxed">
                Kini penumpang bisa melacak posisi bus secara real-time melalui Website Sundara Trans menggunakan Google Maps API. Fitur ini memudahkan Anda untuk mengetahui lokasi terkini bus yang Anda tumpangi atau tunggu, sehingga perjalanan Anda lebih terencana dan nyaman.
            </p>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-red-700 text-white py-16 text-center">
        <h2 class="text-3xl font-bold">Mengapa Memilih Sundara Trans?</h2>
        <p class="mt-4 text-lg max-w-4xl mx-auto">Kami menawarkan armada modern dengan fasilitas terbaik, pelacakan bus real-time, dan jaringan rute yang luas untuk kenyamanan perjalanan Anda.</p>
        <button
            onclick="handleReservationClick()"
            class="mt-6 inline-block bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-600 transition duration-300"
        >
            Booking Sekarang
        </button>
    </div>

    <x-footer></x-footer>

</body>
</html>
