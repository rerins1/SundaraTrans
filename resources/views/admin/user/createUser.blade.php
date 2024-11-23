@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-6">Tambah User</h2>
    <form action="{{ route('user.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nama</label>
            <input type="text" name="name" id="name" class="w-full p-2 border rounded-lg" value="{{ old('name') }}" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" name="email" id="email" class="w-full p-2 border rounded-lg" value="{{ old('email') }}" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
            <input type="password" name="password" id="password" class="w-full p-2 border rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 border rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-gray-700 font-bold mb-2">Telepon</label>
            <input type="text" name="phone" id="phone" class="w-full p-2 border rounded-lg" value="{{ old('phone') }}" required>
        </div>
        <div class="mb-4">
            <label for="role" class="block text-gray-700 font-bold mb-2">Role</label>
            <select name="role" id="role" class="w-full p-2 border rounded-lg" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
    </form>
</div>
@endsection