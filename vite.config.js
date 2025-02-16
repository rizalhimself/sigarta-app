import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: "0.0.0.0",  // Agar bisa diakses dari IP lain
        port: 5173,       // Port default Vite
        strictPort: true,  // Pastikan selalu menggunakan port ini
        cors: true,        // 🛠️ Ini penting untuk mengizinkan CORS!
        },
        hmr: {
            host: '192.168.100.7',
        },
    },
);
