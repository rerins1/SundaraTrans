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

    <x-header>Pilih Kursi Penumpang
        <p class="text-center text-lg mt-2">Silahkan Pilih {{ session('jumlah_penumpang') }} Kursi Penumpang Senyaman-nya Anda</p>
    </x-header>

    <!-- Main Content -->
    <div class="container mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg mb-10">
        <h2 class="text-2xl font-bold text-center mb-6">Pilih Kursi Anda</h2>
        <h2 class="text-2xl font-bold text-center mb-6">KURSI DENGAN ISI 31</h2>

        <div class="grid grid-cols-12 gap-4">
            <!-- Seat Layout -->
            <div class="col-span-8">
                <form action="{{ route('store.seat') }}" method="POST" id="seatForm">
                    @csrf
                    <input type="hidden" name="selected_seats" id="selectedSeatsInput">
                    <div class="grid grid-cols-8 gap-4 justify-center items-center">
                        <!-- Left Seats -->
                        <div class="col-span-3 ml-auto">
                            <div class="grid grid-rows-6 gap-4">
                                @foreach([1,2,5,6,9,10,13,14,17,18,21,22] as $index => $seatNumber)
                                    @if($index % 2 == 0)
                                        <div class="flex space-x-4">
                                    @endif
                                    <div class="seat-wrapper">
                                        <input type="checkbox" 
                                            name="nomor_kursi[]" 
                                            value="{{ $seatNumber }}" 
                                            id="seat-{{ $seatNumber }}"
                                            class="hidden seat-checkbox">
                                        <label for="seat-{{ $seatNumber }}" 
                                            class="seat block w-12 h-12 border-2 border-gray-400 rounded-lg flex items-center justify-center cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                                            {{ $seatNumber }}
                                        </label>
                                    </div>
                                    @if($index % 2 == 1)
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Right Seats -->
                        <div class="col-span-3 ml-auto">
                            <div class="grid grid-rows-7 gap-4">
                                @foreach([3,4,7,8,11,12,15,16,19,20,23,24,25,26] as $index => $seatNumber)
                                    @if($index % 2 == 0)
                                        <div class="flex space-x-4">
                                    @endif
                                    <div class="seat-wrapper">
                                        <input type="checkbox" 
                                            name="nomor_kursi[]" 
                                            value="{{ $seatNumber }}" 
                                            id="seat-{{ $seatNumber }}"
                                            class="hidden seat-checkbox">
                                        <label for="seat-{{ $seatNumber }}" 
                                            class="seat block w-12 h-12 border-2 border-gray-400 rounded-lg flex items-center justify-center cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                                            {{ $seatNumber }}
                                        </label>
                                    </div>
                                    @if($index % 2 == 1)
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Back Seats -->
                        <div class="col-span-8 flex justify-center space-x-4 mt-4">
                            @foreach(range(27, 31) as $seatNumber)
                                <div class="seat-wrapper">
                                    <input type="checkbox" 
                                        name="nomor_kursi[]" 
                                        value="{{ $seatNumber }}" 
                                        id="seat-{{ $seatNumber }}"
                                        class="hidden seat-checkbox">
                                    <label for="seat-{{ $seatNumber }}" 
                                        class="seat block w-12 h-12 border-2 border-gray-400 rounded-lg flex items-center justify-center cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                                        {{ $seatNumber }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>

            <!-- Seat Selection Info -->
            <div class="col-span-4 bg-gray-100 p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4">Keterangan:</h3>
                <div class="space-y-2 mb-6">
                    <div class="flex items-center">
                        <span class="w-6 h-6 border-2 border-gray-400 rounded mr-2"></span>
                        <span>Kursi Kosong</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-6 h-6 bg-green-500 rounded mr-2"></span>
                        <span>Kursi Dipilih</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-6 h-6 bg-red-500 rounded mr-2"></span>
                        <span>Kursi Terisi</span>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">Kursi yang Dipilih:</h3>
                    <ul id="selectedSeatsList" class="list-disc pl-5">
                        <!-- Daftar kursi yang dipilih akan ditampilkan di sini -->
                    </ul>
                </div>

                <div class="text-center">
                    <button type="submit"
                            form="seatForm"
                            class="bg-red-500 text-white px-6 py-3 rounded-lg text-lg font-semibold transition-all duration-300 hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed"
                            id="submitButton"
                            disabled>
                        Konfirmasi Pilihan
                    </button>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="mt-8 flex justify-between">
            <a href="{{ route('search.bus.tickets') }}"
                class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200">
                SEBELUMNYA
            </a>
        </div>
    </div>

    <x-footer></x-footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const maxSeats = {{ session('jumlah_penumpang', 1) }};
            const seatCheckboxes = document.querySelectorAll('.seat-checkbox');
            const selectedSeatsList = document.getElementById('selectedSeatsList');
            const submitButton = document.getElementById('submitButton');
            const selectedSeatsInput = document.getElementById('selectedSeatsInput');
            let selectedSeats = [];

            function updateSelectedSeats() {
                selectedSeatsList.innerHTML = '';
                selectedSeats = [];
                
                seatCheckboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        selectedSeats.push(checkbox.value);
                        const li = document.createElement('li');
                        li.textContent = `Kursi ${checkbox.value}`;
                        selectedSeatsList.appendChild(li);
                    }
                });

                selectedSeatsInput.value = JSON.stringify(selectedSeats);
                submitButton.disabled = selectedSeats.length !== maxSeats;
            }

            seatCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const checkedSeats = document.querySelectorAll('.seat-checkbox:checked').length;
                    
                    if (checkedSeats > maxSeats) {
                        this.checked = false;
                        alert(`Anda hanya dapat memilih ${maxSeats} kursi`);
                    } else {
                        const label = this.nextElementSibling;
                        label.classList.toggle('bg-green-500', this.checked);
                        label.classList.toggle('text-white', this.checked);
                    }
                    
                    updateSelectedSeats();
                });
            });
        });
    </script>

    <style>
        .seat-wrapper .seat {
            transition: all 0.2s ease-in-out;
        }
        
        .seat-checkbox:checked + .seat {
            background-color: #22c55e;
            border-color: #22c55e;
            color: white;
        }

        .seat-wrapper .seat:hover {
            transform: scale(1.05);
        }

        .seat-checkbox:disabled + .seat {
            background-color: #ef4444;
            border-color: #ef4444;
            color: white;
            cursor: not-allowed;
        }
    </style>
</body>
</html>