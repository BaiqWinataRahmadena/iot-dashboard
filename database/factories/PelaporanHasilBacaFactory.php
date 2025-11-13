<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PelaporanHasilBaca>
 */
class PelaporanHasilBacaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pastikan Anda menggunakan $this->faker
        return [
            'pelanggan_id' => Pelanggan::factory(),
            'vol_awal_1' => $this->faker->randomFloat(3, 100, 200),
            'vol_akhir_1' => $this->faker->randomFloat(3, 201, 300),
            'vol_tester_1' => $this->faker->randomFloat(3, 100, 101),
            // (Anda bisa tambahkan untuk vol 2 dan 3 jika mau)
            'rata_rata_error' => $this->faker->randomFloat(4, -5, 5),
            'lokasi_pengukuran' => $this->faker->streetAddress(),
            'petugas' => $this->faker->name(),
            'tanggal_baca' => $this->faker->date(),
            'latitude' => $this->faker->latitude(-6.11, -6.30),
            'longitude' => $this->faker->longitude(106.6, 106.9),
        ];
    }
}