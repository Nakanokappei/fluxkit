import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'node:path';

// Playground Vite config. Runs the dev server inside the container; the browser (host) loads it from localhost:5173.
// fluxkit's CSS, JS and views live outside this app (/fluxkit), so that path is added to the allowed locations.
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: ['resources/views/**', '../../resources/views/**'],
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: { host: 'localhost' },
        cors: true,
        fs: { allow: [resolve(__dirname, '../..')] },
    },
});
