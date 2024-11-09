<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Pembayaran Tiket - E-Wallet</title>
</head>

<body class="bg-gray-100">

    <x-navbar></x-navbar>

    <x-header>Pembayaran Tiket - E-Wallet
        <p class="text-center text-lg mt-2">Silahkan pilih ingin menggunakan E-Wallet mana untuk melakukan pembayaran</p>
    </x-header>

    <div class="max-w-lg mx-auto mt-20 p-5 bg-white rounded-lg shadow-md mb-20">

        <!-- E-Wallet Selection -->
        <div class="mb-4">
            <label for="ewallet" class="block text-gray-700 font-semibold">Pilih E-Wallet</label>
            <select id="ewallet" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                <option value="Dana">Dana</option>
                <option value="OVO">OVO</option>
                <option value="Gopay">Gopay</option>
                <option value="LinkAja">LinkAja</option>
                <option value="ShopeePay">ShopeePay</option>
            </select>
        </div>

        <!-- Timer -->
        <div class="mb-4">
            <span class="text-lg font-semibold">Waktu tersisa: <span id="timeLeft">60 menit 0 detik</span></span>
        </div>

        <!-- Copy Payment Code -->
        <div class="mb-4">
            <label class="block text-gray-700">Kode Pembayaran:</label>
            <div class="flex items-center">
                <input type="text" id="paymentCode" class="mt-1 flex-1 p-2 border border-gray-300 rounded-md" readonly />
                <button id="copyButton" class="ml-2 p-2 bg-green-500 text-white rounded-md">Salin</button>
            </div>
        </div>

        <!-- Instructions -->
        <div>
            <h2 class="text-xl font-bold mb-2">Instruksi Pembayaran</h2>
            <ul id="instructions" class="list-disc pl-5 text-gray-700">
                <!-- Instruksi akan diisi melalui JavaScript -->
            </ul>
        </div>

        <!-- Finish Button -->
        <button id="finishButton" class="mt-4 w-full p-2 bg-blue-600 text-white rounded-md">Selesaikan Pembayaran</button>
    </div>

    <x-footer></x-footer>

    <script>
        const ewalletPaymentCodes = {
            Dana: 'DANA123456789',
            OVO: 'OVO987654321',
            Gopay: 'GOPAY543210987',
            LinkAja: 'LINKAJA654321098',
            ShopeePay: 'SHOPEEPAY876543210'
        };

        const ewalletInstructions = {
            Dana: [
                'Buka aplikasi DANA dan masuk ke akun Anda.',
                'Pilih opsi "Pembayaran" atau "Transfer Virtual Account".',
                'Masukkan nomor Virtual Account yang diperoleh dari reservasi tiket bus.',
                'Periksa dan konfirmasi detail pembayaran Anda.',
                'Simpan bukti pembayaran setelah transaksi berhasil.'
            ],

            OVO: [
            'Buka aplikasi OVO di smartphone Anda.',
            'Pilih menu "Pembayaran".',
            'Masukkan kode atau nomor Virtual Account yang diberikan setelah pemesanan tiket bus.',
            'Konfirmasi detail pembayaran yang tertera dan lanjutkan transaksi.',
            'Simpan bukti pembayaran yang muncul sebagai konfirmasi pembayaran tiket bus.'
            ],

            LinkAja: [
                'Buka aplikasi LinkAja di ponsel Anda.',
                'Pilih menu "Bayar" dan masukkan nomor Virtual Account dari tiket bus yang dipesan.',
                'Pastikan detail pembayaran sudah benar dan lanjutkan.',
                'Simpan bukti pembayaran yang ditampilkan di aplikasi.'
            ],

            Gopay: [
                'Buka aplikasi Gojek, pilih menu "GoPay" atau "Bayar".',
                'Masukkan nomor Virtual Account yang diberikan setelah pemesanan tiket bus.',
                'Konfirmasi jumlah pembayaran dan selesaikan transaksi.',
                'Simpan bukti pembayaran untuk referensi pembelian tiket bus.'
            ],

            ShopeePay: [
                'Buka aplikasi Shopee dan masuk ke "ShopeePay".',
                'Pilih opsi "Transfer" dan pilih bank tujuan (misalnya BNI, BCA, atau Mandiri) yang terkait dengan Virtual Account.',
                'Masukkan nomor Virtual Account yang diberikan dari pemesanan tiket bus.',
                'Konfirmasi detail pembayaran, pilih sumber dana dari ShopeePay, lalu selesaikan transaksi.',
                'Simpan bukti pembayaran untuk referensi transaksi tiket bus.'
            ]
        };

        let timeLeft = 3600; // 1 jam dalam detik
        const timerElement = document.getElementById('timeLeft');

        // Update timer setiap detik
        const timerInterval = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                alert("Waktu pembayaran habis. Transaksi gagal.");
                return;
            }
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes} menit ${seconds} detik`;
        }, 1000);

        // Fungsi untuk memperbarui instruksi pembayaran
        function updateInstructions() {
            const ewallet = document.getElementById('ewallet').value;
            const instructionsElement = document.getElementById('instructions');
            instructionsElement.innerHTML = ''; // Hapus instruksi sebelumnya

            const selectedInstructions = ewalletInstructions[ewallet] || [];
            selectedInstructions.forEach(instruction => {
                const li = document.createElement('li');
                li.textContent = instruction;
                instructionsElement.appendChild(li);
            });

            // Update kode pembayaran
            document.getElementById('paymentCode').value = ewalletPaymentCodes[ewallet];
        }

        // Event listener untuk perubahan e-wallet
        document.getElementById('ewallet').onchange = updateInstructions;

        // Event listener untuk tombol salin
        document.getElementById('copyButton').onclick = () => {
            const paymentCode = document.getElementById('paymentCode').value;
            navigator.clipboard.writeText(paymentCode).then(() => {
                alert("Kode pembayaran telah disalin!");
            });
        };

        // Event listener untuk tombol selesai
        document.getElementById('finishButton').onclick = () => {
            alert("Pembayaran selesai. Terima kasih!");
            // Navigasi ke halaman detail tiket jika perlu
            window.location.href = "/Tiket";
        };

        // Inisialisasi instruksi dan kode pembayaran saat halaman dimuat
        updateInstructions();
    </script>
</body>

</html>
