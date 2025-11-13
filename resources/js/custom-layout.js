// resources/js/custom-layout.js

// Fungsi untuk Mode Gelap
function initTheme() {
  const themeToggle = document.getElementById('theme-toggle');
  const body = document.body;

  // 1. Cek preferensi tersimpan di localStorage
  const savedTheme = localStorage.getItem('theme');
  if (savedTheme === 'dark') {
    body.classList.add('dark');
    themeToggle.innerText = 'Mode Terang';
  } else {
    body.classList.remove('dark');
    themeToggle.innerText = 'Mode Gelap';
  }

  // 2. Buat event listener
  themeToggle.addEventListener('click', () => {
    body.classList.toggle('dark');
    if (body.classList.contains('dark')) {
      localStorage.setItem('theme', 'dark');
      themeToggle.innerText = 'Mode Terang';
    } else {
      localStorage.setItem('theme', 'light');
      themeToggle.innerText = 'Mode Gelap';
    }
  });
}

// Fungsi untuk Dropdown Profil
function initProfileDropdown() {
  const profileButton = document.getElementById('profile-button');
  const dropdownMenu = document.getElementById('dropdown-menu');

  if (profileButton) {
    profileButton.addEventListener('click', (e) => {
      e.stopPropagation(); // Hentikan event agar tidak ditangkap window
      dropdownMenu.classList.toggle('show');
    });

    // Klik di luar dropdown akan menutupnya
    window.addEventListener('click', () => {
      if (dropdownMenu.classList.contains('show')) {
        dropdownMenu.classList.remove('show');
      }
    });

    // Jangan tutup jika diklik di dalam menu
    dropdownMenu.addEventListener('click', (e) => {
      e.stopPropagation();
    });
  }
}

// Jalankan kedua fungsi saat DOM siap
document.addEventListener('DOMContentLoaded', () => {
  initTheme();
  initProfileDropdown();
});