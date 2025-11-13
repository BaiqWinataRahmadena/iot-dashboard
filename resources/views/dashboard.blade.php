@extends('layouts.main')

@section('header', 'Dashboard IoT System')

@section('content')

<style>
    /* CSS tambahan untuk dashboard */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr; /* Kolom 2:1 */
        gap: 2rem;
    }
    .chart-card {
        background-color: var(--sidebar-bg-light);
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
    }
    .chart-card h4 {
        margin-top: 0;
        margin-bottom: 1rem;
        font-weight: 600;
        border-bottom: 1px solid var(--border-light);
        padding-bottom: 0.5rem;
    }
    /* Pastikan canvas memiliki tinggi agar grafik terlihat */
    #volumeChart, #statusChart {
        height: 350px;
    }
</style>

<div class="dashboard-grid">
    <div class="chart-card">
        <h4>Volume Penggunaan Meteran (7 Hari Terakhir)</h4>
        <canvas id="volumeChart"></canvas>
    </div>

    <div class="chart-card">
        <h4>Ringkasan Status Akurasi</h4>
        <canvas id="statusChart"></canvas>
    </div>
</div>

<div class="chart-card" style="margin-top: 2rem;">
    <h4>Informasi Utama</h4>
    <p>Total Pelanggan: **30**</p>
    <p>Total Laporan Hari Ini: **150**</p>
    <p>Rata-rata Error Terakhir: **2.5%**</p>
</div>

@endsection

@push('scripts')
{{-- Panggil script dashboard kita --}}
@vite(['resources/js/dashboard.js'])
@endpush