import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

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
    assetsInclude: ['**/*.PNG', '**/*.JPG'],
    test: {
        include: ['**/*Test.test.js'],
    },
    resolve: {
        alias: {
            '@vue/test-utils': '@vue/test-utils/dist/vue-test-utils.esm-bundler.js',
            '@': '/resources/js',
            'ziggy-js': path.resolve('vendor/tightenco/ziggy'),
        },
    },
});
