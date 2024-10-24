import { createApp } from "vue";
import router from "./router";
import store from './stores/index';
import App from "./components/App.vue";
import { VueReCaptcha } from 'vue-recaptcha-v3';
// Set axios with common header
import axios from 'axios';

const token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  axios.interceptors.request.use((config) => {
    // Initialize headers and common if they don't exist
    config.headers = config.headers || {};

    // Check if the URL is relative and doesn't start with http(s)://
    if (!/^(http|https):\/\//.test(config.url)) {
      config.headers.common = config.headers.common || {};
      config.headers.common['X-CSRF-TOKEN'] = token.content;
    }
    return config;
  }, (error) => {
    return Promise.reject(error);
  });
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios = axios;

// Create Vue app
const app = createApp(App);

// Use router
app.use(router);
app.use(store);
app.use(VueReCaptcha, { siteKey: '6LdtJ2oqAAAAAL8q_A4fD3SsYRDL4Obq34tqbAO5' });

// Mount the app
router.isReady().then(() => {
  store.dispatch('checkLoginStatus').finally(() => {
    app.mount("#app");
  });
});