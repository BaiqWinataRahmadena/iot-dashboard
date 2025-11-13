<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class PelangganFactory extends Factory
{
    public function definition(): array
    {
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