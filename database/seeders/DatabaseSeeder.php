<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str; // <-- Tambahkan ini

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin (Metode AMAN: Tidak memanggil Factory)
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Kunci pencarian
            [ // Data untuk dibuat jika tidak ada
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Data Dummy (Karena 'if' di-komen, ini akan berjalan di Render)

        // BUAT 10 KARYAWAN DUMMY SECARA MANUAL (MENGHINDARI UserFactory.php)
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => 'Karyawan ' . ($i + 1),
                'email' => 'karyawan' . ($i + 1) . '@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);
        }

        // Buat 30 Pelanggan dummy (Ini sudah benar dan tidak error)
        Pelanggan::factory(30)
                ->hasPelaporan(5)
                ->create();
    }
}