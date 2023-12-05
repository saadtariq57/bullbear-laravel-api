import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy';

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
        }
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
            ],
            refresh: true,
        }),
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
                {
                    src: 'resources/js',
                    dest: ''
                },
                {
                    src: 'resources/libs',
                    dest: ''
                },
            ]
        }),
    ],
});
