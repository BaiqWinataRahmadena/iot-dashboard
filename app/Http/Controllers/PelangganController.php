<?php

namespace App\Http\Controllers;
use App\Models\Pelanggan; // <-- Ganti ke Pelanggan
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggans = Pelanggan::orderBy('nama')->get(['id', 'nama', 'alamat']);
        return view('customers.index', ['customers' => $pelanggans]); // View belum kita ubah
    }

    public function show(Pelanggan $pelanggan) // <-- Ganti ke Pelanggan
    {
        $pelanggan->load('pelaporan'); // <-- Ini sudah mengambil semua data pelanggan + data pelaporan
        return response()->json($pelanggan);
    }
}