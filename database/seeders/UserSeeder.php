<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Menambahkan User tanpa khawatir bentrok email
        User::firstOrCreate(
            ['email' => 'hajihalll@gmail.com'], // Cek berdasarkan email
            [
                'name'     => 'Haji Hall',
                'password' => Hash::make('12345678'),
                'role_id'  => 1, // Sesuaikan ID Role Admin
            ]
        );

        User::firstOrCreate(
            ['email' => 'kasir@example.com'],
            [
                'name'     => 'Kasir POS',
                'password' => Hash::make('password'),
                'role_id'  => 2, // Sesuaikan ID Role Kasir
            ]
        );
    }
}