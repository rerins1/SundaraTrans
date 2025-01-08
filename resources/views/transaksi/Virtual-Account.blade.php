<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Pembayaran Tiket</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html, body {
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        .custom-file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .custom-file-upload input[type="file"] {
            opacity: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            cursor: pointer;
            z-index: 2;
        }

        .custom-file-label {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #3b82f6;
            color: white;
            border-radius: 0.375rem;
            cursor: pointer;
        }

        .file-name {
            margin-left: 1rem;
            color: #4b5563;
        }
    </style>
</head>

<body class="bg-gray-100 h-screen w-full m-0 p-0">
    <div class="min-h-screen flex flex-col">
        <x-navbar></x-navbar>

        <x-header>Pembayaran Tiket - Virtual Account
            <p class="text-center text-lg mt-2">Silahkan pilih ingin menggunakan Bank mana untuk melakukan pembayaran</p>
        </x-header>

        <div class="flex-grow">
            <form action="{{ route('payment.store.va') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="max-w-lg mx-auto mt-20 mb-20 p-5 bg-white rounded-lg shadow-md">
                    <div class="mb-4">
                        <label for="bank" class="block text-gray-700 font-semibold">Pilih Bank</label>
                        <select id="bank" name="bank" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                            <option value="BCA">BCA</option>
                            <option value="BRI">BRI</option>
                            <option value="BNI">BNI</option>
                            <option value="BJB">BJB</option>
                            <option value="Permata">Permata</option>
                            <option value="Mandiri">Mandiri</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold">Metode Pembayaran</label>
                        <div class="flex space-x-4">
                            <button type="button" id="atmButton" class="flex-1 p-2 bg-blue-500 text-white rounded-md">ATM</button>
                            <button type="button" id="mobileButton" class="flex-1 p-2 bg-blue-500 text-white rounded-md">Mobile</button>
                            <button type="button" id="internetButton" class="flex-1 p-2 bg-blue-500 text-white rounded-md">Internet</button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="text-lg font-semibold">Waktu tersisa: <span id="timeLeft">60 menit 0 detik</span></span>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700">Kode Pembayaran:</label>
                        <div class="flex items-center">
                            <input type="text" id="paymentCode" class="mt-1 flex-1 p-2 border border-gray-300 rounded-md" readonly />
                            <button id="copyButton" class="ml-2 p-2 bg-green-500 text-white rounded-md">Salin</button>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-xl font-bold mb-2">Instruksi Pembayaran</h2>
                        <ul id="instructions" class="list-disc pl-5 text-gray-700"></ul>
                    </div>

                    <input type="hidden" name="payment_code" id="paymentCodeInput">
                    <input type="hidden" name="bank" id="bankInput">

                    <div class="mb-4 mt-4">
                        <label class="block text-gray-700 font-semibold">Upload Bukti Pembayaran</label>
                        <div class="custom-file-upload mt-1 p-2 border border-gray-300 rounded-md">
                            <label class="custom-file-label">Pilih File</label>
                            <span class="file-name">Tidak Ada File yang Dipilih</span>
                            <input type="file" 
                                    id="bukti_pembayaran" 
                                    name="bukti_pembayaran" 
                                    accept="image/jpeg,image/png,image/jpg" 
                                    class="@error('bukti_pembayaran') border-red-500 @enderror">
                        </div>
                        <p id="bukti_pembayaran_error" class="text-red-500 text-sm mt-2 hidden"></p>
                        
                        @error('bukti_pembayaran')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" id="finishButton" class="mt-4 w-full p-2 bg-blue-600 text-white rounded-md">
                        Selesaikan Pembayaran
                    </button>
                </div>
            </form>
        </div>

        <x-footer></x-footer>
    </div>

    <script>
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
                    'Pilih Ke rekening BCA Virtual Account.',
                    'Input Nomor Virtual Account, misal. 123456789012XXXX.',
                    'Pilih Benar.',
                    'Pilih Ya.',
                    'Ambil bukti bayar anda.'
                ],
                Mobile: [
                    'Buka aplikasi BCA Mobile.',
                    'Pilih Menu Transfer > BCA Virtual Account.',
                    'Masukkan Nomor Virtual Account, contoh: 123XXXXXX dan pilih Send.',
                    'Periksa informasi yang tertera di layar. Pastikan informasi dan total tagihan sudah benar. Jika benar pilih Ya.',
                    'Masukkan PIN m-BCA Anda dan pilih OK.',
                    'Ambil bukti bayar anda.'
                ],
                Internet: [
                    'Login Internet Banking.',
                    'Pilih Transfer Dana.',
                    'Pilih Transfer Ke BCA Virtual Account.',
                    'Input Nomor Virtual Account, misal. 123456789012XXXX.',
                    'Klik Lanjutkan.',
                    'Input Respon KeyBCA Appli 1',
                    'Klik Kirim.',
                    'Bukti bayar ditampilkan.'
                ]
            }
        };

        // Inisialisasi waktu tersisa dari LocalStorage atau default 3600 detik (60 menit)
        let timeLeft = parseInt(localStorage.getItem('timeLeft')) || 3600;

        const timerElement = document.getElementById('timeLeft');

        const updateTimeLeft = () => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes} menit ${seconds} detik`;
        };

        // Menyimpan waktu yang tersisa ke LocalStorage setiap detik
        const timerInterval = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                alert("Waktu pembayaran habis. Transaksi gagal.");
                localStorage.removeItem('timeLeft'); // Hapus waktu tersimpan
                return;
            }
            timeLeft--;
            localStorage.setItem('timeLeft', timeLeft); // Simpan ke LocalStorage
            updateTimeLeft();
        }, 1000);

        // Perbarui tampilan awal waktu saat halaman dimuat
        updateTimeLeft();

        function updateInstructions(method) {
            const bank = document.getElementById('bank').value;
            const instructionsElement = document.getElementById('instructions');
            instructionsElement.innerHTML = '';

            const selectedInstructions = bankInstructions[bank][method] || [];
            selectedInstructions.forEach(instruction => {
                const li = document.createElement('li');
                li.textContent = instruction;
                instructionsElement.appendChild(li);
            });

            document.getElementById('paymentCode').value = bankPaymentCodes[bank];
        }

        document.getElementById('atmButton').onclick = () => updateInstructions('ATM');
        document.getElementById('mobileButton').onclick = () => updateInstructions('Mobile');
        document.getElementById('internetButton').onclick = () => updateInstructions('Internet');

        document.getElementById('copyButton').onclick = async () => {
            try {
                const paymentCode = document.getElementById('paymentCode').value;
                await navigator.clipboard.writeText(paymentCode);
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Kode pembayaran telah disalin!',
                    timer: 10000,
                    showConfirmButton: false
                });
            } catch (err) {
                // Fallback method if clipboard API fails
                const paymentInput = document.getElementById('paymentCode');
                paymentInput.select();
                document.execCommand('copy');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Kode pembayaran telah disalin!',
                    timer: 10000,
                    showConfirmButton: false
                });
            }
        };

        const fileInput = document.getElementById('bukti_pembayaran');
        const fileName = document.querySelector('.file-name');

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                fileName.textContent = this.files[0].name;
            } else {
                fileName.textContent = 'Tidak Ada File yang Dipilih';
            }
        });
        
        document.getElementById('finishButton').addEventListener('click', function (e) {
            e.preventDefault();

            const buktiPembayaran = document.getElementById('bukti_pembayaran');
            const errorElement = document.getElementById('bukti_pembayaran_error');

            errorElement.textContent = '';
            errorElement.classList.add('hidden');

            if (!buktiPembayaran.files.length) {
                errorElement.textContent = 'Silahkan unggah bukti pembayaran terlebih dahulu.';
                errorElement.classList.remove('hidden');
                buktiPembayaran.classList.add('border-red-500');

                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Silahkan unggah bukti pembayaran terlebih dahulu.',
                    confirmButtonText: 'OK',
                });

                return;
            }

            const selectedBank = document.getElementById('bank').value;
            const paymentCode = document.getElementById('paymentCode').value;

            document.getElementById('bankInput').value = selectedBank;
            document.getElementById('paymentCodeInput').value = paymentCode;

            Swal.fire({
                icon: 'success',
                title: 'Pembayaran Berhasil',
                text: 'Silahkan Menunggu Konfirmasi dari kami. Dan lihat tiket Anda di halaman Beranda pada bagian Cek Tiket. Tiket juga telah dikirim ke email Anda.',
                confirmButtonText: 'Mengerti',
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.closest('form').submit();
                }
            });
        });

        updateInstructions('ATM');
    </script>
</body>
</html>