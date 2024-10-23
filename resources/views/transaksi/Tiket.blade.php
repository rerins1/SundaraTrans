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

    
    <div id="ticket-details" class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-6">
        <!-- Header Shopee-like style -->
        <div class="flex justify-between items-center border-b pb-4">
            <h1 class="text-2xl font-bold text-orange-600">Sundara Trans | E-Ticket</h1>
            <div class="text-right">
                <p class="text-sm">Kode Booking: <span class="font-bold">SDTN7627374</span></p>
                <p class="text-sm">Diterbitkan oleh: Sundara Trans</p>
            </div>
        </div>

        <!-- Booking & Passenger Information -->
        <div class="grid grid-cols-2 gap-6 mt-4">
            <!-- Left - Booking Info -->
            <div>
                <h2 class="text-lg font-semibold text-gray-700">Booking Information</h2>
                <div class="mt-2">
                    <p><strong>Booking ID:</strong> SDTN7627374</p>
                    <p><strong>Nama:</strong> Rendy Riansyah</p>
                    <p><strong>Telepon:</strong> +628123456789</p>
                    <p><strong>Email:</strong> rendyriansyah@example.com</p>
                    <p><strong>Tanggal Pesan:</strong> 10-10-2024, 13:00</p>
                </div>
            </div>

            <!-- Barcode (can use image or similar for simplicity) -->
            <div class="flex justify-center mb-6">
                <img src="https://barcode.tec-it.com/barcode.ashx?data=SDTN7627374" alt="barcode" />
            </div>
        </div>

        <!-- Travel Data -->
        <div class="mt-6">
            <h2 class="text-lg font-semibold text-gray-700">Data Perjalanan</h2>
            <div class="grid grid-cols-3 gap-4 mt-2">
                <div>
                    <p><strong>Bus:</strong> Sundara Trans</p>
                    <p><strong>Kelas:</strong> EXECUTIVE</p>
                </div>
                <div>
                    <p><strong>Dari:</strong> Bandung (Terminal Cicaheum)</p>
                    <p><strong>Keberangkatan:</strong> 10-10-2024, 14:30</p>
                </div>
                <div>
                    <p><strong>Tujuan:</strong> Bali (Denpasar)</p>
                    <p><strong>Harga:</strong> Rp. 1.100.000</p>
                    <p class="text-green-600 font-bold mt-2"><strong>Status:</strong> Sudah Terbayar</p>
                </div>
            </div>
        </div>

        <!-- Passenger Information -->
        <div class="mt-6">
            <h2 class="text-lg font-semibold text-gray-700">Informasi Penumpang</h2>
            <div class="grid grid-cols-3 gap-4 mt-2">
                <div>
                    <p><strong>Nama Penumpang 1:</strong> John Doe</p>
                </div>
                <div>
                    <p><strong>Nomor Kursi:</strong> 25</p>
                </div>
                <div>
                    <p><strong>Kode Bus:</strong> SDT001</p>
                </div>
            </div>
        </div>

        <!-- Important Notice -->
        <div class="mt-6 border-t pt-4">
            <h2 class="text-lg font-semibold text-red-600">Hal Penting</h2>
            <ul class="list-disc list-inside text-sm text-gray-700 mt-2">
                <li>Mohon tiba di terminal 60 menit sebelum keberangkatan.</li>
                <li>Tunjukkan e-Ticket beserta identitas resmi.</li>
                <li>Anda dapat menggunakan e-Ticket dari email atau aplikasi.</li>
                <li>Waktu yang tertera adalah waktu keberangkatan dari terminal asal.</li>
                <li>Hubungi Call Center untuk kendala lainnya.</li>
            </ul>
        </div>
    </div>

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
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                })
                .save();
        }
    </script>
</body>

</html>