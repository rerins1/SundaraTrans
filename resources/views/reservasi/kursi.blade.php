@php
    // Ambil kursi yang terkunci dan terisi dari database
    $lockedSeats = \App\Models\LockedSeat::where('ticket_id', session('kode_tiket'))
        ->where('expired_at', '>', now())
        ->pluck('seat_number')
        ->toArray();

    $bookedSeats = \App\Models\Booking::where('ticket_id', session('kode_tiket'))
        ->pluck('kursi')
        ->flatten()
        ->toArray();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Pilih Kursi - Sundara Trans</title>
</head>
<body class="bg-gray-100">
    <x-navbar></x-navbar>

    <x-header>
        <h1 class="text-2xl md:text-3xl font-bold text-center">Pilih Kursi Penumpang</h1>
        <p class="text-center text-sm md:text-lg mt-2">Silahkan Pilih {{ session('jumlah_penumpang') }} Kursi Penumpang Senyaman-nya Anda</p>
    </x-header>

    <!-- Main Content -->
    <div class="container mx-auto mt-4 md:mt-10 p-3 md:p-6 bg-white rounded-lg shadow-lg mb-10">
        <h2 class="text-xl md:text-2xl font-bold text-center mb-3 md:mb-6">Pilih Kursi Anda</h2>

        <!-- Grid Container -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <!-- Seat Layout -->
            <div class="md:col-span-8 mx-auto">
                <form action="{{ route('store.seat') }}" method="POST" id="seatForm">
                    @csrf
                    <input type="hidden" name="selected_seats" id="selectedSeatsInput">
                    
                    <!-- Seat Layout -->
                    <div class="space-y-4">
                    <!-- Row 1 to 6 -->
                    @foreach (range(1, 24, 4) as $seatNumber)
                        <div class="flex justify-between">
                            <div class="flex space-x-2">
                                @include('partials.seat', [
                                    'seatNumber' => $seatNumber,
                                    'isLocked' => in_array($seatNumber, $lockedSeats),
                                    'isBooked' => in_array($seatNumber, $bookedSeats)
                                ])
                                @include('partials.seat', [
                                    'seatNumber' => $seatNumber + 1,
                                    'isLocked' => in_array($seatNumber + 1, $lockedSeats),
                                    'isBooked' => in_array($seatNumber + 1, $bookedSeats)
                                ])
                            </div>
                            <div class="flex space-x-2">
                                @include('partials.seat', [
                                    'seatNumber' => $seatNumber + 2,
                                    'isLocked' => in_array($seatNumber + 2, $lockedSeats),
                                    'isBooked' => in_array($seatNumber + 2, $bookedSeats)
                                ])
                                @include('partials.seat', [
                                    'seatNumber' => $seatNumber + 3,
                                    'isLocked' => in_array($seatNumber + 3, $lockedSeats),
                                    'isBooked' => in_array($seatNumber + 3, $bookedSeats)
                                ])
                            </div>
                        </div>
                    @endforeach

                    <!-- Row 7 (Seat 25-26) -->
                    <div class="flex justify-end space-x-2">
                        @include('partials.seat', [
                            'seatNumber' => 25,
                            'isLocked' => in_array(25, $lockedSeats),
                            'isBooked' => in_array(25, $bookedSeats)
                        ])
                        @include('partials.seat', [
                            'seatNumber' => 26,
                            'isLocked' => in_array(26, $lockedSeats),
                            'isBooked' => in_array(26, $bookedSeats)
                        ])
                    </div>

                    <!-- Back Row (Seat 27-31) -->
                    <div class="flex justify-center space-x-2">
                        @foreach (range(27, 31) as $seatNumber)
                            @include('partials.seat', [
                                'seatNumber' => $seatNumber,
                                'isLocked' => in_array($seatNumber, $lockedSeats),
                                'isBooked' => in_array($seatNumber, $bookedSeats)
                            ])
                        @endforeach
                    </div>
                </div>
                </form>
            </div>

            <!-- Seat Selection Info -->
            <div class="md:col-span-4 bg-gray-100 p-3 md:p-4 rounded-lg shadow-md mt-4 md:mt-0">
                <h3 class="text-base md:text-lg font-semibold mb-2 md:mb-4">Keterangan:</h3>
                <div class="space-y-2 mb-4 md:mb-6">
                    <div class="flex items-center">
                        <span class="w-4 h-4 md:w-6 md:h-6 border-2 border-gray-400 rounded mr-2"></span>
                        <span class="text-sm md:text-base">Kursi Kosong</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 md:w-6 md:h-6 bg-green-500 rounded mr-2"></span>
                        <span class="text-sm md:text-base">Kursi Dipilih</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-4 h-4 md:w-6 md:h-6 bg-red-500 rounded mr-2"></span>
                        <span class="text-sm md:text-base">Kursi Terkunci/Terisi</span>
                    </div>
                </div>

                <div class="mb-4 md:mb-6">
                    <h3 class="text-base md:text-lg font-semibold mb-2">Kursi yang Dipilih:</h3>
                    <ul id="selectedSeatsList" class="list-disc pl-5 text-sm md:text-base"></ul>
                </div>

                <div class="text-center">
                    <button type="submit"
                            form="seatForm"
                            class="w-full md:w-auto bg-red-500 text-white px-4 md:px-6 py-2 md:py-3 rounded-lg text-sm md:text-lg font-semibold transition-all duration-300 hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed"
                            id="submitButton"
                            disabled>
                        Konfirmasi Pilihan
                    </button>
                </div>
            </div>
        </div>

        <!-- Tombol SEBELUMNYA -->
        <div class="text-left mt-4">
            <button 
                id="sebelumnya-button"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg w-full md:w-auto"
                onclick="window.location.href='{{ route('tickets.biodata', ['kode' => session('kode_tiket')]) }}'">
                SEBELUMNYA
            </button>
        </div>
    </div>

    <x-footer></x-footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const maxSeats = {{ session('jumlah_penumpang', 1) }};
            const seatCheckboxes = document.querySelectorAll('.seat-checkbox');
            const selectedSeatsList = document.getElementById('selectedSeatsList');
            const submitButton = document.getElementById('submitButton');
            const selectedSeatsInput = document.getElementById('selectedSeatsInput');
            let selectedSeats = [];
    
            // Reset kursi yang sebelumnya dipilih saat halaman dimuat
            function resetSelectedSeats() {
                seatCheckboxes.forEach(checkbox => {
                    // Hapus status terpilih
                    checkbox.checked = false;
    
                    // Update UI label
                    const label = document.querySelector(`label[for="${checkbox.id}"]`);
                    if (label) {
                        label.classList.remove('bg-green-500', 'text-white'); // Hapus highlight
                        label.classList.add('hover:bg-green-100'); // Tambahkan efek hover
                    }
                });
    
                // Kosongkan daftar kursi di UI
                if (selectedSeatsList) selectedSeatsList.innerHTML = '';
    
                // Kosongkan hidden input
                if (selectedSeatsInput) selectedSeatsInput.value = '[]';
    
                // Disable tombol konfirmasi
                if (submitButton) submitButton.disabled = true;
            }
    
            // Update tampilan kursi berdasarkan pemilihan pengguna
            function updateSelectedSeats() {
                selectedSeatsList.innerHTML = ''; // Reset daftar kursi di UI
                selectedSeats = []; // Reset array kursi
    
                seatCheckboxes.forEach(checkbox => {
                    const label = document.querySelector(`label[for="${checkbox.id}"]`);
                    if (checkbox.checked) {
                        selectedSeats.push(checkbox.value);
    
                        // Tambahkan highlight ke kursi yang dipilih
                        if (label) {
                            label.classList.add('bg-green-500', 'text-white');
                            label.classList.remove('hover:bg-green-100');
                        }
    
                        // Tambahkan kursi ke daftar UI
                        const li = document.createElement('li');
                        li.textContent = `Kursi ${checkbox.value}`;
                        selectedSeatsList.appendChild(li);
                    } else {
                        // Hapus highlight jika kursi tidak dipilih
                        if (label) {
                            label.classList.remove('bg-green-500', 'text-white');
                            label.classList.add('hover:bg-green-100');
                        }
                    }
                });
    
                // Simpan kursi yang dipilih di input hidden
                selectedSeatsInput.value = JSON.stringify(selectedSeats);
    
                // Aktifkan tombol jika jumlah kursi sesuai
                submitButton.disabled = selectedSeats.length !== maxSeats;
            }
    
            // Event listener untuk checkbox kursi
            seatCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const checkedSeats = document.querySelectorAll('.seat-checkbox:checked').length;
    
                    if (checkedSeats > maxSeats) {
                        this.checked = false; // Batalkan pemilihan jika melebihi batas
                        alert(`Anda hanya dapat memilih ${maxSeats} kursi.`);
                    } else {
                        updateSelectedSeats(); // Update UI
                    }
                });
            });
    
            // Reset kursi saat halaman dimuat
            resetSelectedSeats();
        });
    </script>   
</body>
</html>
