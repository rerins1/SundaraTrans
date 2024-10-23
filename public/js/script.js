// console.log('Script loaded');
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
    if (form) {
        form.addEventListener('submit', handleSearchTicket);
    }

    function handleSearchTicket(event) {
        // console.log('Form submitted');
        event.preventDefault();  // Prevent form submission

        const dari = document.getElementById('dari');
        const tujuan = document.getElementById('tujuan');
        const tanggal = document.getElementById('tanggal');
        const jumlah = document.getElementById('jumlah_penumpang');
        const errorElement = document.getElementById('error');

        if (!dari || !tujuan || !tanggal || !jumlah || !errorElement) {
            console.error('One or more form elements not found');
            return;
        }

        // Reset error message
        errorElement.textContent = '';
        errorElement.classList.add('hidden');

        let isValid = true;
        let errorMessages = [];

        // Validate 'Dari'
        if (dari.value === '') {
            isValid = false;
            errorMessages.push('Silakan pilih kota asal.');
            dari.classList.add('border-red-500');
        } else {
            dari.classList.remove('border-red-500');
        }

        // Validate 'Tujuan'
        if (tujuan.value === '') {
            isValid = false;
            errorMessages.push('Silakan pilih kota tujuan.');
            tujuan.classList.add('border-red-500');
        } else {
            tujuan.classList.remove('border-red-500');
        }

        // Validate 'Dari' and 'Tujuan' are not the same
        if (dari.value === tujuan.value && dari.value !== '') {
            isValid = false;
            errorMessages.push('Kota asal dan tujuan tidak boleh sama.');
            dari.classList.add('border-red-500');
            tujuan.classList.add('border-red-500');
        }

        // Validate 'Tanggal'
        if (tanggal.value === '') {
            isValid = false;
            errorMessages.push('Silakan pilih tanggal keberangkatan.');
            tanggal.classList.add('border-red-500');
        } else {
            tanggal.classList.remove('border-red-500');
        }

        // Validate 'Jumlah Penumpang'
        if (jumlah.value === '') {
            isValid = false;
            errorMessages.push('Silakan pilih jumlah penumpang.');
            jumlah.classList.add('border-red-500');
        } else {
            jumlah.classList.remove('border-red-500');
        }

        if (!isValid) {
            errorElement.textContent = errorMessages.join(' ');
            errorElement.classList.remove('hidden');
            return;  // Stop form submission if validation fails
        }

        // If all validations pass, allow form submission
        form.submit();
    }

    // Set minimum date for date input
    const dateInput = document.getElementById('tanggal');
    if (dateInput) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);
    }
});
