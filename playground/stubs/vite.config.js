import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { resolve } from 'node:path';

// プレイグラウンドの Vite。コンテナの中で開発サーバーを開き、ブラウザ (ホスト) からは localhost:5173 で読む。
// fluxkit の CSS・JS・ビューはこのアプリの外 (/fluxkit) にあるので、読んでよい場所に足す。
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
