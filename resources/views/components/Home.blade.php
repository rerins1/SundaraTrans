<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Sundara Trans</title>
    <!-- Tambahkan Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
</head>

<body>

    <x-navbar></x-navbar>

    {{-- Form Tiket --}}
    <div class="absolute inset-0 flex justify-center items-center z-40">
        <div class="bg-white bg-opacity-70 backdrop-blur-md rounded-lg p-8 shadow-lg w-full max-w-lg">
            <ul class="flex border-b-2 border-black mb-4" id="tabs">
                <li class="flex-1 text-center">
                    <button id="tab-booking" class="block w-full font-bold p-4 border-b-2 border-blue-500">
                        Booking Tiket
                    </button>
                </li>
                <li class="flex-1 text-center">
                    <button id="tab-cek" class="block w-full font-bold p-4 border-b-2 border-transparent">
                        Cek Tiket
                    </button>
                </li>
            </ul>

            <div class="relative">
                <div id="error" class="hidden bg-red-200 text-red-700 p-4 rounded mb-4">
                    Silakan pilih tanggal keberangkatan.
                </div>
            </div>
            
            <!-- Booking Form -->
            <div id="booking" class="tab-content p-4">
                <form class="space-y-4" id="form-booking" action="{{ route('search.bus.tickets') }}" method="POST">
                    @csrf
                    <div class="flex items-center">
                        <i class="fas fa-location-arrow mr-2 text-gray-500"></i>
                        <div class="w-full">
                            <label for="dari" class="block text-sm font-bold">DARI</label>
                            <select id="dari" name="dari" class="mt-1 w-full p-2 border rounded-md shadow-sm">
                                <optgroup label="PILIH ASAL KOTA">
                                    <option value="" selected>Silahkan Pilih Dari Kota</option>
                                    <option value="Bandung">Bandung</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Yogyakarta">Yogyakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                    <option value="Bali">Bali</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
    
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                        <div class="w-full">
                            <label for="tujuan" class="block text-sm font-bold">TUJUAN</label>
                            <select id="tujuan" name="tujuan" class="mt-1 w-full p-2 border rounded-md shadow-sm">
                                <optgroup label="PILIH TUJUAN KOTA">
                                    <option value="" selected>Silahkan Pilih Kota Tujuan</option>
                                    <option value="Bandung">Bandung</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Yogyakarta">Yogyakarta</option>
                                    <option value="Surabaya">Surabaya</option>
                                    <option value="Bali">Bali</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
    
                    <div class="flex items-center">
                        <i class="fas fa-calendar-day mr-2 text-gray-500"></i>
                        <div class="w-full">
                            <label for="tanggal" class="block text-sm font-bold">TANGGAL BERANGKAT</label>
                            <input type="date" id="tanggal" name="tanggal" class="mt-1 w-full p-2 border rounded-md shadow-sm">
                        </div>
                    </div>
    
                    <div class="flex items-center">
                        <i class="fas fa-users mr-2 text-gray-500"></i>
                        <div class="w-full">
                            <label for="jumlah_penumpang" class="block text-sm font-bold">JUMLAH PENUMPANG</label>
                            <select id="jumlah_penumpang" name="jumlah_penumpang" class="mt-1 w-full p-2 border rounded-md shadow-sm">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
    
                    <div class="text-center pt-6">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                            CARI TIKET
                        </button>
                    </div>
                </form>
            </div>
    
            <!-- Cek Ticket Form -->
            <div id="cek" class="tab-content p-4 hidden">
                <form class="space-y-4" action="{{ route('cek.tiket') }}" method="POST">
                    @csrf
                    <div>
                        <label for="noHp" class="block text-sm font-bold">NO. HP</label>
                        <input type="text" id="noHp" name="noHp" placeholder="No. Telepon" class="w-full p-2 border rounded-md shadow-sm" />
                    </div>
                    <div>
                        <label for="kodeBooking" class="block text-sm font-bold">KODE BOOKING</label>
                        <input type="text" id="kodeBooking" name="kodeBooking" placeholder="KODE BOOKING" class="w-full p-2 border rounded-md shadow-sm" style="text-transform: uppercase;" />
                    </div>
                    <div class="text-center pt-6">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                            CEK TIKET
                        </button>
                    </div>
                </form>
            
                <!-- Notifikasi Error -->
                @if(session('error'))
                    <div class="bg-red-200 text-red-800 border border-red-400 px-4 py-3 rounded relative mt-4">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- SLIDER --}}
    <div id="default-carousel" class="relative w-full h-screen" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="carousel relative overflow-hidden h-full">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('img/1.png') }}" class="absolute block w-full h-full object-cover" alt="...">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('img/2.png') }}" class="absolute block w-full h-full object-cover" alt="...">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="{{ asset('img/3.png') }}" class="absolute block w-full h-full object-cover" alt="...">
            </div>
        </div>
        
        <!-- Slider indicators -->
        <div class="hidden absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
            <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
        </div>
    
        <!-- Slider controls -->
        <button type="button" class="hidden absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button" class=" hidden absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>

    <x-footer></x-footer>


    <script src="{{ asset('js/script.js') }}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tanggalInput = document.getElementById('tanggal');
        const today = new Date().toISOString().split('T')[0];
        tanggalInput.setAttribute('min', today);
    });
    
    document.addEventListener('DOMContentLoaded', function () {
        const errorAlert = document.querySelector('.bg-red-200');
        if (errorAlert) {
            setTimeout(() => {
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.remove(), 500); // Hapus elemen setelah transisi
            }, 5000); // Notifikasi hilang setelah 5 detik
        }
    });
    </script>

</body>
</html>