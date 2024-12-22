@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Booking</h1>

<!-- Menampilkan pesan sukses jika ada -->
@if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded mb-6">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')

    <!-- Nama Pemesan -->
    <div>
        <label for="nama_pemesan" class="block text-sm font-semibold">Nama Pemesan:</label>
        <input type="text" name="nama_pemesan" id="nama_pemesan" value="{{ old('nama_pemesan', $booking->nama_pemesan) }}" 
            class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
            required>
        @error('nama_pemesan')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-semibold">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email', $booking->email) }}" 
            class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
            required>
        @error('email')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- No Handphone -->
    <div>
        <label for="no_handphone" class="block text-sm font-semibold">No Handphone:</label>
        <input type="text" name="no_handphone" id="no_handphone" value="{{ old('no_handphone', $booking->no_handphone) }}" 
            class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
            required>
        @error('no_handphone')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Alamat -->
    <div>
        <label for="alamat" class="block text-sm font-semibold">Alamat:</label>
        <textarea name="alamat" id="alamat" 
            class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
            required>{{ old('alamat', $booking->alamat) }}</textarea>
        @error('alamat')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Status -->
    <div>
        <label for="status" class="block text-sm font-semibold">Status:</label>
        <select name="status" id="status" 
            class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="menunggu" {{ old('status', $booking->status) === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
            <option value="lunas" {{ old('status', $booking->status) === 'lunas' ? 'selected' : '' }}>Lunas</option>
            <option value="dibatalkan" {{ old('status', $booking->status) === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        @error('status')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Submit Button -->
    <button type="submit" 
        class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        Update
    </button>
</form>
@endsection
