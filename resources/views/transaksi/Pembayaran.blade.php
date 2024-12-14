<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Pembayaran</title>
</head>
<body class="bg-gray-50">

    <x-navbar></x-navbar>

    <x-header>Pembayaran Tiket 
        <p class="text-center text-lg mt-2">Silahkan pilih ingin menggunakan Transaksi mana untuk melakukan pembayaran</p>
    </x-header>

    <div class="justify-center p-6 min-h-screen">
        <!-- Popup Modal -->
        <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg">
                <h2 class="text-lg font-bold mb-4 text-center text-red-500">MOHON PERHATIANNYA!</h2>
                <ul class="list-disc list-inside text-sm text-gray-700 space-y-2">
                    <li>Pengajuan <strong>REFUND</strong> selambatnya H-3 sebelum keberangkatan.</li>
                    <li>Pengajuan <strong>RESCHEDULE</strong> selambatnya H-3 sebelum keberangkatan.</li>
                    <li><strong>REFUND</strong> hanya bisa diproses 50% dari harga tiket dan akan dibayarkan selambatnya 14 hari kerja.</li>
                    <li>Penumpang diharuskan datang ke agen yang dipilih sebagai titik naik selambatnya 30 menit sebelum jam keberangkatan, guna verifikasi dan cetak tiket.</li>
                    <li>Mohon untuk melakukan pembayaran dengan <strong>BANK</strong> yang sama.</li>
                    <li>Mohon untuk <strong>TIDAK</strong> menggunakan pembayaran transfer dengan <strong>BI-Fast</strong>, guna menghindari keterlambatan konfirmasi pembayaran Anda.</li>
                </ul>
                <button onclick="closeModal()" class="mt-4 bg-red-500 text-white px-4 py-2 rounded-lg w-full">OK</button>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-center max-w-screen-xl mx-auto">
            <!-- Kotak Kiri (Pembayaran) -->
            <div class="bg-white p-4 shadow-md rounded-lg w-full h-full xl:w-[55%] md:w-[65%] mb-4 md:mb-0">
                <h1 class="text-2xl font-bold mb-2 text-center mt-8">Pilih Metode Pembayaran</h1>

                <!-- Virtual Account -->
                <h2 class="text-lg font-semibold mb-2">Virtual Account</h2>
                <div class="grid grid-cols-3 sm:grid-cols-3 gap-4 mb-6">
                    <div class="flex justify-center items-center">
                        <input type="radio" name="paymentMethod" id="paymentMethod-Bank" value="Bank" class="form-radio text-red-500 h-4 w-4 mr-2" />
                        <label for="paymentMethod-Bank" class="cursor-pointer">
                            <img src="{{ asset('img/Bank/virtual-account.png') }}" alt="Bank" class="w-72 h-20 object-contain" />
                        </label>
                    </div>
                    <!-- Tambahkan logo bank lainnya di sini -->
                </div>

                <!-- Minimarket -->
                <h2 class="text-lg font-semibold mb-2 mt-16">Minimarket</h2>
                <div class="grid grid-cols-3 sm:grid-cols-3 gap-4 mb-6">
                    <div class="flex justify-center items-center">
                        <input type="radio" name="paymentMethod" id="paymentMethod-Minimarket" value="Minimarket" class="form-radio text-red-500 h-4 w-4 mr-2" />
                        <label for="paymentMethod-Minimarket" class="cursor-pointer">
                            <img src="{{ asset('img/Minimarket/Gerai.png') }}" alt="Minimarket" class="w-72 h-20 object-contain" />
                        </label>
                    </div>
                    <!-- Tambahkan logo minimarket lainnya di sini -->
                </div>

                <!-- E-Wallet -->
                <h2 class="text-lg font-semibold mb-2 mt-16">E-Wallet</h2>
                <div class="grid grid-cols-3 sm:grid-cols-3 gap-4">
                    <div class="flex justify-center items-center">
                        <input type="radio" name="paymentMethod" id="paymentMethod-EWallet" value="EWallet" class="form-radio text-red-500 h-4 w-4 mr-2" />
                        <label for="paymentMethod-EWallet" class="cursor-pointer">
                            <img src="{{ asset('img/EWallet/E-Wallet.png') }}" alt="EWallet" class="w-72 h-20 object-contain" />
                        </label>
                    </div>
                    <!-- Tambahkan logo e-wallet lainnya di sini -->
                </div>

                <!-- Harga & Pembayaran -->
                <div class="mt-8">
                    <h2 class="text-xl font-bold mb-4">Detail Reservasi</h2>
                    <div class="space-y-4 text-gray-700">
                        <div class="flex justify-between border-b-2 pb-2">
                            <span>Nama Pemesan:</span>
                            <span class="font-semibold">{{ $nama_pemesan }}</span>
                        </div>
                        <div class="flex justify-between border-b-2 pb-2">
                            <span>Alamat:</span>
                            <span class="font-semibold">{{ $alamat }}</span>
                        </div>
                        <div class="flex justify-between border-b-2 pb-2">
                            <span>No Handphone:</span>
                            <span class="font-semibold">{{ $no_handphone }}</span>
                        </div>
                        <div class="flex justify-between border-b-2 pb-2">
                            <span>Jumlah Tiket:</span>
                            <span class="font-semibold">{{ $jumlah_penumpang }}</span>
                        </div>
                        <div class="flex justify-between border-b-2 pb-2">
                            <span>Tanggal Keberangkatan:</span>
                            <span class="font-semibold">{{ \Carbon\Carbon::parse($ticket->tanggal)->format('d M Y') }} {{ $ticket->waktu }}</span>
                        </div>
                        <div class="flex justify-between border-b-2 pb-2">
                            <span>Metode Pembayaran:</span>
                            <span class="font-semibold" id="selectedPaymentMethod"></span>
                        </div>
                        <div class="flex justify-between border-b-2 pb-2">
                            <span>Total Pembayaran:</span>
                            <span class="font-semibold">Rp {{ number_format($total_pembayaran, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between w-full max-w-screen-lg mt-8">
                        <a href="{{ route('reselect.seats') }}" 
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            SEBELUMNYA
                        </a>
                        <button onclick="handleNextClick()" class="px-4 py-2 rounded-lg bg-red-500 text-white">
                            SELANJUTNYA
                        </button>
                    </div>
                </div>
            </div>

            <!-- Kotak Kanan (Informasi Keberangkatan) -->
            <div class="bg-white p-4 shadow-md rounded-lg w-full h-full xl:w-[35%] md:w-[35%] md:ml-6">
                <h3 class="text-black font-bold text-lg mb-4">Tujuan Keberangkatan</h3>
                <div class="space-y-3">
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold">Kelas Bus</span>
                        <span class='text-sm'>{{ $ticket->kelas }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold">Kode Bus</span>
                        <span class='text-sm'>{{ $ticket->kode }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold">Berangkat</span>
                        <span class='text-sm'>{{ $ticket->dari }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold">Tujuan</span>
                        <span class='text-sm'>{{ $ticket->tujuan }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold">Tanggal Keberangkatan</span>
                        <span class='text-sm'>{{ \Carbon\Carbon::parse($ticket->tanggal)->format('d M Y') }} {{ $ticket->waktu }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold">Jumlah Penumpang</span>
                        <span class='text-sm'>{{ $jumlah_penumpang }}</span>
                    </div>
                    <div class="space-y-2">
                        <span class="font-semibold">Nama Penumpang</span>
                        @if(is_array($nama_penumpang) && count($nama_penumpang) > 0)
                            @foreach($nama_penumpang as $index => $nama)
                                <div class="flex items-center bg-gray-50 p-3 rounded-lg">
                                    <div class="flex items-center flex-1">
                                        <span class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center text-sm text-blue-600 mr-3">
                                            {{ $index + 1 }}
                                        </span>
                                        <span>{{ $nama }}</span>
                                    </div>
                                    <span class="text-sm text-gray-500">
                                        Kursi: {{ $selected_seats[$index] ?? '-' }}
                                    </span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-3 text-gray-500">
                                Tidak ada data penumpang
                            </div>
                        @endif
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="font-semibold">Pembayaran</span>
                        <span class='text-sm'>Rp {{ number_format($total_pembayaran, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer></x-footer>

    <script>
        // Menampilkan Modal
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }

        // Menutup Modal
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        // function navigateToSelectSeat() {
        //     // Tambahkan logika untuk navigasi ke halaman Biodata Form
        //     window.location.href = '/booking/seat'; // Ganti dengan URL yang sesuai
        // }

        function handleNextClick() {
            const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked');
            if (selectedMethod) {
                document.getElementById('selectedPaymentMethod').innerText = selectedMethod.value;

                // Menentukan URL tujuan berdasarkan metode pembayaran yang dipilih
                let nextUrl = '';
                if (selectedMethod.value === 'EWallet') {
                    nextUrl = '/booking/payment/method/e-wallet'; // URL yang sesuai untuk E-Wallet
                } else if (selectedMethod.value === 'Minimarket') {
                    nextUrl = '/booking/payment/method/minimarket'; // URL yang sesuai untuk Minimarket
                } else if (selectedMethod.value === 'Bank') {
                    nextUrl = '/booking/payment/method/virtual-account'; // URL yang sesuai untuk Virtual Account
                }

                // Navigasi ke halaman yang sesuai
                window.location.href = nextUrl;
            } else {
                alert('Silakan pilih metode pembayaran terlebih dahulu!');
            }
        }


    </script>
</body>
</html>
