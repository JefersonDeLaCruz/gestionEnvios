import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    server: {
        host: '0.0.0.0',     // <--- Permite conexiones externas (Docker)
        port: 5173,          // <--- Fijamos el puerto
        strictPort: true,    // <--- Evita puertos aleatorios
        hmr: {
            host: 'localhost',   // <--- Importante para el navegador
        },
    },
    
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
