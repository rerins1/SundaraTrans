document.addEventListener('DOMContentLoaded', function() {
    // Ambil nilai jumlah penumpang dari localStorage yang disimpan di halaman sebelumnya
    const jumlahPenumpang = localStorage.getItem('jumlahPenumpang') || 1;
    
    // Fungsi untuk membuat input field penumpang
    function createPassengerInputs(count) {
        const passengerContainer = document.querySelector('.grid');
        
        // Hapus input field penumpang yang ada sebelumnya
        const existingPassengerInputs = document.querySelectorAll('[id^="passenger-input-"]');
        existingPassengerInputs.forEach(input => input.parentElement.remove());
        
        // Buat input field baru sesuai jumlah penumpang
        for (let i = 1; i <= count; i++) {
            const div = document.createElement('div');
            div.innerHTML = `
                <label class="block">Nama Penumpang ${i}</label>
                <input type="text" 
                    id="passenger-input-${i}"
                    name="nama_penumpang[]" 
                    class="w-full p-2 border rounded" 
                    placeholder="Masukkan Nama Penumpang ${i}" />
            `;
            
            // Masukkan sebelum checkbox
            const checkboxDiv = document.querySelector('.col-span-2');
            passengerContainer.insertBefore(div, checkboxDiv);
        }
    }
    
    // Buat input field penumpang saat halaman dimuat
    createPassengerInputs(parseInt(jumlahPenumpang));
    
    // Handle checkbox "Penumpang Adalah Pemesan"
    const checkbox = document.querySelector('input[type="checkbox"]');
    const namaPemesan = document.querySelector('input[placeholder="Masukkan Nama Pemesan"]');
    
    checkbox.addEventListener('change', function() {
        if (this.checked && namaPemesan.value) {
            const firstPassengerInput = document.querySelector('#passenger-input-1');
            if (firstPassengerInput) {
                firstPassengerInput.value = namaPemesan.value;
            }
        }
    });
    
    // Update passenger-input-1 whenever nama_pemesan changes
    namaPemesan.addEventListener('input', function() {
        if (checkbox.checked) {
            const firstPassengerInput = document.querySelector('#passenger-input-1');
            if (firstPassengerInput) {
                firstPassengerInput.value = this.value;
            }
        }
    });


    

});

// Ambil elemen input jumlah penumpang
const passengerInput = document.getElementById('passengerCount');

// Misalnya tombol "Lanjutkan" memanggil fungsi ini
document.getElementById('nextButton').addEventListener('click', savePassengerCount);
