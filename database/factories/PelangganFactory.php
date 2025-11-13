<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelanggan>
 */
class PelangganFactory extends Factory
{
    /**
     * Definisikan status default model.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Error Anda (baris 11) kemungkinan ada di 'status'
        // Pastikan Anda menggunakan $this->faker
        return [
            'status' => $this->faker->randomElement(['Aktif', 'Non-Aktif']),
            'no_ktp' => $this->faker->unique()->numerify('################'),
            'nama' => $this->faker->name(),
            'alamat' => $this->faker->address(),
            'telepon' => $this->faker->phoneNumber(),
            'pekerjaan' => $this->faker->jobTitle(),
            'keterangan' => $this->faker->sentence(),
        ];
    }
}