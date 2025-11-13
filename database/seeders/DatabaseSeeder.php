<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat User Admin (Metode AMAN: Tidak memanggil Factory)
        // Ini akan mencari email, jika tidak ada, baru dibuat.
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Kunci pencarian
            [ // Data untuk dibuat jika tidak ada
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(), // Opsional: langsung verifikasi
            ]
        );

        // 2. Data Dummy (HANYA JIKA ENVIRONMENT 'local')
        // Blok ini akan DILEWATI di Render (karena APP_ENV=production)
        // Jadi, UserFactory yang rusak itu tidak akan pernah dipanggil.
        //if (App::environment('local')) {

            // Buat 10 User Karyawan dummy
            User::factory(10)->create();

            // Buat 30 Pelanggan dummy, masing-masing 5 data pelaporan
            Pelanggan::factory(30)
                    ->hasPelaporan(5)
                    ->create();
        //}
    }
}