<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Pilih Kursi - Sundara Trans</title>
    <style>
        .seat {
            width: 50px; /* Lebar kotak kursi */
            height: 50px; /* Tinggi kotak kursi */
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid #ccc; /* Garis tepi kotak */
            border-radius: 8px; /* Sudut membulat */
            cursor: pointer; /* Ubah kursor saat hover */
        }
        .seat:hover {
            background-color: #34d399; /* Warna hijau saat hover */
        }
    </style>
</head>
<body class="bg-gray-100">

    <x-navbar></x-navbar>

    <x-header>Pilih Kursi Penumpang
        <p class="text-center text-lg mt-2">Silahkan Pilih Kursi Penumpang Senyaman-nya Anda</p>
    </x-header>

    <!-- Main Content -->
    <div class="container mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg mb-10">
        <h2 class="text-2xl font-bold text-center mb-6">Pilih Kursi Anda</h2>
        <h2 class="text-2xl font-bold text-center mb-6">KURSI DENGAN ISI 31</h2>

        <!-- Input Jumlah Penumpang -->
        <div class="mb-4">
            <label for="passengerCount" class="block text-lg font-semibold mb-2">Jumlah Penumpang:</label>
            <input type="number" id="passengerCount" min="1" max="31" class="border rounded p-2" placeholder="Masukkan jumlah penumpang" oninput="updateMaxSeats()">
        </div>

        <div class="grid grid-cols-12 gap-4">
            <!-- Seat Layout -->
            <div class="col-span-8">
                <div class="grid grid-cols-8 gap-4 justify-center items-center">

                    <!-- Left Seats -->
                    <div class="col-span-3 ml-auto">
                        <div class="grid grid-rows-6 gap-4">
                            <div class="flex space-x-4">
                                <div class="seat" data-seat="1" onclick="toggleSeat(1)">1</div>
                                <div class="seat" data-seat="2" onclick="toggleSeat(2)">2</div>
                            </div>
                            <div class="flex space-x-4">
                                <div class="seat" data-seat="5" onclick="toggleSeat(5)">5</div>
                                <div class="seat" data-seat="6" onclick="toggleSeat(6)">6</div>
                            </div>
                            <div class="flex space-x-4">
                                <div class="seat" data-seat="9" onclick="toggleSeat(9)">9</div>
                                <div class="seat" data-seat="10" onclick="toggleSeat(10)">10</div>
                            </div>
                            <div class="flex space-x-4">
                                <div class="seat" data-seat="13" onclick="toggleSeat(13)">13</div>
                                <div class="seat" data-seat="14" onclick="toggleSeat(14)">14</div>
                            </div>
                            <div class="flex space-x-4">
                                <div class="seat" data-seat="17" onclick="toggleSeat(17)">17</div>
                                <div class="seat" data-seat="18" onclick="toggleSeat(18)">18</div>
                            </div>
                            <div class="flex space-x-4">
                                <div class="seat" data-seat="21" onclick="toggleSeat(21)">21</div>
                                <div class="seat" data-seat="22" onclick="toggleSeat(22)">22</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Seats -->
                    <div class="col-span-3 ml-auto">
                        <div class="grid grid-rows-7 gap-4">
                            <div class="flex space-x-4">
                                <div class="seat" data-seat="3" onclick="toggleSeat(3)">3</div>
                                <div class="seat" data-seat="4" onclick="toggleSeat(4)">4</div>
                            </div>
                            <div class="flex space-x-4">
                                <div class="seat" data-seat="7" onclick="toggleSeat(7)">7</div>
                                <div class="seat" data-seat="8" onclick="toggleSeat(8)">8</div>
                            </div>
                            <div class="flex space-x-4">
                                <div class="seat" data-seat="11" onclick="toggleSeat(11)">11</div>
                                <div class="seat" data-seat="12" onclick="toggleSeat(12)">12</div>
                            </div>
                            <div class="flex space-x-4">
                                <div class="seat" data-seat="15" onclick="toggleSeat(15)">15</div>
                                <div class="seat" data-seat="16" onclick="toggleSeat(16)">16</div>
                            </div>
                            <div class="flex space-x-4">
                                <div class="seat" data-seat="19" onclick="toggleSeat(19)">19</div>
                                <div class="seat" data-seat="20" onclick="toggleSeat(20)">20</div>
                            </div>
                            <div class="flex space-x-4">
                                <div class="seat" data-seat="23" onclick="toggleSeat(23)">23</div>
                                <div class="seat" data-seat="24" onclick="toggleSeat(24)">24</div>
                            </div>
                            <div class="flex space-x-4">
                                <div class="seat" data-seat="25" onclick="toggleSeat(25)">25</div>
                                <div class="seat" data-seat="26" onclick="toggleSeat(26)">26</div>
                            </div>
                        </div>
                    </div>

                    <!-- Back Seats -->
                    <div class="col-span-8 flex justify-center space-x-4 mt-4">
                        <div class="seat" data-seat="27" onclick="toggleSeat(27)">27</div>
                        <div class="seat" data-seat="28" onclick="toggleSeat(28)">28</div>
                        <div class="seat" data-seat="29" onclick="toggleSeat(29)">29</div>
                        <div class="seat" data-seat="30" onclick="toggleSeat(30)">30</div>
                        <div class="seat" data-seat="31" onclick="toggleSeat(31)">31</div>
                    </div>
                </div>
            </div>

            <!-- Seat Selection Info -->
            <div class="col-span-4 bg-gray-100 p-2 rounded-lg shadow-md">

                <h3 class="text-lg font-semibold mb-2">Keterangan:</h3>
                <!-- Keterangan warna kursi -->
                <div class="mb-4">
                    <p class="text-sm text-gray-600 flex items-center">
                        <span class="w-4 h-4 bg-red-500 mr-2 rounded"></span> <span class="font-bold">Sudah Terisi</span>
                    </p>
                    <p class="text-sm text-gray-600 flex items-center">
                        <span class="w-4 h-4 bg-green-500 mr-2 rounded"></span> <span class="font-bold">Kursi Yang Anda Pilih</span>
                    </p>
                    <p class="text-sm text-gray-600 flex items-center">
                        <span class="w-4 h-4 bg-white border-2 border-gray-400 mr-2 rounded"></span> <span class="font-bold">Kursi Kosong</span>
                    </p>
                </div>


                <h3 class="text-lg font-semibold mb-4">Kursi yang Dipilih:</h3>
                <ul id="selectedSeats" class="list-disc pl-5">
                    <!-- Daftar kursi yang dipilih akan muncul di sini -->
                </ul>
                <div class="container mx-auto text-center mt-4">
                    <button 
                        class="bg-red-500 text-white px-6 py-3 rounded-lg text-lg font-semibold"
                        onclick="handleNextClick()"
                        >
                        Konfirmasi Pilihan
                    </button>
                </div>
            </div>

            <!-- Tombol Navigasi -->
            <div class="md:flex md:justify-between mt-6 flex-col md:flex-row space-x-10 md:space-y-0">
                <button 
                    onclick="navigateToPilihTiket()"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg w-full md:w-auto"
                >
                    SEBELUMNYA
                </button>
            </div>
        </div>
    </div>

    <x-footer></x-footer>

    <!-- JavaScript -->
    <script>
        const bookedSeats = [5, 7, 23]; // Kursi yang sudah dipesan
        const selectedSeats = [];

        // Tandai kursi yang sudah dipesan
        window.onload = () => {
            bookedSeats.forEach(seat => {
                const seatElement = document.querySelector(`.seat[data-seat="${seat}"]`);
                if (seatElement) {
                    seatElement.classList.add('bg-red-500');
                    seatElement.style.pointerEvents = 'none'; // Nonaktifkan klik pada kursi yang sudah dipesan
                }
            });
        };

        function toggleSeat(seatNumber) {
            const seatElement = document.querySelector(`.seat[data-seat="${seatNumber}"]`);
            const passengerCount = parseInt(document.getElementById('passengerCount').value) || 0;

            if (selectedSeats.includes(seatNumber)) {
                selectedSeats.splice(selectedSeats.indexOf(seatNumber), 1);
                seatElement.classList.remove('bg-green-500');
            } else {
                // Batasi pemilihan kursi berdasarkan jumlah penumpang
                if (selectedSeats.length < passengerCount && selectedSeats.length < 31) {
                    selectedSeats.push(seatNumber);
                    seatElement.classList.add('bg-green-500');
                }
            }
            updateSelectedSeats();
        }

        function updateSelectedSeats() {
            const selectedSeatsList = document.getElementById('selectedSeats');
            selectedSeatsList.innerHTML = '';
            selectedSeats.forEach(seat => {
                const li = document.createElement('li');
                li.textContent = `Kursi ${seat}`;
                selectedSeatsList.appendChild(li);
            });
        }

        function updateMaxSeats() {
            // Ubah logika di sini jika diperlukan
            const passengerCount = parseInt(document.getElementById('passengerCount').value) || 0;
            // Sesuaikan batasan jika perlu
            console.log(`Jumlah penumpang yang dimasukkan: ${passengerCount}`);
        }

        function navigateToPilihTiket() {
            // Tambahkan logika untuk navigasi ke halaman Biodata Form
            window.location.href = '/isi-biodata'; // Ganti dengan URL yang sesuai
        }

        function handleNextClick() {
            // Tambahkan logika untuk navigasi ke halaman Biodata Form
            window.location.href = '/Pembayaran'; // Ganti dengan URL yang sesuai
        }
    </script>
</body>
</html>
