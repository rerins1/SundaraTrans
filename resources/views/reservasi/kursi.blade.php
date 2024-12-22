@php
    // Pastikan variabel ticket tersedia dan gunakan ID tiket yang spesifik
    $ticket = $ticket ?? null;
    
    // Ambil kursi terkunci dari LockedSeat model berdasarkan ticket_id spesifik
    $lockedSeats = \App\Models\LockedSeat::where('ticket_id', $ticket?->id)
        ->where('expires_at', '>', now())
        ->pluck('seat_number')
        ->toArray();

    // Ambil kursi yang sudah dipesan berdasarkan ticket_id spesifik
    $bookedSeats = \App\Models\Booking::where('ticket_id', $ticket?->id)
        ->get()
        ->flatMap(function ($booking) {
            return json_decode($booking->kursi, true);
        })
        ->toArray();

    // Gabungkan kursi terkunci dan kursi dipesan
    $unavailableSeats = array_unique(array_merge($lockedSeats, $bookedSeats));
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
        <p class="text-center text-sm md:text-lg mt-2">
            Silahkan Pilih {{ session('jumlah_penumpang') }} Kursi Penumpang Senyaman-nya Anda
        </p>
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
                    @foreach (range(1, 24, 4) as $rowStart)
                        <div class="flex justify-between">
                            <div class="flex space-x-2">
                                @include('partials.seat', [
                                    'seatNumber' => $rowStart,
                                    'isLocked' => in_array($rowStart, $unavailableSeats),
                                    'isBooked' => in_array($rowStart, $unavailableSeats)
                                ])
                                @include('partials.seat', [
                                    'seatNumber' => $rowStart + 1,
                                    'isLocked' => in_array($rowStart + 1, $unavailableSeats),
                                    'isBooked' => in_array($rowStart + 1, $unavailableSeats)
                                ])
                            </div>
                            <div class="flex space-x-2">
                                @include('partials.seat', [
                                    'seatNumber' => $rowStart + 2,
                                    'isLocked' => in_array($rowStart + 2, $unavailableSeats),
                                    'isBooked' => in_array($rowStart + 2, $unavailableSeats)
                                ])
                                @include('partials.seat', [
                                    'seatNumber' => $rowStart + 3,
                                    'isLocked' => in_array($rowStart + 3, $unavailableSeats),
                                    'isBooked' => in_array($rowStart + 3, $unavailableSeats)
                                ])
                            </div>
                        </div>
                    @endforeach

                    <!-- Row 7 (Seat 25-26) -->
                    <div class="flex justify-end space-x-2">
                        @include('partials.seat', [
                            'seatNumber' => 25,
                            'isLocked' => in_array(25, $unavailableSeats),
                            'isBooked' => in_array(25, $unavailableSeats)
                        ])
                        @include('partials.seat', [
                            'seatNumber' => 26,
                            'isLocked' => in_array(26, $unavailableSeats),
                            'isBooked' => in_array(26, $unavailableSeats)
                        ])
                    </div>

                    <!-- Back Row (Seat 27-31) -->
                    <div class="flex justify-center space-x-2">
                        @foreach (range(27, 31) as $seatNumber)
                            @include('partials.seat', [
                                'seatNumber' => $seatNumber,
                                'isLocked' => in_array($seatNumber, $unavailableSeats),
                                'isBooked' => in_array($seatNumber, $unavailableSeats)
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
                            class="w-full md:w-auto bg-red-500 text-white px-4 md:px-6 py-2 md:py-3 rounded-lg text-sm md:text-lg font-semibold transition-all duration-300 hover:bg-red-600 disabled:cursor-not-allowed"
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
            const seatForm = document.getElementById('seatForm');
            
            // Ambil kursi yang sebelumnya dipilih dari server
            const preselectedSeats = JSON.parse('{!! json_encode($selectedSeats ?? []) !!}');
            const unavailableSeats = JSON.parse('{!! json_encode($unavailableSeats ?? []) !!}');
            let selectedSeats = [...preselectedSeats];

            // Flash message handling
            @if(session('error'))
                alert('{{ session('error') }}');
            @endif

            function updateSelectedSeats() {
                // Reset daftar kursi yang dipilih
                selectedSeatsList.innerHTML = '';
                selectedSeats = [];

                seatCheckboxes.forEach(checkbox => {
                    const label = document.querySelector(`label[for="seat-${checkbox.value}"]`);

                    if (checkbox.checked) {
                        selectedSeats.push(checkbox.value);
                        
                        // Tambahkan kursi ke daftar yang dipilih
                        const li = document.createElement('li');
                        li.textContent = `Kursi ${checkbox.value}`;
                        selectedSeatsList.appendChild(li);

                        // Ubah style label
                        label.classList.add('bg-green-500', 'text-white');
                        label.classList.remove('hover:bg-green-100');
                    } else {
                        // Kembalikan style label
                        label.classList.remove('bg-green-500', 'text-white');
                        label.classList.add('hover:bg-green-100');
                    }
                });

                // Update input tersembunyi dengan daftar kursi
                selectedSeatsInput.value = JSON.stringify(selectedSeats);
                
                // Aktifkan/non-aktifkan tombol submit
                submitButton.disabled = selectedSeats.length !== maxSeats;
            }

            // Tampilkan kursi yang sebelumnya dipilih
            preselectedSeats.forEach(seat => {
                const checkbox = document.querySelector(`#seat-${seat}`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
            updateSelectedSeats();

            // Event Listener untuk pemilihan kursi
            seatCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    // Cek apakah kursi sudah dipesan/dikunci
                    if (unavailableSeats.includes(parseInt(this.value))) {
                        this.checked = false;
                        alert(`Kursi ${this.value} sudah tidak tersedia.`);
                        return;
                    }

                    const checkedSeats = document.querySelectorAll('.seat-checkbox:checked:not(:disabled)').length;

                    // Validasi jumlah kursi
                    if (checkedSeats > maxSeats) {
                        this.checked = false;
                        alert(`Anda hanya dapat memilih ${maxSeats} kursi.`);
                    } else {
                        updateSelectedSeats();
                    }
                });
            });

            // Konfirmasi sebelum submit
            seatForm.addEventListener('submit', function (e) {
                // Validasi ulang sebelum submit
                if (selectedSeats.length !== maxSeats) {
                    e.preventDefault();
                    alert(`Silakan pilih ${maxSeats} kursi.`);
                    return;
                }

                // Konfirmasi pemilihan kursi
                const confirmSelection = confirm(`Apakah Anda Yakin Memilih Kursi Nomor: ${selectedSeats.join(', ')}\nLanjutkan?`);
                
                if (!confirmSelection) {
                    e.preventDefault();
                } else {
                    // Nonaktifkan tombol submit untuk mencegah multi-submit
                    submitButton.disabled = true;
                    submitButton.innerHTML = 'Memproses...';
                }
            });

            // Tambahkan event listener untuk tombol sebelumnya
            const sebelumnyaButton = document.getElementById('sebelumnya-button');
            if (sebelumnyaButton) {
                sebelumnyaButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Konfirmasi kembali ke halaman sebelumnya
                    const confirmBack = confirm('Anda akan kembali ke halaman sebelumnya. Pilihan kursi Anda akan dibatalkan. Lanjutkan?');
                    
                    if (confirmBack) {
                        window.location.href = '{{ route('tickets.biodata', ['kode' => session('kode_tiket')]) }}';
                    }
                });
            }
        });
    </script>   
</body>
</html>
