import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'public/assets/scss/soft-ui-dashboard.scss',
                'resources/css/app.css',
                'public/assets/js/page-scriptpt.js',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
