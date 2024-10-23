<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Pembayaran Tiket</title>
</head>

<body class="bg-gray-100">

    <x-navbar></x-navbar>

    <x-header>Pembayaran Tiket - Virtual Account
        <p class="text-center text-lg mt-2">Silahkan pilih ingin menggunakan Bank mana untuk melakukan pembayaran</p>
    </x-header>

    <div class="max-w-lg mx-auto mt-20 mb-20 p-5 bg-white rounded-lg shadow-md">

        <!-- Bank Selection -->
        <div class="mb-4">
            <label for="bank" class="block text-gray-700 font-semibold">Pilih Bank</label>
            <select id="bank" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                <option value="BCA">BCA</option>
                <option value="BRI">BRI</option>
                <option value="BNI">BNI</option>
                <option value="BJB">BJB</option>
                <option value="Permata">Permata</option>
                <option value="Mandiri">Mandiri</option>
            </select>
        </div>

        <!-- Payment Method Selection -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Metode Pembayaran</label>
            <div class="flex space-x-4">
                <button id="atmButton" class="flex-1 p-2 bg-blue-500 text-white rounded-md">ATM</button>
                <button id="mobileButton" class="flex-1 p-2 bg-blue-500 text-white rounded-md">Mobile</button>
                <button id="internetButton" class="flex-1 p-2 bg-blue-500 text-white rounded-md">Internet</button>
            </div>
        </div>

        <!-- Timer -->
        <div class="mb-4">
            <span class="text-lg font-semibold">Waktu tersisa: <span id="timeLeft">60 menit 0 detik</span></span>
        </div>

        <!-- Copy Bank Code -->
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
        // JavaScript untuk logika interaktif seperti sebelumnya
        const bankPaymentCodes = {
            BCA: '1234567890125225',
            BRI: '98765432109876543',
            BNI: '54321098765432109',
            BJB: '78901234567890123',
            Permata: '34567890123456789',
            Mandiri: '88898012345678901'
        };

        const bankInstructions = {
    BCA: {
        ATM: [
            'Masukkan kartu ATM dan PIN.',
            'Pilih Menu Transaksi Lainnya.',
            'Pilih Transfer.',
            'Pilih Ke rekening BCA Virtual Account.'
        ],
        Mobile: [
            'Buka aplikasi BCA Mobile.',
            'Pilih Menu Transfer > BCA Virtual Account.'
        ],
        Internet: [
            'Login Internet Banking.',
            'Pilih Transfer Dana.'
        ]
    },
    BRI: {
        ATM: [
            'Masukkan kartu ATM dan PIN.',
            'Pilih Menu Transaksi Lainnya.',
            'Pilih Transfer.',
            'Pilih Ke rekening BRI Virtual Account.'
        ],
        Mobile: [
            'Buka aplikasi BRI Mobile.',
            'Pilih Menu Transfer > BRI Virtual Account.'
        ],
        Internet: [
            'Login Internet Banking BRI.',
            'Pilih Transfer Dana.'
        ]
    },
    // Tambahkan instruksi untuk bank lainnya...
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
        function updateInstructions(method) {
            const bank = document.getElementById('bank').value;
            const instructionsElement = document.getElementById('instructions');
            instructionsElement.innerHTML = ''; // Clear previous instructions

            const selectedInstructions = bankInstructions[bank][method] || [];
            selectedInstructions.forEach(instruction => {
                const li = document.createElement('li');
                li.textContent = instruction;
                instructionsElement.appendChild(li);
            });

            // Update payment code
            document.getElementById('paymentCode').value = bankPaymentCodes[bank];
        }

        // Event listeners untuk metode pembayaran
        document.getElementById('atmButton').onclick = () => {
            updateInstructions('ATM');
        };
        document.getElementById('mobileButton').onclick = () => {
            updateInstructions('Mobile');
        };
        document.getElementById('internetButton').onclick = () => {
            updateInstructions('Internet');
        };


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
        };

        // Inisialisasi instruksi dan kode pembayaran saat halaman dimuat
        updateInstructions();
    </script>
</body>

</html>
