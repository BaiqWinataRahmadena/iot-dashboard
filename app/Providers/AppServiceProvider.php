<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- TAMBAHKAN BARIS INI

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // PAKSA LARAVEL UNTUK MENGGUNAKAN HTTPS UNTUK SEMUA ASET
        // Ini akan memperbaiki error "Mixed Content" di Render
        
        // Kita cek apakah env di set ke 'production' (seperti di Render)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}