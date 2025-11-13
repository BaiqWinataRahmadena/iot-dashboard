<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_pelaporan_hasil_bacas_table.php
public function up(): void
{
    Schema::create('pelaporan_hasil_bacas', function (Blueprint $table) {
        $table->id(); // Ini adalah "id_pelaporan" Anda
        $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade'); // Ini "id_pelanggan"

        // Pengujian 1
        $table->decimal('vol_awal_1', 10, 3)->nullable();
        $table->decimal('vol_akhir_1', 10, 3)->nullable();
        $table->decimal('vol_tester_1', 10, 3)->nullable();

        // Pengujian 2
        $table->decimal('vol_awal_2', 10, 3)->nullable();
        $table->decimal('vol_akhir_2', 10, 3)->nullable();
        $table->decimal('vol_tester_2', 10, 3)->nullable();

        // Pengujian 3
        $table->decimal('vol_awal_3', 10, 3)->nullable();
        $table->decimal('vol_akhir_3', 10, 3)->nullable();
        $table->decimal('vol_tester_3', 10, 3)->nullable();

        // Hasil (Selisih dan Error dihitung, kita simpan rata-ratanya)
        $table->decimal('rata_rata_error', 8, 4)->nullable();

        $table->string('lokasi_pengukuran')->nullable();
        $table->string('petugas')->nullable();
        $table->date('tanggal_baca');
        $table->decimal('latitude', 10, 7)->nullable();
        $table->decimal('longitude', 10, 7)->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaporan_hasil_bacas');
    }
};
