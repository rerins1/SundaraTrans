<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Rendy Riansyah',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('admin111'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Rezaldi Saputra',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('admin222'),
            'role' => 'admin',
        ]);
    }
}