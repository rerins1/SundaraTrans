<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>E-Ticket Sundara Trans</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
</head>

<body class="flex flex-col items-center justify-center min-h-screen bg-gray-100 p-4">
    {{-- Tambahkan debugging di sini --}}
    @if(isset($booking))
        {{ dd($booking) }}
    @endif

    <!-- Konten tiket yang sudah ada -->
    @if(isset($booking) && $booking->ticket)
    <div id="ticket-details" class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-6">
        <!-- Header -->
        <div class="flex justify-between items-center border-b pb-4">
            <h1 class="text-2xl font-bold text-orange-600">Sundara Trans | E-Ticket</h1>
            <div class="text-right">
                <p class="text-sm">Kode Booking: <span class="font-bold">{{ $booking->kode_booking }}</span></p>
                <p class="text-sm">Diterbitkan oleh: Sundara Trans</p>
            </div>
        </div>

        <!-- Booking & Passenger Information -->
        <div class="grid grid-cols-2 gap-6 mt-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-700">Booking Information</h2>
                <div class="mt-2">
                    <p><strong>Booking ID:</strong> {{ $booking->kode_booking }}</p>
                    <p><strong>Nama:</strong> {{ $booking->nama_pemesan }}</p>
                    <p><strong>Telepon:</strong> {{ $booking->no_handphone }}</p>
                    <p><strong>Email:</strong> {{ $booking->email }}</p>
                </div>
            </div>

            <!-- Barcode -->
            <div class="flex justify-center items-center">
                <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($booking->kode_booking, 'C39+') }}" 
                        alt="barcode" 
                        class="max-h-24" />
            </div>
        </div>

        <!-- Travel Data -->
        <div class="mt-6">
            <h2 class="text-lg font-semibold text-gray-700">Data Perjalanan</h2>
            <div class="grid grid-cols-3 gap-4 mt-2">
                <div>
                    <p><strong>Bus:</strong> Sundara Trans</p>
                    <p><strong>Kelas:</strong> {{ $booking->ticket->kelas }}</p>
                </div>
                <div>
                    <p><strong>Dari:</strong> {{ $booking->ticket->dari }}</p>
                    <p><strong>Keberangkatan:</strong> 
                        {{ \Carbon\Carbon::parse($booking->ticket->tanggal)->format('d M Y') }}, 
                        {{ $booking->ticket->waktu }}
                    </p>
                </div>
                <div>
                    <p><strong>Tujuan:</strong> {{ $booking->ticket->tujuan }}</p>
                    <p><strong>Total Bayar:</strong> Rp {{ number_format($booking->total_pembayaran, 0, ',', '.') }}</p>
                    <p class="text-green-600 font-bold mt-2">
                        <strong>Status:</strong> {{ ucfirst($booking->status) }}
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
                    <ul class="list-disc list-inside">
                        @foreach($booking->nama_penumpang as $penumpang)
                            <li>{{ $penumpang }}</li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <p><strong>Nomor Kursi:</strong></p>
                    <ul class="list-disc list-inside">
                        @foreach($booking->kursi as $kursi)
                            <li>Kursi {{ $kursi }}</li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <p><strong>Kode Bus:</strong> {{ $booking->ticket->kode }}</p>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="text-center p-6">
        <p class="text-red-600">Data tiket tidak ditemukan</p>
        <a href="{{ route('search.bus.tickets') }}" 
            class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">
            Kembali ke Pencarian
        </a>
    </div>
@endif

    <!-- Tombol Download -->
    <div class="text-center mt-4 mb-6">
        <button onclick="downloadPDF()" class="bg-blue-500 text-white px-6 py-2 rounded-md font-semibold shadow-md hover:bg-blue-600 focus:outline-none">
            Download E-Ticket
        </button>
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