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
                        <p><strong>Kode Booking:</strong> {{ session('success') }}</p>
                        <p><strong>Nama:</strong> {{ session('nama_pemesan') }}</p>
                        <p><strong>Telepon:</strong> {{ session('no_handphone') }}</p>
                        <p><strong>Email:</strong> {{ session('email') }}</p>
                    </div>
                </div>

                <!-- Barcode -->
                <div class="flex flex-col items-center justify-center border border-gray-300 rounded-lg p-4 bg-gray-50">
                    <img src="data:image/png;base64,{{ $barcode }}" alt="barcode" class="max-h-24 w-auto" />
                    <p class="text-sm mt-2 text-gray-700">Kode Booking: <span class="font-bold">{{ session('success') }}</span></p>
                </div>
            </div>

            <!-- Travel Data -->
            <div class="mt-6">
                <h2 class="text-lg font-semibold text-gray-700">Data Perjalanan</h2>
                <div class="grid grid-cols-3 gap-4 mt-2">
                    <div>
                        <p><strong>Bus:</strong> Sundara Trans</p>
                        <p><strong>Kelas:</strong> Eksekutif</p>
                    </div>
                    <div>
                        <p><strong>Dari:</strong> {{ $ticket->dari }}</p>
                        <p><strong>Keberangkatan:</strong> {{ \Carbon\Carbon::parse($ticket->tanggal)->format('d M Y') }} {{ $ticket->waktu }}</p>
                    </div>
                    <div>
                        <p><strong>Tujuan:</strong> {{ $ticket->tujuan }}</p>
                        <p><strong>Total Bayar:</strong> Rp {{ number_format($ticket->harga, 0, ',', '.') }}</p>
                        <p class="text-green-600 font-bold mt-2">
                            <strong>Status:</strong> Pembayaran Sukses
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
                        @foreach(session('nama_penumpang') as $penumpang)
                            <p>{{ $penumpang }}</p>
                        @endforeach
                    </div>
                    <div>
                        <p><strong>Nomor Kursi:</strong></p>
                        @foreach(session('selected_seats') as $kursi)
                            <p>{{ $kursi }}</p>
                        @endforeach
                    </div>
                    <div>
                        <p><strong>Kode Bus:</strong> {{ $ticket->kode }}</p>
                    </div>
                </div>
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
