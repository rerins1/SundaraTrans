@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Tambah Bus</h2>

    <form action="{{ route('dataBus.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="kode_bus" class="block text-sm font-medium text-gray-700">Kode Bus</label>
            <input type="text" name="kode_bus" id="kode_bus" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label for="no_polisi" class="block text-sm font-medium text-gray-700">Nomor Polisi</label>
            <input type="text" name="no_polisi" id="no_polisi" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label for="kapasitas" class="block text-sm font-medium text-gray-700">Kapasitas</label>
            <input type="number" name="kapasitas" id="kapasitas" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded" required>
                <option value="Tersedia">Tersedia</option>
                <option value="Tidak Tersedia">Tidak Tersedia</option>
            </select>
        </div>
        <div class="mb-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection