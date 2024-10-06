import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/partials.css',  'resources/js/toasts.js', 'resources/js/documentsChart.js','resources/css/graficos.css'],
            refresh: true,
        }),
    ],
});
