document.addEventListener('DOMContentLoaded', function() {
    // Ambil jumlah penumpang dari localStorage
    const jumlahPenumpang = parseInt(localStorage.getItem('jumlahPenumpang')) || 1;
    
    // State untuk menyimpan kursi yang dipilih
    let selectedSeats = [];
    const confirmButton = document.getElementById('confirmButton');
    
    // Fungsi untuk toggle kursi
    window.toggleSeat = function(seatNumber) {
        const seat = document.querySelector(`[data-seat="${seatNumber}"]`);
        
        if (!seat) return;
        
        // Jika kursi sudah terisi (booked), jangan lakukan apa-apa
        if (seat.classList.contains('booked')) {
            return;
        }
        
        // Jika kursi sudah dipilih
        if (selectedSeats.includes(seatNumber)) {
            // Hapus dari array selectedSeats
            selectedSeats = selectedSeats.filter(num => num !== seatNumber);
            seat.classList.remove('selected');
        } 
        // Jika kursi belum dipilih dan belum mencapai batas
        else if (selectedSeats.length < jumlahPenumpang) {
            selectedSeats.push(seatNumber);
            seat.classList.add('selected');
        } else {
            alert(`Anda hanya bisa memilih ${jumlahPenumpang} kursi`);
            return;
        }
        
        // Update tampilan kursi yang dipilih
        updateSelectedSeatsDisplay();
        
        // Enable/disable tombol konfirmasi
        confirmButton.disabled = selectedSeats.length !== jumlahPenumpang;
        if (!confirmButton.disabled) {
            confirmButton.classList.remove('opacity-50', 'cursor-not-allowed');
            confirmButton.classList.add('hover:bg-red-600');
        } else {
            confirmButton.classList.add('opacity-50', 'cursor-not-allowed');
            confirmButton.classList.remove('hover:bg-red-600');
        }
    };
    
    // Fungsi untuk update tampilan kursi yang dipilih
    function updateSelectedSeatsDisplay() {
        const selectedSeatsContainer = document.getElementById('selectedSeats');
        selectedSeatsContainer.innerHTML = '';
        
        selectedSeats.sort((a, b) => a - b).forEach(seatNumber => {
            const li = document.createElement('li');
            li.textContent = `Kursi nomor ${seatNumber}`;
            selectedSeatsContainer.appendChild(li);
        });
    }
    
    // Fungsi untuk handle tombol konfirmasi
    window.handleNextClick = function() {
        if (selectedSeats.length === jumlahPenumpang) {
            // Simpan kursi yang dipilih ke localStorage
            localStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
            
            // Redirect ke halaman berikutnya
            window.location.href = '/Pembayaran';
        } else {
            alert(`Silakan pilih ${jumlahPenumpang} kursi terlebih dahulu`);
        }
    };

    // Tampilkan jumlah kursi yang harus dipilih
    const instructionText = document.querySelector('.text-lg.mt-2');
    if (instructionText) {
        instructionText.textContent = `Silakan Pilih ${jumlahPenumpang} Kursi Penumpang`;
    }

    // Set initial state tombol konfirmasi
    if (confirmButton) {
        confirmButton.disabled = true;
        confirmButton.classList.add('opacity-50', 'cursor-not-allowed');
    }

    // Ambil data dari localStorage
    const dataBiodata = JSON.parse(localStorage.getItem('dataBiodata'));
    
    // Array untuk menyimpan kursi yang dipilih
    let kursiDipilih = [];
    
    // Fungsi untuk menginisialisasi pemilihan kursi
    function inisialisasiPemilihanKursi() {
        const kursiKursi = document.querySelectorAll('.kursi'); // Sesuaikan dengan class yang Anda gunakan
        kursiKursi.forEach(kursi => {
            kursi.addEventListener('click', function() {
                // Cek apakah masih bisa memilih kursi atau kursi sudah dipilih sebelumnya
                if (kursiDipilih.length < jumlahPenumpang || this.classList.contains('dipilih')) {
                    this.classList.toggle('dipilih');
                    
                    if (this.classList.contains('dipilih')) {
                        kursiDipilih.push(this.dataset.nomorKursi);
                    } else {
                        kursiDipilih = kursiDipilih.filter(nomor => nomor !== this.dataset.nomorKursi);
                    }
                    
                    // Update tampilan jumlah kursi yang dipilih
                    document.querySelector('#jumlah-kursi-dipilih').textContent = 
                        `Kursi dipilih: ${kursiDipilih.length} dari ${jumlahPenumpang}`;
                } else {
                    alert(`Anda hanya dapat memilih ${jumlahPenumpang} kursi`);
                }
            });
        });
    }

    // Panggil fungsi inisialisasi
    inisialisasiPemilihanKursi();

    // Tangani tombol konfirmasi
    const tombolKonfirmasi = document.querySelector('#tombol-konfirmasi'); // Sesuaikan dengan ID yang Anda gunakan
    tombolKonfirmasi.addEventListener('click', function() {
        if (kursiDipilih.length === jumlahPenumpang) {
            // Simpan data kursi ke localStorage
            localStorage.setItem('kursiDipilih', JSON.stringify(kursiDipilih));
            
            // Pindah ke halaman pembayaran
            window.location.href = '/Pembayaran';
        } else {
            alert(`Silakan pilih ${jumlahPenumpang} kursi terlebih dahulu`);
        }
    });

});