import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'; 
import { viteStaticCopy } from 'vite-plugin-static-copy';
import commonjs from 'vite-plugin-commonjs'; 

export default defineConfig({
    build: {
        manifest: true,
        rtl: true,
        outDir: 'public/build/',
        cssCodeSplit: true,
        rollupOptions: {
            output: {
                assetFileNames: (css) => {
                    if (css.name.split('.').pop() == 'css') {
                        return 'css/' + `[name]` + '.min.' + 'css';
                    } else {
                        return 'icons/' + css.name;
                    }
                },
                entryFileNames: 'js/' + `[name]` + `.js`,
            },
        },
    },
    server: {
        watch: {
            // Watch for all changes in the resources folder
            include: 'resources/**/*',
            // Exclude the node_modules directory
            exclude: 'node_modules/**/*'
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/scss/bootstrap.scss',
                'resources/scss/icons.scss',
                'resources/css/frontend.css',
                'resources/css/slick.css',
                'resources/css/slick-theme.css',
                'resources/js/main.js',
                'resources/js/admin.js',
            ],
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
        commonjs(),
        viteStaticCopy({
            targets: [
                {
                    src: 'resources/fonts',
                    dest: ''
                },
                {
                    src: 'resources/images',
                    dest: ''
                },
                { src: 'node_modules/jquery/dist/jquery.min.js', dest: 'libs/jquery' },
                { src: 'node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', dest: 'libs/bootstrap/js' },
                { src: 'resources/js/slick.min.js', dest: 'js' },
                { src: 'resources/js/custom.js', dest: 'js' },
                {
                    src: 'resources/libs',
                    dest: ''
                },
            ]
        }),
    ],
    resolve: { 
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    optimizeDeps: {
        entries: 'resources/js/main.js',
    },
});
