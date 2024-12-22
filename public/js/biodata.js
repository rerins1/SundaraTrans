document.addEventListener('DOMContentLoaded', function() {
    // Get passenger count from session/local storage
    const jumlahPenumpang = parseInt(document.querySelector('[name="jumlah_penumpang"]')?.value) || 
                           parseInt(sessionStorage.getItem('jumlahPenumpang')) || 
                           1;

    // Main container for passenger inputs
    const mainContainer = document.querySelector('.grid');
    
    // Create a dedicated container for passenger inputs if it doesn't exist
    let passengerContainer = document.getElementById('passenger-inputs-container');
    if (!passengerContainer) {
        passengerContainer = document.createElement('div');
        passengerContainer.id = 'passenger-inputs-container';
        passengerContainer.className = 'col-span-2';
        mainContainer.appendChild(passengerContainer);
    }

    // Function to create passenger input fields
    function createPassengerInputs(count) {
        // Clear existing passenger inputs
        passengerContainer.innerHTML = '';
        
        // Create input fields for each passenger
        for (let i = 1; i <= count; i++) {
            const div = document.createElement('div');
            div.className = 'mb-4';
            div.innerHTML = `
                <label class="block mb-2 text-sm font-medium text-gray-900">
                    Nama Penumpang ${i}
                </label>
                <input type="text" 
                    id="passenger-input-${i}"
                    name="nama_penumpang[]" 
                    class="w-full p-2 border rounded" 
                    required
                    placeholder="Masukkan Nama Penumpang ${i}"
                />
            `;
            passengerContainer.appendChild(div);
        }
    }

    // Initialize passenger input fields
    createPassengerInputs(jumlahPenumpang);

    // Handle "Penumpang Adalah Pemesan" checkbox
    const checkbox = document.querySelector('input[type="checkbox"]');
    const namaPemesan = document.querySelector('input[name="nama_pemesan"]');

    if (checkbox && namaPemesan) {
        checkbox.addEventListener('change', function() {
            const firstPassengerInput = document.querySelector('#passenger-input-1');
            if (this.checked && namaPemesan.value && firstPassengerInput) {
                firstPassengerInput.value = namaPemesan.value;
                firstPassengerInput.disabled = true;
            } else if (firstPassengerInput) {
                firstPassengerInput.disabled = false;
            }
        });

        // Update first passenger input when nama_pemesan changes
        namaPemesan.addEventListener('input', function() {
            const firstPassengerInput = document.querySelector('#passenger-input-1');
            if (checkbox.checked && firstPassengerInput) {
                firstPassengerInput.value = this.value;
            }
        });
    }

    // Form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const passengerInputs = document.querySelectorAll('[name="nama_penumpang[]"]');
            let isValid = true;

            // Validate all required fields
            passengerInputs.forEach((input, index) => {
                if (!input.value.trim()) {
                    isValid = false;
                    alert(`Nama Penumpang ${index + 1} harus diisi`);
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    // Store passenger count in session storage
    sessionStorage.setItem('jumlahPenumpang', jumlahPenumpang.toString());
});