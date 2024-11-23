@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-6">Edit User</h2>
    <form action="{{ route('user.update', $user->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nama</label>
            <input type="text" name="name" id="name" class="w-full p-2 border rounded-lg" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" name="email" id="email" class="w-full p-2 border rounded-lg" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-gray-700 font-bold mb-2">Telepon</label>
            <input type="text" name="phone" id="phone" class="w-full p-2 border rounded-lg" value="{{ old('phone', $user->phone) }}" required>
        </div>
        <div class="mb-4">
            <label for="role" class="block text-gray-700 font-bold mb-2">Role</label>
            <select name="role" id="role" class="w-full p-2 border rounded-lg" required>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
