import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    // server: {
    //     host: '192.168.43.247', // Permet l'accès depuis d'autres appareils
    //     port: 3000,      // Port sur lequel Vite écoutera
    //     strictPort: true, // Échoue si le port est déjà utilisé
    // },
});
