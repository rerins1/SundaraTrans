@php
    $isDisabled = $isLocked || $isBooked;
    $seatClass = $isDisabled 
        ? 'bg-red-500 text-white cursor-not-allowed' 
        : 'cursor-pointer hover:bg-green-100';
    $tooltip = $isBooked 
        ? 'Kursi sudah dipesan' 
        : ($isLocked ? 'Kursi sedang dipesan oleh pengguna lain' 
        : 'Klik untuk memilih kursi');
@endphp

<div class="seat-wrapper">
    <input type="checkbox"
        name="nomor_kursi[]"
        value="{{ $seatNumber }}"
        id="seat-{{ $seatNumber }}"
        class="hidden seat-checkbox"
        @if($isDisabled) disabled @endif>
    <label for="seat-{{ $seatNumber }}"
        class="seat block w-8 h-8 md:w-12 md:h-12 border-2 rounded-lg flex items-center justify-center transition-colors duration-200 text-xs md:text-base {{ $seatClass }}"
        data-seat="{{ $seatNumber }}"
        title="{{ $tooltip }}"
        aria-label="Kursi {{ $seatNumber }} {{ $isDisabled ? 'tidak tersedia' : 'tersedia' }}">
        {{ $seatNumber }}
    </label>
</div>