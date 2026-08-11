import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import livewire from "@defstudio/vite-livewire-plugin";
import { copyFileSync, existsSync, mkdirSync } from 'fs';
import { resolve } from 'path';

export default defineConfig({
    server: {
        host: '127.0.0.1',
        port: 5174,
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
        {
            name: 'copy-rich-content-plugins',
            writeBundle() {
                const sourceDir = resolve(__dirname, 'resources/js/filament/rich-content-plugins');
                const targetDir = resolve(__dirname, 'public/js/app/rich-content-plugins');

                if (!existsSync(targetDir)) {
                    mkdirSync(targetDir, { recursive: true });
                }

                const files = ['tooltip.js', 'text-color.js', 'checkmark.js'];
                files.forEach(file => {
                    const sourceFile = resolve(sourceDir, file);
                    const targetFile = resolve(targetDir, file);
                    if (existsSync(sourceFile)) {
                        copyFileSync(sourceFile, targetFile);
                    }
                });
            }
        }
    ],

});
