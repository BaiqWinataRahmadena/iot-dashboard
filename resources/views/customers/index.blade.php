@extends('layouts.main')

@section('header', 'Pelanggan')

@push('styles')
<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>
@vite(['resources/css/customer-page.css'])
@endpush

@section('content')
<div class="customer-layout">
  <div class="customer-list-container">
    <div class="customer-list-header">Daftar Pelanggan</div>

    <div style="padding: 10px 20px; border-bottom: 1px solid var(--border-light);">
      <input type="text" 
            id="search-input" 
            placeholder="Cari Nama atau Alamat..."
            style="width: 100%; padding: 8px; border: 1px solid var(--border-light); border-radius: 4px; background-color: var(--sidebar-bg-light); color: var(--text-light);" />
    </div>

    <div class="customer-list">
      <table>
        <thead>
          <tr>
            <th>Nama</th>
            <th>Alamat</th>
          </tr>
        </thead>
        <tbody>
          {{-- Ingat: Di Controller, kita menggunakan variabel $customers --}}
          @foreach ($customers as $pelanggan)
          <tr class="customer-list-row" data-id="{{ $pelanggan->id }}">
            <td>{{ $pelanggan->nama }}</td>
            <td>{{ Str::limit($pelanggan->alamat, 40) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="customer-detail-container">
    
    <div id="detail-placeholder">
      <p>Silakan pilih pelanggan dari daftar di sebelah kiri.</p>
    </div>

    <div
      id="customer-detail-view"
      style="display: none; flex-direction: column; gap: 1.5rem"
    >
      <div class="detail-card">
        <h3>Detail Pelanggan</h3>
        <p>
          <strong>Nama:</strong>
          <span id="detail-nama"></span>
        </p>
        <p>
          <strong>Status:</strong>
          <span id="detail-status"></span>
        </p>
        <p>
          <strong>No. KTP:</strong>
          <span id="detail-no_ktp"></span>
        </p>
        <p>
          <strong>Telepon:</strong>
          <span id="detail-telepon"></span>
        </p>
        <p>
          <strong>Pekerjaan:</strong>
          <span id="detail-pekerjaan"></span>
        </p>
        <p>
          <strong>Keterangan:</strong>
          <span id="detail-keterangan"></span>
        </p>
        <p>
          <strong>Alamat:</strong>
          <span id="detail-alamat"></span>
        </p>
        <p>
          <strong>Koordinat:</strong>
          <span id="detail-koordinat"></span>
        </p>
      </div>

      <div class="detail-card">
        <h3>Lokasi Peta (OpenStreetMap)</h3>
        <div id="map"></div>
      </div>

      <div class="detail-card check-list">
        <h3>Riwayat Pelaporan Hasil Baca</h3>
        <table>
          <thead>
            <tr>
              <th>Tanggal Baca</th>
              <th>Petugas</th>
              <th>Lokasi Ukur</th>
              <th>Rata-rata Error</th>
            </tr>
          </thead>
          <tbody id="check-list-body">
            </tbody>
        </table>
        
        <div id="pelaporan-detail-area" style="margin-top: 1.5rem; border-top: 1px solid var(--border-light); padding-top: 1rem;">
            </div>
        
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/customer-page.js'])
@endpush