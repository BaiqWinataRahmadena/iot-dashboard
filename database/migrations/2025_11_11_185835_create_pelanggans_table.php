<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_pelanggans_table.php
public function up(): void
{
    Schema::create('pelanggans', function (Blueprint $table) {
        $table->id();
        $table->string('status')->default('Aktif');
        $table->string('no_ktp')->unique()->nullable();
        $table->string('nama');
        $table->text('alamat');
        $table->string('telepon')->nullable();
        $table->string('pekerjaan')->nullable();
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
