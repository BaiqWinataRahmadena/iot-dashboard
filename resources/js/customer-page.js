// resources/js/customer-page.js
import L from 'leaflet';

document.addEventListener('DOMContentLoaded', () => {
    // === Inisialisasi Variabel Global ===
    const customerRows = document.querySelectorAll('.customer-list-row');
    const detailView = document.getElementById('customer-detail-view');
    const placeholderView = document.getElementById('detail-placeholder');
    const pelaporanDetailArea = document.getElementById('pelaporan-detail-area');
    const searchInput = document.getElementById('search-input');

    let map;
    let marker;

    // === 1. FUNGSI PETA ===

    // 1.1 Inisialisasi Peta
    function initMap() {
        // Inisialisasi peta di lokasi default (Jakarta)
        map = L.map('map').setView([-6.2088, 106.8456], 10); 

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(map);

        marker = L.marker([-6.2088, 106.8456]).addTo(map);
    }

    // 1.2 Update Peta (dipanggil saat pelaporan diklik)
    function updateMap(lat, lng) {
        const latLng = [lat, lng];
        map.setView(latLng, 15);
        marker.setLatLng(latLng);

        // Update info koordinat di panel detail
        document.getElementById('detail-koordinat').innerText = `${lat}, ${lng}`;
    }

    // === 2. FUNGSI PENCARIAN (Filter) ===

    function filterTable() {
        // Ambil nilai input dan ubah menjadi huruf kecil untuk perbandingan
        const filterValue = searchInput.value.toLowerCase();
        
        customerRows.forEach(row => {
            // Ambil teks dari kolom Nama (index 0) dan Alamat (index 1)
            // Pastikan row.cells ada sebelum mengakses
            if (row.cells.length > 1) {
                const nama = row.cells[0].textContent.toLowerCase();
                const alamat = row.cells[1].textContent.toLowerCase();
            
                // Periksa apakah filterValue ada di Nama ATAU Alamat
                if (nama.includes(filterValue) || alamat.includes(filterValue)) {
                    row.style.display = ''; // Tampilkan baris
                } else {
                    row.style.display = 'none'; // Sembunyikan baris
                }
            }
        });
    }

    // === 3. FUNGSI DETAIL PELAPORAN (Utility) ===

    // Fungsi utilitas untuk membuat baris detail pelaporan
    function createPelaporanDetail(data) {
        pelaporanDetailArea.innerHTML = `
            <h4>Detail Pengujian Pelaporan #${data.id}</h4>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr>
                        <th>Pengujian</th>
                        <th>Volume Awal</th>
                        <th>Volume Akhir</th>
                        <th>Selisih (A-B)</th>
                        <th>Vol. Tester</th>
                        <th>Error (%)</th>
                    </tr>
                </thead>
                <tbody>
                    ${[1, 2, 3].map(i => {
                        // Memastikan nilai tidak null sebelum parsing
                        const volAwal = parseFloat(data[`vol_awal_${i}`]) || 0;
                        const volAkhir = parseFloat(data[`vol_akhir_${i}`]) || 0;
                        const volTester = parseFloat(data[`vol_tester_${i}`]) || 0;
                        
                        // Perhitungan Selisih dan Error
                        const selisih = (volAkhir - volAwal).toFixed(3);
                        
                        // Perhitungan Error (cegah bagi 0 jika volTester 0)
                        let error = 0;
                        if (volTester !== 0) {
                            error = ((selisih - volTester) / volTester * 100).toFixed(2);
                        } else {
                            error = (selisih == 0) ? '0.00' : 'N/A';
                        }
                        
                        const errorClass = Math.abs(parseFloat(error)) > 5 ? 'status-tidak-akurat' : 'status-akurat';
                        
                        return `
                            <tr>
                                <td>Trial ${i}</td>
                                <td>${volAwal.toFixed(3)} L</td>
                                <td>${volAkhir.toFixed(3)} L</td>
                                <td>${selisih} L</td>
                                <td>${volTester.toFixed(3)} L</td>
                                <td><span class="${errorClass}">${error}%</span></td>
                            </tr>
                        `;
                    }).join('')}
                </tbody>
            </table>
            <p style="margin-top: 15px;"><strong>Lokasi Pengukuran:</strong> ${data.lokasi_pengukuran}</p>
        `;
    }

    // === 4. FUNGSI UTAMA (AJAX & Update Tampilan) ===

    // 4.1 Mengambil data detail pelanggan
    async function fetchCustomerDetails(id) {
        try {
            const response = await fetch(`/pelanggan/details/${id}`);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const data = await response.json();
            updateDetails(data);
        } catch (error) {
            console.error('Error fetching customer details:', error);
            alert('Gagal memuat data pelanggan.');
        }
    }
    
    // 4.2 Mengisi detail pelanggan dan daftar pelaporan
    function updateDetails(pelanggan) {
        // Tampilkan detail, sembunyikan placeholder
        placeholderView.style.display = 'none';
        detailView.style.display = 'flex';

        // Update Info Dasar Pelanggan
        document.getElementById('detail-nama').innerText = pelanggan.nama;
        document.getElementById('detail-status').innerText = pelanggan.status;
        document.getElementById('detail-no_ktp').innerText = pelanggan.no_ktp || '-';
        document.getElementById('detail-telepon').innerText = pelanggan.telepon || '-';
        document.getElementById('detail-pekerjaan').innerText = pelanggan.pekerjaan || '-';
        document.getElementById('detail-keterangan').innerText = pelanggan.keterangan || '-';
        document.getElementById('detail-alamat').innerText = pelanggan.alamat;
        // Koordinat diset ke 'Pilih Pelaporan' sampai ada yang diklik
        document.getElementById('detail-koordinat').innerText = 'Pilih Pelaporan'; 

        // Update Daftar Pelaporan (Riwayat)
        const checkListBody = document.getElementById('check-list-body');
        checkListBody.innerHTML = ''; // Kosongkan daftar lama
        pelaporanDetailArea.innerHTML = ''; // Kosongkan detail pelaporan
        
        // Pindahkan Peta ke lokasi default sampai pelaporan dipilih
        updateMap(-6.2088, 106.8456); // Set peta ke Jakarta

        if (pelanggan.pelaporan.length > 0) {
            // Tampilkan data pelaporan
            pelanggan.pelaporan.forEach((pelaporan) => {
                const avgError = parseFloat(pelaporan.rata_rata_error);
                const statusClass = Math.abs(avgError) > 5 ? 'status-tidak-akurat' : 'status-akurat';
                const displayError = `${avgError.toFixed(2)}%`;
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${new Date(pelaporan.tanggal_baca).toLocaleDateString('id-ID')}</td>
                    <td>${pelaporan.petugas}</td>
                    <td>${pelaporan.lokasi_pengukuran}</td>
                    <td><span class="${statusClass}">${displayError}</span></td>
                `;
                row.style.cursor = 'pointer';
                
                // Tambahkan event listener untuk melihat detail pelaporan
                row.addEventListener('click', () => {
                    // Hapus seleksi baris lain (visual)
                    document.querySelectorAll('#check-list-body tr').forEach(r => r.style.fontWeight = 'normal');
                    row.style.fontWeight = 'bold';
                    createPelaporanDetail(pelaporan);
                    // Panggil update peta
                    updateMap(pelaporan.latitude, pelaporan.longitude);
                });
                
                checkListBody.appendChild(row);
            });
            // Panggil detail untuk baris pertama secara default
            // Memastikan baris pertama ada sebelum diklik
            const firstRow = document.querySelector('#check-list-body tr');
            if (firstRow) {
                firstRow.click(); 
            }

        } else {
            checkListBody.innerHTML =
                '<tr><td colspan="4">Tidak ada data pelaporan hasil baca.</td></tr>';
        }
    }

    // === 5. SETUP AWAL (Event Listener & Inisialisasi) ===
    
    // 5.1 Inisialisasi Peta
    detailView.style.display = 'none';
    initMap();

    // 5.2 Listener Pencarian (Hanya dipanggil sekali)
    if (searchInput) {
        searchInput.addEventListener('keyup', filterTable);
        searchInput.addEventListener('change', filterTable);
    }

    // 5.3 Listener Klik Baris Pelanggan
    customerRows.forEach((row) => {
        row.addEventListener('click', () => {
            // Hapus 'selected' dari baris lain
            customerRows.forEach(r => r.classList.remove('selected'));
            // Tambahkan 'selected' ke baris ini
            row.classList.add('selected');

            const customerId = row.dataset.id;
            fetchCustomerDetails(customerId);
        });
    });
});