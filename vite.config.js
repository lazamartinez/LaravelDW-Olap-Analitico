import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
            '~': path.resolve(__dirname, './node_modules'),
            'vue': 'vue/dist/vue.esm-bundler.js'
        },
    },
    server: {
        host: true, // Cambiado de '0.0.0.0' a true
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost',
            protocol: 'ws',
            port: 5173
        },
        watch: {
            usePolling: true,
            interval: 1000
        },
        cors: true,
        origin: 'http://localhost:5173'
    },
    build: {
        manifest: true,
        outDir: 'public/build',
        emptyOutDir: true,
        rollupOptions: {
            input: {
                app: path.resolve(__dirname, 'resources/js/app.js')
            },
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@import "./resources/scss/variables";`
            }
        }
    }
});
