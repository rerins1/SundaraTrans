<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Pembayaran Tiket - Minimarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <x-navbar></x-navbar>

    <x-header>Pembayaran Tiket - Minimarket
        <p class="text-center text-lg mt-2">Silahkan pilih ingin menggunakan Minimarket mana untuk melakukan pembayaran</p>
    </x-header>

    <div class="max-w-lg mx-auto mt-20 mb-20  p-5 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-center mb-6"></h1>

        <!-- Minimarket Selection -->
        <div class="mb-4">
            <label for="minimarket" class="block text-gray-700 font-semibold">Pilih minimarket</label>
            <select id="minimarket" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                <option value="Alfamart">Alfamart</option>
                <option value="Indomaret">Indomaret</option>
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
        const minimarketPaymentCodes = {
            Alfamart: 'ALFA123456789',
            Indomaret: 'INDO987654321'
        };

        const minimarketInstructions = {
            Alfamart: [
            'Pembayaran dapat dilakukan melalui Seluruh Gerai Alfamart.',
            'Anda akan mendapatkan Kode Pembayaran.',
            'Catat Kode Pembayaran yang tertera.',
            'Silahkan pergi ke gerai Alfamart terdekat dan bayar kepada kasir dengan menyebutkan "Pembayaran SundaraTrans.com"',
            'Silahkan berikan kode pembayaran yang anda dapat pada saat pemesanan.',
            'Pastikan Nama dan Jumlah bayar yang disebutkan petugas kasir Alfamart sesuai dengan pemesan anda.',
            'Kasir akan melakukan proses pembayaran, sampai mencetak struk.',
            'Simpan struk yang dicetak di kasir Alfamart sebagai bukti pembayaran anda.'
            ],
            
            Indomaret: [
                'Pembayaran dapat dilakukan melalui Seluruh Gerai Indomaret.',
                'Anda akan mendapatkan Kode Pembayaran.',
                'Catat Kode Pembayaran yang tertera.',
                'Silahkan pergi ke gerai Indomaret terdekat dan bayar kepada kasir dengan menyebutkan "Pembayaran SundaraTrans.com"',
                'Silahkan berikan kode pembayaran yang anda dapat pada saat pemesanan.',
                'Pastikan Nama dan Jumlah bayar yang disebutkan petugas kasir Indomaret sesuai dengan pemesan anda.',
                'Kasir akan melakukan proses pembayaran, sampai mencetak struk.',
                'Simpan struk yang dicetak di kasir Indomaret sebagai bukti pembayaran anda.'
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
            const minimarket = document.getElementById('minimarket').value;
            const instructionsElement = document.getElementById('instructions');
            instructionsElement.innerHTML = ''; // Hapus instruksi sebelumnya

            const selectedInstructions = minimarketInstructions[minimarket] || [];
            selectedInstructions.forEach(instruction => {
                const li = document.createElement('li');
                li.textContent = instruction;
                instructionsElement.appendChild(li);
            });

            // Update kode pembayaran
            document.getElementById('paymentCode').value = minimarketPaymentCodes[minimarket];
        }

        // Event listener untuk perubahan minimarket
        document.getElementById('minimarket').onchange = updateInstructions;

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
