@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Tambah Jadwal Tiket</h1>

<!-- Menampilkan pesan sukses jika ada -->
@if(session('success'))
    <div class="bg-green-500 text-white p-4 rounded mb-6">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.tickets.store') }}" method="POST" class="space-y-6">
    @csrf

    <!-- Kelas -->
    <div>
        <label for="kelas" class="block text-sm font-semibold">Kelas:</label>
        <input type="text" name="kelas" id="kelas" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
        @error('kelas')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Kode -->
    <div>
        <label for="kode" class="block text-sm font-semibold">Kode:</label>
        <input type="text" name="kode" id="kode" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
        @error('kode')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Tanggal -->
    <div>
        <label for="tanggal" class="block text-sm font-semibold">Tanggal:</label>
        <input type="date" name="tanggal" id="tanggal" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
        @error('tanggal')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Waktu -->
    <div>
        <label for="waktu" class="block text-sm font-semibold">Waktu:</label>
        <input type="time" name="waktu" id="waktu" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
        @error('waktu')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Dari -->
    <div>
        <label for="dari" class="block text-sm font-semibold">Dari:</label>
        <input type="text" name="dari" id="dari" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
        @error('dari')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Tujuan -->
    <div>
        <label for="tujuan" class="block text-sm font-semibold">Tujuan:</label>
        <input type="text" name="tujuan" id="tujuan" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
        @error('tujuan')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Kursi -->
    <div>
        <label for="kursi" class="block text-sm font-semibold">Kursi:</label>
        <input type="number" name="kursi" id="kursi" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
        @error('kursi')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Harga -->
    <div>
        <label for="harga" class="block text-sm font-semibold">Harga:</label>
        <input type="number" step="0.01" name="harga" id="harga" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500" required>
        @error('harga')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Submit Button -->
    <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">Tambah</button>
</form>
@endsection