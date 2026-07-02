import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import livewire from "@defstudio/vite-livewire-plugin";

export default defineConfig({
    server: {
        host: '127.0.0.1',
        port: 5175,
        strictPort: true,
        hmr: {
            host: '127.0.0.1',
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: false,
        }),
        livewire({  // <-- add livewire plugin
            refresh: ['resources/css/app.css'],  // <-- will refresh css (tailwind ) as well
        }),
    ],

});
