document.addEventListener('DOMContentLoaded', function() {
    // Handle tab switching
    const tabBooking = document.getElementById('tab-booking');
    const tabCek = document.getElementById('tab-cek');
    if (tabBooking && tabCek) {
        tabBooking.addEventListener('click', () => switchTab('booking'));
        tabCek.addEventListener('click', () => switchTab('cek'));
    }

    function switchTab(tab) {
        const bookingTab = document.getElementById('booking');
        const cekTab = document.getElementById('cek');
        if (bookingTab && cekTab) {
            bookingTab.classList.toggle('hidden', tab !== 'booking');
            cekTab.classList.toggle('hidden', tab !== 'cek');
        }

        if (tabBooking && tabCek) {
            tabBooking.classList.toggle('border-blue-500', tab === 'booking');
            tabCek.classList.toggle('border-blue-500', tab === 'cek');
        }
    }

    // Handle search ticket form submission
    const form = document.getElementById('form-booking');
    const submitButton = form.querySelector('button[type="submit"]');  // Tombol Cari Tiket
    if (form) {
        form.addEventListener('submit', handleSearchTicket);
    }

    // Validate form and enable/disable submit button
    const formElements = ['dari', 'tujuan', 'tanggal', 'jumlah_penumpang'];
    formElements.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('change', validateForm);
        }
    });

    function validateForm() {
        const dari = document.getElementById('dari');
        const tujuan = document.getElementById('tujuan');
        const tanggal = document.getElementById('tanggal');
        const jumlah = document.getElementById('jumlah_penumpang');
        
        let isValid = true;

        // Validate 'Dari'
        if (dari.value === '') {
            dari.classList.add('border-red-500');
            isValid = false;
        } else {
            dari.classList.remove('border-red-500');
        }

        // Validate 'Tujuan'
        if (tujuan.value === '') {
            tujuan.classList.add('border-red-500');
            isValid = false;
        } else {
            tujuan.classList.remove('border-red-500');
        }

        // Validate 'Dari' and 'Tujuan' are not the same
        if (dari.value === tujuan.value && dari.value !== '') {
            dari.classList.add('border-red-500');
            tujuan.classList.add('border-red-500');
            isValid = false;
        } else {
            dari.classList.remove('border-red-500');
            tujuan.classList.remove('border-red-500');
        }

        // Validate 'Tanggal'
        if (tanggal.value === '') {
            tanggal.classList.add('border-red-500');
            isValid = false;
        } else {
            tanggal.classList.remove('border-red-500');
        }

        // Validate 'Jumlah Penumpang'
        if (jumlah.value === '') {
            jumlah.classList.add('border-red-500');
            isValid = false;
        } else {
            jumlah.classList.remove('border-red-500');
        }

        // Enable/disable submit button based on form validity
        if (isValid) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }

    function handleSearchTicket(event) {
        event.preventDefault();  // Prevent form submission

        // Do final validation before submitting
        validateForm();

        const submitButton = document.querySelector('button[type="submit"]');
        if (submitButton.disabled) {
            return;  // Stop submission if the button is disabled
        }

        // If all validations pass, allow form submission
        form.submit();
    }

    // Set minimum date for date input with additional validation
    const dateInput = document.getElementById('tanggal');
    if (dateInput) {
        const today = new Date();
        const formattedToday = today.toISOString().split('T')[0];
        dateInput.setAttribute('min', formattedToday);
        dateInput.value = formattedToday;

        // Prevent user from selecting a past date
        dateInput.addEventListener('change', function(e) {
            const selectedDate = new Date(this.value);
            selectedDate.setHours(0, 0, 0, 0);

            if (selectedDate < today) {
                alert('Tidak dapat memilih tanggal yang sudah lewat.');
                this.value = formattedToday;
            }
        });

        // Prevent typing in date input
        dateInput.addEventListener('keydown', function(e) {
            e.preventDefault();
        });
    }
});
