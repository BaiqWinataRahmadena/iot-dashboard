<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pelanggan; // <-- GANTI DARI CUSTOMER
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
        ]);

        // 2. Buat 10 User Karyawan
        User::factory(10)->create();

        // 3. Buat 30 Pelanggan, masing-masing 5 data pelaporan
        Pelanggan::factory(30)
                 ->hasPelaporan(5) // <-- Panggil relasi 'pelaporan'
                 ->create();
    }
}