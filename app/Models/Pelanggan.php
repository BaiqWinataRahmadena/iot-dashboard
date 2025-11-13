<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Definisikan relasi ke tabel pelaporan
    public function pelaporan()
    {
        return $this->hasMany(PelaporanHasilBaca::class);
    }
}