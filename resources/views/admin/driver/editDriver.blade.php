@extends('layouts.admin')

@section('title', 'Edit Sopir')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Edit Sopir</h2>

    <form action="{{ route('drivers.update', $driver->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-sm font-semibold text-gray-700">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name', $driver->name) }}" class="w-full p-2 border border-gray-300 rounded mt-1" required>
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-sm font-semibold text-gray-700">Telepon</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $driver->phone) }}" class="w-full p-2 border border-gray-300 rounded mt-1" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $driver->email) }}" class="w-full p-2 border border-gray-300 rounded mt-1" required>
        </div>
        <div class="mb-4">
            <label for="address" class="block text-sm font-semibold text-gray-700">Alamat</label>
            <textarea id="address" name="address" class="w-full p-2 border border-gray-300 rounded mt-1" required>{{ old('address', $driver->address) }}</textarea>
        </div>
        <div class="mb-4">
            <label for="photo" class="block text-sm font-semibold text-gray-700">Foto (Kosongkan jika tidak ingin mengganti)</label>
            <input type="file" id="photo" name="photo" class="w-full p-2 border border-gray-300 rounded mt-1">
            @if($driver->photo)
                <img src="{{ asset('storage/' . $driver->photo) }}" alt="{{ $driver->name }}" class="w-24 mt-2">
            @endif
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
