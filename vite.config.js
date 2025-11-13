// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/custom-layout.css', 
                'resources/js/custom-layout.js',  
                'resources/css/customer-page.css', 
                'resources/js/customer-page.js',
                'resources/js/dashboard.js',
            ],
            refresh: true,
        }),
    ],
});