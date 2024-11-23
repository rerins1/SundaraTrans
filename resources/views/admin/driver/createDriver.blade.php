@extends('layouts.admin')

@section('title', 'Tambah Sopir')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Tambah Sopir</h2>

    <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold text-gray-700">Nama</label>
            <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded mt-1" required>
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-sm font-semibold text-gray-700">Telepon</label>
            <input type="text" id="phone" name="phone" class="w-full p-2 border border-gray-300 rounded mt-1" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded mt-1" required>
        </div>
        <div class="mb-4">
            <label for="address" class="block text-sm font-semibold text-gray-700">Alamat</label>
            <textarea id="address" name="address" class="w-full p-2 border border-gray-300 rounded mt-1" required></textarea>
        </div>
        <div class="mb-4">
            <label for="photo" class="block text-sm font-semibold text-gray-700">Foto</label>
            <input type="file" id="photo" name="photo" class="w-full p-2 border border-gray-300 rounded mt-1">
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection
