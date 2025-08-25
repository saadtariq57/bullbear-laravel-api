// vite.config.js
import { defineConfig } from "file:///C:/xampp/htdocs/richtv/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/xampp/htdocs/richtv/node_modules/laravel-vite-plugin/dist/index.mjs";
import vue from "file:///C:/xampp/htdocs/richtv/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import { viteStaticCopy } from "file:///C:/xampp/htdocs/richtv/node_modules/vite-plugin-static-copy/dist/index.js";
import commonjs from "file:///C:/xampp/htdocs/richtv/node_modules/vite-plugin-commonjs/dist/index.mjs";
var vite_config_default = defineConfig({
  build: {
    manifest: true,
    rtl: true,
    outDir: "public/build/",
    cssCodeSplit: true,
    rollupOptions: {
      output: {
        assetFileNames: (css) => {
          if (css.name.split(".").pop() == "css") {
            return `css/[name].min.css`;
          } else {
            return "icons/" + css.name;
          }
        },
        entryFileNames: `js/[name].js`
      }
    }
  },
  server: {
    watch: {
      // Watch for all changes in the resources folder
      include: "resources/**/*",
      // Exclude the node_modules directory
      exclude: "node_modules/**/*"
    }
  },
  plugins: [
    laravel({
      input: [
        "resources/scss/app.scss",
        "resources/scss/bootstrap.scss",
        "resources/scss/icons.scss",
        "resources/css/frontend.css",
        "resources/css/slick.css",
        "resources/css/slick-theme.css",
        "resources/js/main.js",
        "resources/js/admin.js"
      ],
      refresh: true
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        }
      }
    }),
    commonjs(),
    viteStaticCopy({
      targets: [
        {
          src: "resources/fonts",
          dest: ""
        },
        {
          src: "resources/images",
          dest: ""
        },
        { src: "resources/js/libs/jquery.min.js", dest: "libs/jquery" },
        { src: "resources/js/libs/bootstrap.bundle.min.js", dest: "libs/bootstrap/js" },
        { src: "resources/js/slick.min.js", dest: "js" },
        { src: "resources/js/custom.js", dest: "js" },
        {
          src: "resources/libs",
          dest: ""
        }
      ]
    })
  ],
  resolve: {
    alias: {
      vue: "vue/dist/vue.esm-bundler.js"
    }
  },
  optimizeDeps: {
    entries: "resources/js/main.js"
  }
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFx4YW1wcFxcXFxodGRvY3NcXFxccmljaHR2XCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ZpbGVuYW1lID0gXCJDOlxcXFx4YW1wcFxcXFxodGRvY3NcXFxccmljaHR2XFxcXHZpdGUuY29uZmlnLmpzXCI7Y29uc3QgX192aXRlX2luamVjdGVkX29yaWdpbmFsX2ltcG9ydF9tZXRhX3VybCA9IFwiZmlsZTovLy9DOi94YW1wcC9odGRvY3MvcmljaHR2L3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB2dWUgZnJvbSAnQHZpdGVqcy9wbHVnaW4tdnVlJzsgXG5pbXBvcnQgeyB2aXRlU3RhdGljQ29weSB9IGZyb20gJ3ZpdGUtcGx1Z2luLXN0YXRpYy1jb3B5JztcbmltcG9ydCBjb21tb25qcyBmcm9tICd2aXRlLXBsdWdpbi1jb21tb25qcyc7IFxuXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xuICAgIGJ1aWxkOiB7XG4gICAgICAgIG1hbmlmZXN0OiB0cnVlLFxuICAgICAgICBydGw6IHRydWUsXG4gICAgICAgIG91dERpcjogJ3B1YmxpYy9idWlsZC8nLFxuICAgICAgICBjc3NDb2RlU3BsaXQ6IHRydWUsXG4gICAgICAgIHJvbGx1cE9wdGlvbnM6IHtcbiAgICAgICAgICAgIG91dHB1dDoge1xuICAgICAgICAgICAgICAgIGFzc2V0RmlsZU5hbWVzOiAoY3NzKSA9PiB7XG4gICAgICAgICAgICAgICAgICAgIGlmIChjc3MubmFtZS5zcGxpdCgnLicpLnBvcCgpID09ICdjc3MnKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gJ2Nzcy8nICsgYFtuYW1lXWAgKyAnLm1pbi4nICsgJ2Nzcyc7XG4gICAgICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgICAgICByZXR1cm4gJ2ljb25zLycgKyBjc3MubmFtZTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAgZW50cnlGaWxlTmFtZXM6ICdqcy8nICsgYFtuYW1lXWAgKyBgLmpzYCxcbiAgICAgICAgICAgIH0sXG4gICAgICAgIH0sXG4gICAgfSxcbiAgICBzZXJ2ZXI6IHtcbiAgICAgICAgd2F0Y2g6IHtcbiAgICAgICAgICAgIC8vIFdhdGNoIGZvciBhbGwgY2hhbmdlcyBpbiB0aGUgcmVzb3VyY2VzIGZvbGRlclxuICAgICAgICAgICAgaW5jbHVkZTogJ3Jlc291cmNlcy8qKi8qJyxcbiAgICAgICAgICAgIC8vIEV4Y2x1ZGUgdGhlIG5vZGVfbW9kdWxlcyBkaXJlY3RvcnlcbiAgICAgICAgICAgIGV4Y2x1ZGU6ICdub2RlX21vZHVsZXMvKiovKidcbiAgICAgICAgfSxcbiAgICB9LFxuICAgIHBsdWdpbnM6IFtcbiAgICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgICBpbnB1dDogW1xuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvc2Nzcy9hcHAuc2NzcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9zY3NzL2Jvb3RzdHJhcC5zY3NzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL3Njc3MvaWNvbnMuc2NzcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9jc3MvZnJvbnRlbmQuY3NzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2Nzcy9zbGljay5jc3MnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvY3NzL3NsaWNrLXRoZW1lLmNzcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9tYWluLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2FkbWluLmpzJyxcbiAgICAgICAgICAgIF0sXG4gICAgICAgICAgICByZWZyZXNoOiB0cnVlLFxuICAgICAgICB9KSxcbiAgICAgICAgdnVlKHsgXG4gICAgICAgICAgICB0ZW1wbGF0ZToge1xuICAgICAgICAgICAgICAgIHRyYW5zZm9ybUFzc2V0VXJsczoge1xuICAgICAgICAgICAgICAgICAgICBiYXNlOiBudWxsLFxuICAgICAgICAgICAgICAgICAgICBpbmNsdWRlQWJzb2x1dGU6IGZhbHNlLFxuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICB9LFxuICAgICAgICB9KSxcbiAgICAgICAgY29tbW9uanMoKSxcbiAgICAgICAgdml0ZVN0YXRpY0NvcHkoe1xuICAgICAgICAgICAgdGFyZ2V0czogW1xuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc3JjOiAncmVzb3VyY2VzL2ZvbnRzJyxcbiAgICAgICAgICAgICAgICAgICAgZGVzdDogJydcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc3JjOiAncmVzb3VyY2VzL2ltYWdlcycsXG4gICAgICAgICAgICAgICAgICAgIGRlc3Q6ICcnXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICB7IHNyYzogJ3Jlc291cmNlcy9qcy9saWJzL2pxdWVyeS5taW4uanMnLCBkZXN0OiAnbGlicy9qcXVlcnknIH0sXG4gICAgICAgICAgICAgICAgeyBzcmM6ICdyZXNvdXJjZXMvanMvbGlicy9ib290c3RyYXAuYnVuZGxlLm1pbi5qcycsIGRlc3Q6ICdsaWJzL2Jvb3RzdHJhcC9qcycgfSxcbiAgICAgICAgICAgICAgICB7IHNyYzogJ3Jlc291cmNlcy9qcy9zbGljay5taW4uanMnLCBkZXN0OiAnanMnIH0sXG4gICAgICAgICAgICAgICAgeyBzcmM6ICdyZXNvdXJjZXMvanMvY3VzdG9tLmpzJywgZGVzdDogJ2pzJyB9LFxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc3JjOiAncmVzb3VyY2VzL2xpYnMnLFxuICAgICAgICAgICAgICAgICAgICBkZXN0OiAnJ1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBdXG4gICAgICAgIH0pLFxuICAgIF0sXG4gICAgcmVzb2x2ZTogeyBcbiAgICAgICAgYWxpYXM6IHtcbiAgICAgICAgICAgIHZ1ZTogJ3Z1ZS9kaXN0L3Z1ZS5lc20tYnVuZGxlci5qcycsXG4gICAgICAgIH0sXG4gICAgfSxcbiAgICBvcHRpbWl6ZURlcHM6IHtcbiAgICAgICAgZW50cmllczogJ3Jlc291cmNlcy9qcy9tYWluLmpzJyxcbiAgICB9LFxufSk7XG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQTRQLFNBQVMsb0JBQW9CO0FBQ3pSLE9BQU8sYUFBYTtBQUNwQixPQUFPLFNBQVM7QUFDaEIsU0FBUyxzQkFBc0I7QUFDL0IsT0FBTyxjQUFjO0FBRXJCLElBQU8sc0JBQVEsYUFBYTtBQUFBLEVBQ3hCLE9BQU87QUFBQSxJQUNILFVBQVU7QUFBQSxJQUNWLEtBQUs7QUFBQSxJQUNMLFFBQVE7QUFBQSxJQUNSLGNBQWM7QUFBQSxJQUNkLGVBQWU7QUFBQSxNQUNYLFFBQVE7QUFBQSxRQUNKLGdCQUFnQixDQUFDLFFBQVE7QUFDckIsY0FBSSxJQUFJLEtBQUssTUFBTSxHQUFHLEVBQUUsSUFBSSxLQUFLLE9BQU87QUFDcEMsbUJBQU87QUFBQSxVQUNYLE9BQU87QUFDSCxtQkFBTyxXQUFXLElBQUk7QUFBQSxVQUMxQjtBQUFBLFFBQ0o7QUFBQSxRQUNBLGdCQUFnQjtBQUFBLE1BQ3BCO0FBQUEsSUFDSjtBQUFBLEVBQ0o7QUFBQSxFQUNBLFFBQVE7QUFBQSxJQUNKLE9BQU87QUFBQTtBQUFBLE1BRUgsU0FBUztBQUFBO0FBQUEsTUFFVCxTQUFTO0FBQUEsSUFDYjtBQUFBLEVBQ0o7QUFBQSxFQUNBLFNBQVM7QUFBQSxJQUNMLFFBQVE7QUFBQSxNQUNKLE9BQU87QUFBQSxRQUNIO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLE1BQ0o7QUFBQSxNQUNBLFNBQVM7QUFBQSxJQUNiLENBQUM7QUFBQSxJQUNELElBQUk7QUFBQSxNQUNBLFVBQVU7QUFBQSxRQUNOLG9CQUFvQjtBQUFBLFVBQ2hCLE1BQU07QUFBQSxVQUNOLGlCQUFpQjtBQUFBLFFBQ3JCO0FBQUEsTUFDSjtBQUFBLElBQ0osQ0FBQztBQUFBLElBQ0QsU0FBUztBQUFBLElBQ1QsZUFBZTtBQUFBLE1BQ1gsU0FBUztBQUFBLFFBQ0w7QUFBQSxVQUNJLEtBQUs7QUFBQSxVQUNMLE1BQU07QUFBQSxRQUNWO0FBQUEsUUFDQTtBQUFBLFVBQ0ksS0FBSztBQUFBLFVBQ0wsTUFBTTtBQUFBLFFBQ1Y7QUFBQSxRQUNBLEVBQUUsS0FBSyxtQ0FBbUMsTUFBTSxjQUFjO0FBQUEsUUFDOUQsRUFBRSxLQUFLLDZDQUE2QyxNQUFNLG9CQUFvQjtBQUFBLFFBQzlFLEVBQUUsS0FBSyw2QkFBNkIsTUFBTSxLQUFLO0FBQUEsUUFDL0MsRUFBRSxLQUFLLDBCQUEwQixNQUFNLEtBQUs7QUFBQSxRQUM1QztBQUFBLFVBQ0ksS0FBSztBQUFBLFVBQ0wsTUFBTTtBQUFBLFFBQ1Y7QUFBQSxNQUNKO0FBQUEsSUFDSixDQUFDO0FBQUEsRUFDTDtBQUFBLEVBQ0EsU0FBUztBQUFBLElBQ0wsT0FBTztBQUFBLE1BQ0gsS0FBSztBQUFBLElBQ1Q7QUFBQSxFQUNKO0FBQUEsRUFDQSxjQUFjO0FBQUEsSUFDVixTQUFTO0FBQUEsRUFDYjtBQUNKLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
