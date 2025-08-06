import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/scss/app.scss' // Asegura que procese tu SCSS
            ],
            refresh: [
                'resources/views/**',
                'resources/js/**',
                'resources/css/**',
                'routes/**'
            ]
        }),
        vue({
            template: {
                transformAssetUrls: {
                    // Permite que Vite procese las URLs en plantillas Vue
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
            'scss': path.resolve(__dirname, './resources/scss'),
            'vue': 'vue/dist/vue.esm-bundler.js',
            // Alias críticos para MDB y FontAwesome
            'mdb-vue-ui-kit': path.resolve(__dirname, 'node_modules/mdb-vue-ui-kit'),
            '@fortawesome': path.resolve(__dirname, 'node_modules/@fortawesome')
        },
        extensions: ['.js', '.vue', '.json', '.scss']
    },
    optimizeDeps: {
        include: [
            'vue',
            'mdb-vue-ui-kit',
            '@fortawesome/fontawesome-free',
            'axios'
        ],
        exclude: [
            'jsdom' // Excluye dependencias que no necesitan optimización
        ]
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
        proxy: {
            '/api': {
                target: 'http://webserver:80',
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
            input: path.resolve(__dirname, 'resources/js/app.js'),
            output: {
                manualChunks: {
                    // Separa los chunks para mejor performance
                    mdb: ['mdb-vue-ui-kit'],
                    fontawesome: ['@fortawesome/fontawesome-free'],
                    vendor: ['vue', 'axios', 'vue-router']
                }
            },
            external: [] // Asegúrate de no excluir accidentalmente dependencias necesarias
        },
        chunkSizeWarningLimit: 1000 // Aumenta el límite de advertencia de tamaño
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `
                    @use "sass:math";
                `,
                quietDeps: true,
                importer: (url) => {
                    if (url.startsWith('~')) {
                        return { file: path.resolve(__dirname, 'node_modules', url.substr(1)) };
                    }
                    return null;
                }
            }
        },
        postcss: {
            plugins: [
                require('autoprefixer')({
                    overrideBrowserslist: ['last 2 versions', '> 1%', 'IE 10']
                })
            ]
        }
    },
    esbuild: {
        jsxFactory: 'h',
        jsxFragment: 'Fragment',
        target: 'es2020'
    }
});