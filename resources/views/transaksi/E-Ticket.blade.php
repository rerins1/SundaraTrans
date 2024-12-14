<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>E-Ticket Sundara Trans</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
</head>

<body class="bg-gray-100">

    <!-- Navbar dengan posisi tetap -->
    <x-navbar class="fixed top-0 left-0 w-full z-50"></x-navbar>

    <!-- Kontainer Utama -->
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 p-4 pt-15">
        <div id="ticket-details" class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-6">
            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4">
                <h1 class="text-2xl font-bold text-orange-600">Sundara Trans | E-Ticket</h1>
                <div class="text-right">
                    <p class="text-sm">Diterbitkan oleh: Sundara Trans</p>
                </div>
            </div>

            <!-- Booking & Passenger Information -->
            <div class="grid grid-cols-2 gap-6 mt-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Booking Information</h2>
                    <div class="mt-2">
                        <p><strong>Kode Booking:</strong> {{ $kode_booking ?? 'Tidak Tersedia' }}</p>
                        <p><strong>Nama:</strong> {{ $nama_pemesan ?? 'Tidak Tersedia' }}</p>
                        <p><strong>Telepon:</strong> {{ $no_handphone ?? 'Tidak Tersedia' }}</p>
                        <p><strong>Email:</strong> {{ $email ?? 'Tidak Tersedia' }}</p>
                    </div>
                </div>

                <!-- Barcode -->
                <div class="flex flex-col items-center justify-center border border-gray-300 rounded-lg p-4 bg-gray-50">
                    <img src="data:image/png;base64,{{ $barcode }}" alt="barcode" class="max-h-24 w-auto" />
                    <p class="text-sm mt-2 text-gray-700">Kode Booking: <span class="font-bold">{{ $kode_booking ?? 'Tidak Tersedia' }}</span></p>
                </div>
            </div>

            <!-- Travel Data -->
            <div class="mt-6">
                <h2 class="text-lg font-semibold text-gray-700">Data Perjalanan</h2>
                <div class="grid grid-cols-3 gap-4 mt-2">
                    <div>
                        <p><strong>Bus:</strong> Sundara Trans</p>
                        <p><strong>Kelas:</strong> {{ $ticket->kelas }}</p>
                    </div>
                    <div>
                        <p><strong>Dari:</strong> {{ $ticket->dari }}</p>
                        <p><strong>Keberangkatan:</strong> {{ \Carbon\Carbon::parse($ticket->tanggal)->format('d M Y') }} {{ $ticket->waktu }}</p>
                    </div>
                    <div>
                        <p><strong>Tujuan:</strong> {{ $ticket->tujuan }}</p>
                        <p><strong>Total Bayar:</strong> Rp {{ number_format($ticket->harga, 0, ',', '.') }}</p>
                        <p class="text-black font-bold">
                            <strong>Status:</strong> 
                            @switch($status)
                                @case('paid')
                                    <span class="text-green-600">Pembayaran Sukses</span>
                                    @break
                                @case('pending')
                                    <span class="text-yellow-500">Menunggu Konfirmasi Admin</span>
                                    @break
                                @case('cancelled')
                                    <span class="text-red-600">Dibatalkan</span>
                                    @break
                                @default
                                    <span class="text-gray-600">Tidak Diketahui</span>
                            @endswitch
                        </p>
                    </div>
                </div>
            </div>

            <!-- Passenger Information -->
            <div class="mt-6">
                <h2 class="text-lg font-semibold text-gray-700">Informasi Penumpang</h2>
                <div class="grid grid-cols-3 gap-4 mt-2">
                    <div>
                        <p><strong>Nama Penumpang:</strong></p>
                        @if(is_array($nama_penumpang))
                            @foreach($nama_penumpang as $penumpang)
                                <p>{{ $penumpang }}</p>
                            @endforeach
                        @else
                            <p>Data tidak tersedia</p>
                        @endif
                    </div>
                    <div>
                        <p><strong>Nomor Kursi:</strong></p>
                        @if(is_array($selected_seats))
                            @foreach($selected_seats as $kursi)
                                <p>{{ $kursi }}</p>
                            @endforeach
                        @else
                            <p>Data tidak tersedia</p>
                        @endif
                    </div>
                    <div>
                        <p><strong>Kode Bus:</strong> {{ $ticket->kode }}</p>
                    </div>
                </div>
            </div>

            <!-- Aturan Sebelum Keberangkatan -->
            <div class="mt-6 p-4 border border-gray-300 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700">Aturan Sebelum Keberangkatan</h2>
                <ol class="list-decimal ml-5 mt-2">
                    <li><strong>Tiba Tepat Waktu di Terminal:</strong> Pastikan Anda tiba setidaknya 30 menit sebelum waktu keberangkatan yang tertera pada E-Ticket Anda.</li>
                    <li><strong>Cek Kembali E-Ticket dan Identitas Diri:</strong> Pastikan Anda membawa E-Ticket dalam bentuk cetak atau digital dan identitas diri yang sesuai dengan data yang terdaftar.</li>
                    <li><strong>Periksa Lokasi Keberangkatan:</strong> Pastikan Anda mengetahui lokasi terminal atau titik keberangkatan bus. Jika diperlukan, hubungi customer service atau cek aplikasi untuk informasi lebih lanjut.</li>
                    <li><strong>Lakukan Penukaran E-Ticket:</strong> Sebelum naik ke bus, pastikan Anda menukarkan E-Ticket di pos penukaran untuk mendapatkan tiket fisik atau boarding pass.</li>
                    <li><strong>Perhatikan Kode Bus dan Nomor Kursi:</strong> Pastikan Anda mengetahui nomor bus dan nomor kursi yang tertera pada E-Ticket Anda. Jika kesulitan, petugas siap membantu.</li>
                </ol>
            </div>

        </div>

        <!-- Tombol Download -->
        <div class="text-center mt-4 mb-6">
            <button onclick="downloadPDF()" class="bg-blue-500 text-white px-6 py-2 rounded-md font-semibold shadow-md hover:bg-blue-600 focus:outline-none">
                Download E-Ticket
            </button>
        </div>

        <!-- Tombol Kembali ke Home -->
        <div class="text-center mt-2">
            <a href="/" class="bg-gray-500 text-white px-6 py-2 rounded-md font-semibold shadow-md hover:bg-gray-600 focus:outline-none">
                Kembali ke Home
            </a>
        </div>
    </div>

    <script>
        function downloadPDF() {
            const element = document.getElementById('ticket-details');
            html2pdf()
                .from(element)
                .set({
                    margin: 1,
                    filename: 'E-Ticket_SundaraTrans.pdf',
                    html2canvas: { 
                        scale: 2,
                        useCORS: true,
                        logging: true,
                        letterRendering: true
                    },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                })
                .save();
        }
    </script>
</body>

</html>
