import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
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
            '@': path.resolve(__dirname, 'resources/js'),
            '~': path.resolve(__dirname, 'node_modules'),
            vue: 'vue/dist/vue.esm-bundler.js'
        },
    },
    build: {
        manifest: true,
        rollupOptions: {
            input: 'resources/js/app.js'
        }
    },
    css: {
        preprocessorOptions: {
          scss: {
            additionalData: `@import "./resources/scss/_variables.scss";`
          }
        }
    },
    server: {
        host: '0.0.0.0',  // <- Escucha en todas las interfaces
        port: 5173,       // <- Puerto que expusiste en docker-compose
        strictPort: true, // <- Para que no cambie automáticamente el puerto si está ocupado
    }
})
