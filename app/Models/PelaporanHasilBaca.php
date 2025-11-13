<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelaporanHasilBaca extends Model
{
    use HasFactory;

    // Definisikan relasi ke tabel pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}