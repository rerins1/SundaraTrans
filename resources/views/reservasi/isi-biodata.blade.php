<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <title>Biodata Form - Sundara Trans</title>
</head>
<body>
    <x-navbar></x-navbar>

    <x-header>Isi Informasi Penumpang
        <p class="text-center text-lg mt-2">Tolong isi informasi penumpang untuk mendapatkan E-Ticket</p>
    </x-header>

    <div class="min-h-screen justify-center items-center py-32">
        <div class="w-full max-w-full px-6 py-4">
            <form action="{{ route('store.biodata') }}" method="POST" id="biodataForm">
                @csrf
                <div class="md:flex md:space-x-6 space-y-6 md:space-y-0">
                    <!-- Informasi Penumpang -->
                    <div class="bg-white p-6 rounded w-full shadow-xl md:flex-1">
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Informasi Pemesan -->
                            <div>
                                <label class="block">Nama Pemesan</label>
                                <input name="nama_pemesan" type="text" class="w-full p-2 border rounded" required placeholder="Masukkan Nama Pemesan" />
                                @error('nama_pemesan')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block">Email</label>
                                <input name="email" type="email" class="w-full p-2 border rounded" required placeholder="Masukkan Email" />
                                <small class="text-green-600">Email diperlukan untuk mengirim e-tiket, kode bayar & OTP</small>
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block">No Handphone</label>
                                <input name="no_handphone" type="text" class="w-full p-2 border rounded" required placeholder="Masukkan No Telepon" />
                                @error('no_handphone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block">Alamat</label>
                                <input name="alamat" type="text" class="w-full p-2 border rounded" required placeholder="Masukkan Alamat" />
                                @error('alamat')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Container untuk input fields penumpang -->
                            <div id="passenger-inputs-container" class="col-span-2 grid grid-cols-2 gap-4">
                                <!-- Input fields penumpang akan ditambahkan secara dinamis di sini -->
                            </div>

                            <div class="col-span-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" id="sameAsBuyer" class="form-checkbox">
                                    <span class="ml-2">Penumpang Adalah Pemesan</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Keberangkatan -->
                    <div class="bg-white p-4 rounded shadow-lg w-full md:w-[450px]">
                        <h3 class="text-black font-bold text-lg mb-4">Tujuan Keberangkatan</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between border-b">
                                <span class="font-semibold">Kelas Bus</span>
                                <span>{{ $ticket->kelas }}</span>
                            </div>
                            <div class="flex justify-between border-b">
                                <span class="font-semibold">Kode Bus</span>
                                <span>{{ $ticket->kode }}</span>
                            </div>
                            <div class="flex justify-between border-b">
                                <span class="font-semibold">Berangkat</span>
                                <span>{{ $ticket->dari }}</span>
                            </div>
                            <div class="flex justify-between border-b">
                                <span class="font-semibold">Tujuan</span>
                                <span>{{ $ticket->tujuan }}</span>
                            </div>
                            <div class="flex justify-between border-b">
                                <span class="font-semibold">Tanggal Keberangkatan</span>
                                <span>{{ \Carbon\Carbon::parse($ticket->tanggal)->format('d M Y') }} {{ $ticket->waktu }}</span>
                            </div>
                            <div class="flex justify-between border-b">
                                <span class="font-semibold">Jumlah Penumpang</span>
                                <span>{{ $jumlah_penumpang }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">Total Pembayaran</span>
                                <span>Rp {{ number_format($total_pembayaran, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <!-- Hidden input untuk menyimpan jumlah penumpang -->
                        <input type="hidden" name="jumlah_penumpang" id="jumlahPenumpang" value="{{ $jumlah_penumpang }}">
                    </div>
                </div>

                <!-- Tombol Navigasi -->
                <div class="flex flex-wrap md:justify-between justify-center gap-4 mt-6">
                    <a href="javascript:void(0);" id="sebelumnya-button" class="bg-blue-500 text-white px-4 py-2 rounded-lg w-40 text-center">
                        SEBELUMNYA
                    </a>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg w-40">
                        SELANJUTNYA
                    </button>
                </div>
            </form>
        </div>
    </div>

    <x-footer></x-footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil jumlah penumpang dari input hidden
            const jumlahPenumpang = parseInt(document.getElementById('jumlahPenumpang').value) || 1;
            console.log('Jumlah Penumpang:', jumlahPenumpang); // Debug log
            
            const passengerContainer = document.getElementById('passenger-inputs-container');
            const checkbox = document.getElementById('sameAsBuyer');
            const namaPemesanInput = document.querySelector('input[name="nama_pemesan"]');
            
            // Fungsi untuk membuat input fields penumpang
            function createPassengerInputs(count) {
                console.log('Creating inputs for', count, 'passengers'); // Debug log
                passengerContainer.innerHTML = ''; // Bersihkan container
                
                // Buat input untuk setiap penumpang
                for (let i = 1; i <= count; i++) {
                    const div = document.createElement('div');
                    div.className = 'mb-4';
                    div.innerHTML = `
                        <label class="block mb-2">Nama Penumpang ${i}</label>
                        <input type="text" 
                               name="nama_penumpang[]" 
                               id="passenger-input-${i}"
                               class="w-full p-2 border rounded" 
                               required
                               placeholder="Masukkan Nama Penumpang ${i}" />
                        <span class="text-red-500 text-sm hidden" id="error-passenger-${i}"></span>
                    `;
                    passengerContainer.appendChild(div);
                }
            }

            // Inisialisasi input fields penumpang
            createPassengerInputs(jumlahPenumpang);

            // Handler untuk checkbox "Penumpang Adalah Pemesan"
            checkbox.addEventListener('change', function() {
                const firstPassengerInput = document.getElementById('passenger-input-1');
                if (this.checked && namaPemesanInput.value) {
                    firstPassengerInput.value = namaPemesanInput.value;
                    firstPassengerInput.readOnly = true;
                } else {
                    firstPassengerInput.readOnly = false;
                    if (!this.checked) {
                        firstPassengerInput.value = '';
                    }
                }
            });

            // Update nama penumpang pertama saat nama pemesan berubah
            namaPemesanInput.addEventListener('input', function() {
                if (checkbox.checked) {
                    const firstPassengerInput = document.getElementById('passenger-input-1');
                    if (firstPassengerInput) {
                        firstPassengerInput.value = this.value;
                    }
                }
            });

            // Form validation
            document.getElementById('biodataForm').addEventListener('submit', function(e) {
                let isValid = true;
                const passengerInputs = document.querySelectorAll('[name="nama_penumpang[]"]');
                
                // Reset previous error messages
                document.querySelectorAll('.text-red-500').forEach(el => el.classList.add('hidden'));
                
                // Validate each passenger input
                passengerInputs.forEach((input, index) => {
                    const errorSpan = document.getElementById(`error-passenger-${index + 1}`);
                    if (!input.value.trim()) {
                        isValid = false;
                        errorSpan.textContent = `Nama Penumpang ${index + 1} harus diisi`;
                        errorSpan.classList.remove('hidden');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Handler untuk tombol "SEBELUMNYA"
            document.getElementById('sebelumnya-button').addEventListener('click', function() {
                window.history.back();
            });

            // Debug log untuk memastikan script berjalan
            console.log('Biodata form script loaded successfully');
        });
    </script>
</body>
</html>