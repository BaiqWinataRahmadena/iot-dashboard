<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pelanggan;
use App\Models\PelaporanHasilBaca; // <-- Tambahkan ini, PENTING
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

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
        // (Kita asumsikan 'if' di-komen seperti file Anda sebelumnya)
        // if (App::environment('local')) {

            // BUAT 10 KARYAWAN DUMMY SECARA MANUAL
            // (Menggunakan firstOrCreate agar aman jika dijalankan lagi)
            for ($i = 0; $i < 10; $i++) {
                User::firstOrCreate(
                    ['email' => 'karyawan' . ($i + 1) . '@example.com'],
                    [
                        'name' => 'Karyawan ' . ($i + 1),
                        'email_verified_at' => now(),
                        'password' => Hash::make('password'),
                        'remember_token' => Str::random(10),
                    ]
                );
            }

            // BUAT 30 PELANGGAN & 150 LAPORAN SECARA MANUAL (BYPASS FACTORY)
            for ($p = 0; $p < 30; $p++) {
                
                // Buat 1 Pelanggan
                // Gunakan firstOrCreate untuk pelanggan juga agar aman
                $pelanggan = Pelanggan::firstOrCreate(
                    ['no_ktp' => '12345678901234' . str_pad($p, 2, '0', STR_PAD_LEFT)], // KTP Unik
                    [
                        'status' => ($p % 5 == 0) ? 'Non-Aktif' : 'Aktif',
                        'nama' => 'Pelanggan Dummy ' . ($p + 1),
                        'alamat' => 'Alamat Dummy No. ' . ($p + 1),
                        'telepon' => '081234567' . str_pad($p, 2, '0', STR_PAD_LEFT),
                        'pekerjaan' => 'Pekerjaan ' . ($p + 1),
                        'keterangan' => 'Keterangan untuk pelanggan ' . ($p + 1),
                        // Kita tidak perlu lat/long di sini karena ada di pelaporan
                    ]
                );

                // Buat 5 Laporan untuk pelanggan ini HANYA JIKA pelanggan baru dibuat
                // Ini mencegah duplikasi data jika seeder berjalan lagi
                if ($pelanggan->wasRecentlyCreated) {
                    for ($r = 0; $r < 5; $r++) {
                        PelaporanHasilBaca::create([
                            'pelanggan_id' => $pelanggan->id,
                            'vol_awal_1' => rand(1000, 2000) / 10.0, // Angka acak 100.0 - 200.0
                            'vol_akhir_1' => rand(2010, 3000) / 10.0, // Angka acak 201.0 - 300.0
                            'vol_tester_1' => rand(1000, 1010) / 10.0, // Angka acak 100.0 - 101.0
                            'rata_rata_error' => (rand(-500, 500) / 100.0), // Angka acak -5.00 s/d 5.00
                            'lokasi_pengukuran' => 'Lokasi Ukur ' . $r,
                            'petugas' => 'Petugas ' . $r,
                            'tanggal_baca' => now()->subDays(rand(1, 30)), // Tanggal acak
                            'latitude' => -6.11 + (rand(0, 200) / 1000.0), // Area Jakarta
                            'longitude' => 106.6 + (rand(0, 300) / 1000.0), // Area Jakarta
                        ]);
                    }
                }
            }
        // }
    }
}