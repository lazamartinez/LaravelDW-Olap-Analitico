import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: [
                'resources/views/**',
                'resources/js/**',
                'routes/**',
            ]
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
            '@': path.resolve(__dirname, './resources'),
            '~': path.resolve(__dirname, './node_modules'),
            'vue': 'vue/dist/vue.esm-bundler.js'
        },
    },
    server: {
        host: '0.0.0.0',
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
        // Configuración de proxy crítica para las API calls
        proxy: {
            '/api': {
                target: 'http://webserver:80', // Usamos el nombre del servicio de nginx
                changeOrigin: true,
                secure: false,
                rewrite: (path) => path.replace(/^\/api/, '/api')
            },
            '/sanctum': {
                target: 'http://webserver:80',
                changeOrigin: true,
                secure: false
            }
        }
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
                additionalData: `
                    @use "@/scss/variables" as *;
                    @use "@/scss/mixins" as *;
                `,
                quietDeps: true
            }
        }
    }
});